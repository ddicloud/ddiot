<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-03 19:48:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-07-07 17:03:23
 */

namespace common\plugins\diandi_hub\models\goods;

use common\helpers\ErrorsHelper;
use common\helpers\StringHelper as HelpersStringHelper;

/**
 * This is the model class for table "dd_goods_spec".
 *
 * @public int    $goods_spec_id
 * @public int    $goods_id
 * @public string $goods_no
 * @public float  $goods_price
 * @public float  $line_price
 * @public int    $stock_num
 * @public int    $goods_sales
 * @public float  $goods_weight
 * @public int    $wxapp_id
 * @public string $spec_sku_id
 * @public int    $create_time
 * @public int    $update_time
 */
class HubGoodsBaseSpec extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_basegoods_spec}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['goods_id', 'bloc_id', 'store_id', 'stock_num', 'goods_sales', 'create_time', 'update_time'], 'integer'],
            [['goods_price', 'line_price', 'goods_weight', 'goods_costprice'], 'number'],
            [['goods_no', 'spec_item_thumb'], 'string', 'max' => 100],
            [['spec_sku_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * 行为.
     */
    public function behaviors()
    {
        /*自动添加创建和修改时间*/
        return [
            [
                'class' => \common\behaviors\SaveBehavior::class,
                'updatedAttribute' => 'update_time',
                'createdAttribute' => 'create_time',
            ],
        ];
    }

    /**
     * 获取属性关联关系.
     *
     * @param int|null post
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function getGoodsSpecRel()
    {
        return $this->hasOne(HubGoodsBaseSpecRel::class, ['id' => 'spec_sku_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'goods_spec_id' => 'Goods Spec ID',
            'goods_id' => 'Goods ID',
            'goods_no' => 'Goods No',
            'goods_price' => 'Goods Price',
            'line_price' => 'Line Price',
            'stock_num' => 'Stock Num',
            'goods_sales' => 'Goods Sales',
            'goods_weight' => 'Goods Weight',
            'wxapp_id' => 'Wxapp ID',
            'spec_sku_id' => 'Spec Sku ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'goods_costprice' => '成本价格',
        ];
    }

    /**
     * 更新SKU
     * @param int $goodsId
     * @param array $goodsSpec
     * @param array $spec
     * @return bool
     * @date 2022-07-05
     * @example
     * @author Radish
     * @since
     */
    public static function saveData($goodsId, $goodsSpec, $spec): bool
    {
        $spec = array_column($spec, null, 'spec_value_id');
        $specVal = HubSpecValue::find()->andWhere(['spec_value_id' => array_keys($spec)])->all();
        if (!$specVal) {
            ErrorsHelper::throwError(false, '无效的商品规则');
        } else {
            $combinationSpec = $specValIds = [];
            foreach ($specVal as $row) {
                $combinationSpec[$row->spec_id][$row->spec_value_id] = $row->spec_value_id;
                $specValIds[$row->spec_value_id] = $row->spec_id;
            }
            $transaction = self::getDb()->beginTransaction();
            $specSkuIds = self::cartesianProduct($combinationSpec);
            try {
                self::_saveGoodsBaseSpecRel($specValIds, $goodsId, $spec);
                self::_saveGoodsBaseSpec($goodsSpec, $goodsId, $specSkuIds);
                $transaction->commit();
                return true;
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
                ErrorsHelper::throwError(false, $e->getMessage());
            }
        }
        return false;
    }

    private static function _saveGoodsBaseSpec($goodsSpec, $goodsId, $specSkuIds)
    {
        HubGoodsBaseSpec::deleteAll('goods_id = ' . $goodsId . ' and spec_sku_id not in ("' . implode('","', $specSkuIds) . '")');
        $rootQuery = HubGoodsBaseSpec::find();
        foreach ($specSkuIds as $specSkuId) {
            if (!isset($goodsSpec[$specSkuId])) {
                ErrorsHelper::throwError(false, "缺少商品SKU:" . $specSkuId);
            } else {
                $query = clone $rootQuery;
                $model = $query->andWhere([
                    'goods_id' => $goodsId,
                    'spec_sku_id' => $specSkuId,
                ])->one();
                if (!$model) {
                    $model = new HubGoodsBaseSpec;
                }
                $spec = $goodsSpec[$specSkuId];
                $data = [
                    'goods_id' => $goodsId,
                    'goods_no' => $spec['goods_no'] ?: $goodsId,
                    'goods_price' => HelpersStringHelper::currency_format($spec['goods_price']),
                    'line_price' => HelpersStringHelper::currency_format($spec['line_price']),
                    'stock_num' => intval($spec['stock_num']),
                    'goods_costprice' => HelpersStringHelper::currency_format($spec['goods_costprice']),
                    'goods_weight' => intval($spec['goods_weight']),
                    'spec_item_thumb' => $spec['spec_item_thumb'],
                    'spec_sku_id' => $specSkuId . '',
                    'create_time' => time(),
                ];
                $model->setAttributes($data);
                ErrorsHelper::throwError($model->save(), '保存商品SKU失败！ msg: ' . implode(',', $model->getFirstErrors()));
            }
        }
    }

    private static function _saveGoodsBaseSpecRel($specValIdsMap, $goodsId, $spec)
    {
        HubGoodsBaseSpecRel::deleteAll('goods_id = ' . $goodsId . ' and spec_value_id not in (' . implode(',', array_keys($specValIdsMap)) . ')');
        $oldGoodsSpecRel = HubGoodsBaseSpecRel::find()->andWhere([
            'spec_value_id' => array_keys($specValIdsMap),
            'goods_id' => $goodsId
        ])->select('spec_value_id')->indexBy('spec_value_id')->all() ?: [];
        if ($oldGoodsSpecRel) {
            $oldGoodsSpecRel = array_keys($oldGoodsSpecRel);
        }
        $newData = array_diff(array_keys($specValIdsMap), $oldGoodsSpecRel);
        foreach ($newData as $specValId) {
            $model = new HubGoodsBaseSpecRel;
            $data = [
                'goods_id' => $goodsId,
                'spec_id' => $specValIdsMap[$specValId],
                'spec_item_show' => $spec[$specValId]['spec_item_show'] ? 1 : 0,
                'thumb' => $spec[$specValId]['thumb'],
                'spec_value_id' => $specValId,
                'create_time' => time(),
            ];
            $model->setAttributes($data);
            ErrorsHelper::throwError($model->save(), '保存商品规格失败！ msg:' . implode(',', $model->getFirstErrors()));
        }
    }

    public static function cartesianProduct($array, $overArray = [])
    {
        $first = array_shift($array);
        if (count($overArray) > 0) {
            foreach ($overArray as $val) {
                foreach ($first as $value) {
                    $ids = explode('_', $val);
                    $ids[] = $value;
                    sort($ids);
                    $tempVal = $d = '';
                    foreach ($ids as $v) {
                        $tempVal .= $d . $v;
                        $d = '_';
                    }
                    $temp[] = $tempVal;
                }
            }
        } else {
            foreach ($first as $val) {
                $temp[] = $val;
            }
        }
        if (count($array) > 0) {
            $temp = self::cartesianProduct($array, $temp);
        }

        return $temp;
    }
}
