<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-02 08:38:14
 * @Last Modified by:   Radish <minradish@163.com>
 * @Last Modified time: 2022-10-13 17:18:24
 */

namespace common\plugins\diandi_hub\models\goods;

use common\plugins\diandi_hub\models\enums\GoodsStatus as EnumsGoodsStatus;
use common\helpers\ErrorsHelper;
use common\helpers\loggingHelper;
use common\helpers\StringHelper as HelpersStringHelper;
use common\traits\ActiveQuery\StoreTrait;
use diandi\addons\models\BlocStore;
use Yii;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "dd_goods".
 *
 * @public int    $goods_id
 * @public string $goods_name
 * @public int    $category_id
 * @public int    $spec_type
 * @public int    $deduct_stock_type
 * @public string $content
 * @public int    $sales_initial
 * @public int    $sales_actual
 * @public int    $goods_sort
 * @public int    $delivery_id
 * @public int    $goods_status
 * @public int    $is_delete
 * @public int    $wxapp_id
 * @public int    $create_time
 * @public int    $update_time
 */
class HubGoodsBaseGoods extends \yii\db\ActiveRecord
{
    use StoreTrait;

    public $spec_item_thumb;

    /**
     * 商品SKU.
     *
     * @var array
     * @date 2022-07-05
     *
     * @example
     *
     * @author Radish
     *
     * @since
     */
    public $goods_spec;
    /**
     * 商品规格
     *
     * @var Array
     * @date 2022-07-05
     *
     * @example
     *
     * @author Radish
     *
     * @since
     */
    public $specs;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_base_goods}}';
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

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            if (!is_numeric($this->goods_status) && isset($this->goods_status)) {
                //字段
                $this->goods_status = EnumsGoodsStatus::getValueByName($this->goods_status);
            }

            // if(is_array($this->images)){
            //     $this->images = serialize($this->images);

            // }

            return true;
        } else {
            return false;
        }
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (is_array($this->images)) {
                //字段
                $this->images = serialize($this->images);
            }

            if (empty($this->goods_sort)) {
                $this->goods_sort = 0;
            }

            return true;
        } else {
            return false;
        }
    }

    public function getSpecItemThumb()
    {
        return $this->spec_item_thumb;
    }

    public function setSpecItemThumb($spec_item_thumb)
    {
        $this->spec_item_thumb = $spec_item_thumb;
    }

    public function getDisgoods()
    {
        return $this->hasOne(HubGoods::class, ['goods_id' => 'goods_id']);
    }

    public function getShare()
    {
        return $this->hasOne(HubGoodsSubsidy::class, [
            'goods_id' => 'goods_id',
        ]);
    }

    public function getStore()
    {
        return $this->hasOne(BlocStore::class, [
            'store_id' => 'store_id',
        ]);
    }

    public function getCate()
    {
        return $this->hasOne(HubCategory::class, [
            'category_id' => 'category_id',
        ]);
    }

    public function afterFind()
    {
        parent::afterFind();
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [[
                'category_id', 'spec_type', 'deduct_stock_type', 'sales_initial', 'goods_sort', 'delivery_id', 'goods_status', 'create_time', 'update_time', 'bloc_id', 'store_id',
                'express_type',
                'goods_type',
                'express_template_id',
                'addons_id',
            ], 'integer'],
            [['content', 'images', 'thumb', 'line_price', 'goods_name', 'category_id', 'sales_initial', 'category_pid', 'stock', 'selling_point', 'addons_id'], 'required'],
            ['goods_sort', 'default', 'value' => 0],
            [['content'], 'compare', 'compareValue' => '', 'operator' => '!='],
            [['goods_name', 'label', 'video'], 'string', 'max' => 255],
            [['deduct_stock_type'], 'compare', 'compareValue' => '', 'operator' => '!='],
            ['stock', 'compare', 'compareValue' => 0, 'operator' => '>='],
            [[
                'line_price', 'goods_price', 'browse', 'goods_costprice', 'goods_weight', 'delivery_id', 'volume',
                'exemption',
                'exemption_type',
            ], 'number'],
            [['category_id'], 'compare', 'compareValue' => 0, 'operator' => '!='],
            ['goods_spec', 'checkGoodsSpec'],
            ['specs', 'checkSpecs'],
            ['addons_id', 'exist', 'targetClass' => 'addons\diandi_cloud\models\CloudAddons', 'targetAttribute' => 'id', 'message' => '指定应用不存在'],
        ];
    }

    public function checkSpecs($field, $scenario, $vali, $val)
    {
        $key = ['spec_value_id', 'spec_item_show', 'thumb'];
        sort($key);
        if (is_array($val) && count($val, COUNT_RECURSIVE)) {
            foreach ($val as $spec) {
                $temp = array_keys($spec);
                $temp = array_intersect($key, $temp);
                sort($temp);
                if ($key != $temp) {
                    $this->addError('specs', '产品规格缺少 ' . implode(',', array_diff($key, $temp)));

                    return false;
                }
            }
        } else {
            $this->addError('specs', '无效的产品规格!');
        }
    }

    public function checkGoodsSpec($field, $scenario, $vali, $val)
    {
        $key = ['goods_no', 'goods_price', 'line_price', 'stock_num', 'goods_weight', 'goods_costprice', 'spec_item_thumb'];
        sort($key);
        if (is_array($val) && count($val, COUNT_RECURSIVE)) {
            foreach ($val as $sku) {
                $temp = array_keys($sku);
                $temp = array_intersect($key, $temp);
                sort($temp);
                if ($temp != $key) {
                    $this->addError('goods_spec', '产品SKU缺少 ' . implode(',', array_diff($key, $temp)));

                    return false;
                }
            }
        } else {
            $this->addError('goods_spec', '无效的产品SKU!');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'goods_id' => '商品ID',
            'goods_name' => '商品名称',
            'bloc_id' => '公司ID',
            'volume' => '体积',
            'express_type' => '运费计价方式',
            'store_id' => '商户ID',
            'video' => '短视频',
            'category_id' => '二级分类',
            'category_pid' => '一级分类',
            'label' => '商品标签',
            'spec_type' => '商品规格',
            'goods_weight' => '重量(克)',
            'express_template_id' => '运费模板',
            'deduct_stock_type' => '库存计算方式',
            'content' => '商品介绍',
            'sales_initial' => '初始销量',
            'sales_actual' => 'Sales Actual',
            'goods_sort' => '商品排序',
            'delivery_id' => '运费模板',
            'goods_status' => '是否上架',
            'is_delete' => '是否删除',
            'goods_type' => '商品类型',
            'wxapp_id' => 'Wxapp ID',
            'create_time' => '添加时间',
            'update_time' => '更新时间',
            'images' => '商品相册',
            'goods_costprice' => '成本价格',
            'thumb' => '商品主图',
            'line_price' => '市场价',
            'sales_actual' => '实际销量',
            'browse' => '浏览量',
            'goods_price' => '销售价格',
            'stock' => '库存',
            'spec_item_thumb' => '属性图片',
            'exemption' => '包邮条件',
            'exemption_type' => '包邮条件类型',
            'selling_point' => '商品卖点',
            'goods_spec' => '商品SKU',
            'specs' => '商品规格',
            'addons_id' => '应用ID',
        ];
    }

    /* 获取分类 */
    public function getCategory()
    {
        return $this->hasOne(HubCategory::class, ['category_id' => 'category_id']);
    }

    public function getAddons()
    {
        return $this->hasOne(\addons\diandi_cloud\models\CloudAddons::class, ['id' => 'addons_id']);
    }

    /**
     * 获取商品规格.
     *
     * @param int|null post
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function getSpec()
    {
        return $this->hasMany(HubGoodsBaseSpec::class, ['goods_id' => 'goods_id']);
    }

    /**
     * 获取商品规格.
     *
     * @param int|null post
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function getGoodsSpec()
    {
        return $this->hasMany(HubGoodsBaseSpec::class, ['goods_id' => 'goods_id']);
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
    public function getSpecRel()
    {
        return $this->hasMany(HubGoodsBaseSpecRel::class, ['goods_id' => 'goods_id']);
    }

    /**
     * 保存商品的规格.
     *
     * @param int|null post
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function saveSpec($goods_id, $specs = [])
    {
        // 全局规格项
        $DdSpec = new HubSpec();
        // 全局规格值
        $DdSpecValue = new HubSpecValue();
        // 商品规格关系表
        $DdGoodsSpecRel = new HubGoodsBaseSpecRel();
        // 删除商品已有的
        $DdGoodsSpecRel::deleteAll(['goods_id' => $goods_id]);

        foreach ($specs as $key => $value) {
            // specs[0][spec_name]: 颜色
            // specs[0][spec_item][0][spec_item_show]: 0
            // specs[0][spec_item][0][spec_item_title]: 红色
            // specs[0][spec_item][0][spec_item_thumb]:
            // specs[0][spec_item][1][spec_item_show]: 0
            // specs[0][spec_item][1][spec_item_title]: 绿色
            // specs[0][spec_item][1][spec_item_thumb]:

            // 全局规格存储
            $_DdSpec = clone $DdSpec;

            $_DdSpec->spec_name = $value['spec_name'];
            $_DdSpec->create_time = time();
            $spec_id = $_DdSpec::find()->where(['spec_name' => $value['spec_name']])->select('spec_id')->scalar();
            if (empty($spec_id)) {
                // 不存在保存使用
                $Res = $_DdSpec->save();
                $msg = ErrorsHelper::getModelError($_DdSpec);
                ErrorsHelper::throwError($Res, $msg);
                $spec_id = Yii::$app->db->getLastInsertID();
                $spec_ids[$key] = $spec_id;
            }
            if (!empty($value['spec_item'])) {
                // 保存规格值
                foreach ($value['spec_item'] as $k => $val) {
                    $_DdSpecValue = clone $DdSpecValue;
                    // 查询规格是否值是否存在
                    $spec_value_have_id = $_DdSpecValue::find()
                        ->where(['spec_id' => $spec_id, 'spec_value' => $val['spec_value']])
                        ->select('spec_value_id')
                        ->scalar();
                    if (empty($spec_value_have_id)) {
                        // 不存在保存使用
                        $_DdSpecValue->spec_value = $val['spec_value'];
                        $_DdSpecValue->spec_id = $spec_id;
                        $_DdSpecValue->create_time = time();
                        $Res = $_DdSpecValue->save();
                        $msg = ErrorsHelper::getModelError($_DdSpecValue);
                        ErrorsHelper::throwError($Res, $msg);

                        $spec_value_have_id = Yii::$app->db->getLastInsertID();
                    }
                    /* 写入属性与商品关联关系表 */
                    $_DdGoodsSpecRel = clone $DdGoodsSpecRel;
                    $_DdGoodsSpecRel->setAttributes([
                        'goods_id' => $goods_id,
                        'spec_id' => $spec_id,
                        'spec_item_show' => $val['spec_item_show'] ? 1 : 0,
                        'thumb' => $val['spec_item_thumb'],
                        'spec_value_id' => $spec_value_have_id,
                        'create_time' => time(),
                    ]);
                    $Res = $_DdGoodsSpecRel->save();
                    $msg = ErrorsHelper::getModelError($_DdGoodsSpecRel);
                    ErrorsHelper::throwError($Res, $msg);
                    $spec_sku_id[$key][$k] = Yii::$app->db->getLastInsertID();
                }
            }
        }

        // 获取组合id
        $option_ids = $specs['option_ids'];
        // 规格名称
        $spec_titles = $specs['spec_title'];
        // 规格类型
        $spec_str_ids = $specs['spec_id'];
        // 规格名称
        $spec_item_titles = $specs['spec_item_title'];
        // 属性值
        $params = $specs['param'];
        // 规格显示
        $spec_item_shows = $specs['spec_item_show'];
        // 规格图片
        $spec_item_thumbs = $specs['HubGoodsBaseGoods']['spec_item_thumb'];

        // 保存规格类型
        if (!empty($spec_titles)) {
            loggingHelper::writeLog('diandi_hub', 'saveSpec', '保存规格类型', $spec_titles);

            foreach ($spec_titles as $key => $value) {
                $_DdSpec = clone $DdSpec;
                $_DdSpec->spec_name = $value;
                $_DdSpec->create_time = time();
                $spec_have_id = $_DdSpec::find()->where(['spec_name' => $value])->select('spec_id')->one();
                if (!empty($spec_have_id)) {
                    // 存在直接使用
                    $spec_ids[$key] = $spec_have_id->spec_id;
                } else {
                    // 不存在保存使用
                    $_DdSpec->save();
                    $spec_ids[$key] = Yii::$app->db->getLastInsertID();
                }
                if (!empty($spec_item_titles[$key])) {
                    loggingHelper::writeLog('diandi_hub', 'saveSpec', '保存规格值', $spec_item_titles);

                    // 保存规格值
                    foreach ($spec_item_titles[$key] as $k => $val) {
                        $_DdSpecValue = clone $DdSpecValue;
                        // 查询规格是否值是否存在
                        $spec_value_have_ids = $_DdSpecValue::find()
                            ->where(['spec_id' => $spec_ids[$key], 'spec_value' => $val])
                            ->select('spec_value_id')
                            ->one();
                        if (!empty($spec_value_have_ids)) {
                            // 规格值存在直接使用
                            $spec_value_ids[$k] = $spec_value_have_ids->spec_value_id;
                        } else {
                            // 不存在保存使用
                            $_DdSpecValue->spec_value = $val;
                            $_DdSpecValue->spec_id = $spec_ids[$key];
                            $_DdSpecValue->create_time = time();
                            $_DdSpecValue->save();
                            $spec_value_ids[$k] = Yii::$app->db->getLastInsertID();
                        }
                        /* 写入属性与商品关联关系表 */
                        $_DdGoodsSpecRel = clone $DdGoodsSpecRel;
                        $_DdGoodsSpecRel->setAttributes([
                            'goods_id' => $goods_id,
                            'spec_id' => $spec_ids[$key],
                            'spec_item_show' => $spec_item_shows[$key][$k],
                            'thumb' => $spec_item_thumbs[$key][$k],
                            'spec_value_id' => $spec_value_ids[$k],
                            'create_time' => time(),
                        ]);
                        $_DdGoodsSpecRel->save();
                        $spec_sku_id[$key][$k] = Yii::$app->db->getLastInsertID();
                    }
                }
            }
        }

        /* 存储规格属性值 */

        $DdGoodsSpec = new HubGoodsBaseSpec();
        if (!empty($option_ids)) {
            $specOldIds = $DdGoodsSpec::find()->where(['goods_id' => $goods_id])->asArray()->select('goods_spec_id')->column();

            loggingHelper::writeLog('diandi_hub', 'saveSpec', '根据组合id写入商品属性值', $option_ids);

            // 根据组合id写入商品属性值
            $stock_num = 0;
            foreach ($option_ids as $key => $value) {
                $list = StringHelper::explode($value, '_');
                // 写入商品属性值
                $_DdGoodsSpec = clone $DdGoodsSpec;
                foreach ($list as $item) {
                    $idss[$key][] = $spec_value_ids[$item];
                }

                $_DdGoodsSpec->setAttributes(
                    [
                        'goods_id' => $goods_id,
                        'goods_no' => '123',
                        'goods_price' => HelpersStringHelper::currency_format($specs['option_marketprice_' . $value][0]),
                        'line_price' => HelpersStringHelper::currency_format($specs['option_productprice_' . $value][0]),
                        'stock_num' => intval($specs['option_stock_' . $value][0]),
                        'goods_costprice' => HelpersStringHelper::currency_format($specs['option_costprice_' . $value][0]),
                        'goods_weight' => intval($specs['option_weight_' . $value][0]),
                        'spec_sku_id' => implode('_', $idss[$key]),
                        'create_time' => time(),
                    ]
                );
                $stock_num += intval($specs['option_stock_' . $value][0]);

                $goods_spec_id = $specs['option_id_' . $value][0];
                $goods_spec_ids[] = $goods_spec_id;

                loggingHelper::writeLog('diandi_hub', 'saveSpec', '校验是更新还是写入', $goods_spec_ids);

                loggingHelper::writeLog('diandi_hub', 'saveSpec', '校验更新1', $goods_spec_id);

                if (!empty($goods_spec_id)) {
                    $res[] = $_DdGoodsSpec::updateAll([
                        'goods_id' => $goods_id,
                        'goods_no' => '123',
                        'goods_price' => HelpersStringHelper::currency_format($specs['option_marketprice_' . $value][0]),
                        'line_price' => HelpersStringHelper::currency_format($specs['option_productprice_' . $value][0]),
                        'stock_num' => intval($specs['option_stock_' . $value][0]),
                        'goods_costprice' => HelpersStringHelper::currency_format($specs['option_costprice_' . $value][0]),
                        'goods_weight' => floatval($specs['option_weight_' . $value][0]),
                        'spec_sku_id' => implode('_', $idss[$key]),
                        'create_time' => time(),
                    ], ['goods_spec_id' => $goods_spec_id]);

                    loggingHelper::writeLog('diandi_hub', 'saveSpec', '校验是更新数据', [
                        'goods_id' => $goods_id,
                        'goods_no' => '123',
                        'option_marketprice_' => $specs['option_marketprice_' . $value][0],
                        'option_productprice_' => $specs['option_productprice_' . $value][0],
                        'option_costprice_' => $specs['option_costprice_' . $value][0],
                        'goods_price' => HelpersStringHelper::currency_format($specs['option_marketprice_' . $value][0]),
                        'line_price' => HelpersStringHelper::currency_format($specs['option_productprice_' . $value][0]),
                        'stock_num' => intval($specs['option_stock_' . $value][0]),
                        'goods_costprice' => HelpersStringHelper::currency_format($specs['option_costprice_' . $value][0]),
                        'goods_weight' => floatval($specs['option_weight_' . $value][0]),
                        'spec_sku_id' => implode('_', $idss[$key]),
                        'create_time' => time(),
                        'goods_spec_id' => $goods_spec_id,
                    ]);
                } else {
                    $res[] = $_DdGoodsSpec->save();
                }
            }

            // 两个数组得差就是需要删除的
            $deleteSpecIds = array_diff($specOldIds, $goods_spec_ids);
            $DdGoodsSpec::deleteAll(['goods_spec_id' => $deleteSpecIds]);

            $this->updateAll(['stock' => $stock_num], ['goods_id' => $goods_id]);
        }

        // 存储属性
        if (!empty($params)) {
            $DdGoodsParam = new HubGoodsBaseParam();

            $param_id = $params['param_id'];
            foreach ($param_id as $item) {
                $_DdGoodsParam = clone $DdGoodsParam;

                if (is_numeric($item)) {
                    $_DdGoodsParam->updateAll([
                        'title' => $params['param_title'][$item],
                        'goods_id' => $goods_id,
                        'value' => $params['param_value'][$item],
                    ], ['id' => $item]);
                } else {
                    $_DdGoodsParam->setAttributes([
                        'title' => $params['param_title'][$item],
                        'goods_id' => $goods_id,
                        'value' => $params['param_value'][$item],
                    ]);
                    $_DdGoodsParam->save();
                }
                $_DdGoodsParam->save();
            }
        }
    }

    public function createHtml($options, $allspecs)
    {
        if (count($options) > 0) {
            $specs = [];
            $specitemids = explode('_', $options[0]['specs']);
            foreach ($specitemids as $itemid) {
                foreach ($allspecs as $ss) {
                    $items = $ss['items'];
                    foreach ($items as $it) {
                        if ($it['id'] == $itemid) {
                            $specs[] = $ss;
                            break;
                        }
                    }
                }
            }
            $html = '';
            $html .= '<table class="table table-bordered table-condensed">';
            $html .= '<thead>';
            $html .= '<tr class="active">';
            $len = count($specs);
            $newlen = 1; //多少种组合
            $h = []; //显示表格二维数组
            $rowspans = []; //每个列的rowspan
            for ($i = 0; $i < $len; ++$i) {
                //表头
                $html .= "<th style='width:80px;'>" . $specs[$i]['title'] . '</th>';
                //计算多种组合
                $itemlen = count($specs[$i]['items']);
                if ($itemlen <= 0) {
                    $itemlen = 1;
                }
                $newlen *= $itemlen;
                //初始化 二维数组
                $h = [];
                for ($j = 0; $j < $newlen; ++$j) {
                    $h[$i][$j] = [];
                }
                //计算rowspan
                $l = count($specs[$i]['items']);
                $rowspans[$i] = 1;
                for ($j = $i + 1; $j < $len; ++$j) {
                    $rowspans[$i] *= count($specs[$j]['items']);
                }
            }
            $html .= '<th class="info" style="width:130px;"><div class=""><div style="padding-bottom:10px;text-align:center;font-size:16px;">库存</div><div class="input-group"><input type="text" class="form-control option_stock_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-hand-o-down" title="批量设置" onclick="setCol(\'option_stock\');"></a></span></div></div></th>';
            $html .= '<th class="success" style="width:150px;"><div class=""><div style="padding-bottom:10px;text-align:center;font-size:16px;">销售价格</div><div class="input-group"><input type="text" class="form-control option_marketprice_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-hand-o-down" title="批量设置" onclick="setCol(\'option_marketprice\');"></a></span></div></div></th>';
            $html .= '<th class="warning" style="width:150px;"><div class=""><div style="padding-bottom:10px;text-align:center;font-size:16px;">市场价格</div><div class="input-group"><input type="text" class="form-control option_productprice_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-hand-o-down" title="批量设置" onclick="setCol(\'option_productprice\');"></a></span></div></div></th>';
            $html .= '<th class="danger" style="width:150px;"><div class=""><div style="padding-bottom:10px;text-align:center;font-size:16px;">成本价格</div><div class="input-group"><input type="text" class="form-control option_costprice_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-hand-o-down" title="批量设置" onclick="setCol(\'option_costprice\');"></a></span></div></div></th>';
            $html .= '<th class="info" style="width:150px;"><div class=""><div style="padding-bottom:10px;text-align:center;font-size:16px;">重量（克）</div><div class="input-group"><input type="text" class="form-control option_weight_all"  VALUE=""/><span class="input-group-addon"><a href="javascript:;" class="fa fa-hand-o-down" title="批量设置" onclick="setCol(\'option_weight\');"></a></span></div></div></th>';
            $html .= '</tr></thead>';
            for ($m = 0; $m < $len; ++$m) {
                $k = 0;
                $kid = 0;
                $n = 0;
                for ($j = 0; $j < $newlen; ++$j) {
                    $rowspan = $rowspans[$m];
                    if ($j % $rowspan == 0) {
                        $h[$m][$j] = ['html' => "<td rowspan='" . $rowspan . "'>" . $specs[$m]['items'][$kid]['title'] . '</td>', 'id' => $specs[$m]['items'][$kid]['id']];
                    } else {
                        $h[$m][$j] = ['html' => '', 'id' => $specs[$m]['items'][$kid]['id']];
                    }
                    ++$n;
                    if ($n == $rowspan) {
                        ++$kid;
                        if ($kid > count($specs[$m]['items']) - 1) {
                            $kid = 0;
                        }
                        $n = 0;
                    }
                }
            }
            $hh = '';
            for ($i = 0; $i < $newlen; ++$i) {
                $hh .= '<tr>';
                $ids = [];
                for ($j = 0; $j < $len; ++$j) {
                    $hh .= $h[$j][$i]['html'];
                    $ids[] = $h[$j][$i]['id'];
                }
                $ids = implode('_', $ids);
                $val = ['id' => '', 'title' => '', 'stock' => '', 'costprice' => '', 'productprice' => '', 'marketprice' => '', 'weight' => ''];
                foreach ($options as $o) {
                    if ($ids === $o['specs']) {
                        $val = [
                            'id' => $o['id'],
                            'title' => $o['title'],
                            'stock' => $o['stock'],
                            'costprice' => $o['costprice'],
                            'productprice' => $o['productprice'],
                            'marketprice' => $o['marketprice'],
                            'weight' => $o['weight'],
                        ];
                        break;
                    }
                }
                $hh .= '<td class="info">';
                $hh .= '<input name="option_stock_' . $ids . '[]"  type="text" class="form-control option_stock option_stock_' . $ids . '" value="' . $val['stock'] . '"/></td>';
                $hh .= '<input name="option_id_' . $ids . '[]"  type="hidden" class="form-control option_id option_id_' . $ids . '" value="' . $val['id'] . '"/>';
                $hh .= '<input name="option_ids[]"  type="hidden" class="form-control option_ids option_ids_' . $ids . '" value="' . $ids . '"/>';
                $hh .= '<input name="option_title_' . $ids . '[]"  type="hidden" class="form-control option_title option_title_' . $ids . '" value="' . $val['title'] . '"/>';
                $hh .= '</td>';
                $hh .= '<td class="success"><input name="option_marketprice_' . $ids . '[]" type="text" class="form-control option_marketprice option_marketprice_' . $ids . '" value="' . $val['marketprice'] . '"/></td>';
                $hh .= '<td class="warning"><input name="option_productprice_' . $ids . '[]" type="text" class="form-control option_productprice option_productprice_' . $ids . '" " value="' . $val['productprice'] . '"/></td>';
                $hh .= '<td class="danger"><input name="option_costprice_' . $ids . '[]" type="text" class="form-control option_costprice option_costprice_' . $ids . '" " value="' . $val['costprice'] . '"/></td>';
                $hh .= '<td class="info"><input name="option_weight_' . $ids . '[]" type="text" class="form-control option_weight option_weight_' . $ids . '" " value="' . $val['weight'] . '"/></td>';
                $hh .= '</tr>';
            }
            $html .= $hh;
            $html .= '</table>';
        }

        return $html;
    }
}
