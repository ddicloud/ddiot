<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-03 04:51:54
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-22 17:24:07
 */

namespace common\plugins\diandi_hub\models\goods;

/**
 * This is the model class for table "dd_goods_spec_rel".
 *
 * @public int $id
 * @public int $goods_id
 * @public int $spec_id
 * @public int $spec_value_id
 * @public int $wxapp_id
 * @public int $create_time
 */
class HubGoodsBaseSpecRel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_basegoods_spec_rel}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['goods_id', 'bloc_id', 'store_id', 'spec_id', 'spec_value_id', 'create_time', 'spec_item_show'], 'integer'],
            [['thumb'], 'string'],
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
    public function getSpec()
    {
        return $this->hasOne(HubSpec::class, ['spec_id' => 'spec_id']);
    }

    public function getSpecvalue()
    {
        return $this->hasOne(HubSpecValue::class, ['spec_value_id' => 'spec_value_id']);
    }

    public function buildHtml($goods_id)
    {
        $specArray = $this->find()->where(['goods_id' => $goods_id])->with('spec', 'specvalue')->asArray()->all();
        $options = HubGoodsBaseSpec::find()->where(['goods_id' => $goods_id])->asArray()->all();
        $specArrays = [];
        $specvalue = [];
        foreach ($specArray as $item) {
            $specvalue[$item['spec_id']][] = $item['specvalue'];
            $item['title'] = $item['spec']['spec_name'];
            unset($item['specvalue']);
            $specArrays[$item['spec_id']] = $item;
        }
        $allspecs = [];
        foreach ($specvalue as $sid => $item) {
            $specArrays[$sid]['items'] = $item;
            $allspecs[$sid] = $specArrays[$sid];
        }

        //处理规格项
        $html = '';
        // die;
        //排序好的specs
        $specs = [];
        //找出数据库存储的排列顺序
        if (count($options) > 0) {
            $specitemids = explode('_', $options[0]['spec_sku_id']);
            foreach ($specitemids as $itemid) {
                foreach ($allspecs as $ss) {
                    $items = $ss['items'];
                    foreach ($items as $it) {
                        if ($it['spec_value_id'] == $itemid) {
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
                $html .= "<th style='width:80px;'>".$specs[$i]['title'].'</th>';
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
                        $h[$m][$j] = ['html' => "<td rowspan='".$rowspan."'>".$specs[$m]['items'][$kid]['spec_value'].'</td>', 'id' => $specs[$m]['items'][$kid]['spec_value_id']];
                    } else {
                        $h[$m][$j] = ['html' => '', 'id' => $specs[$m]['items'][$kid]['spec_value_id']];
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
                    if ($ids === $o['spec_sku_id']) {
                        $val = [
                            'goods_spec_id' => $o['goods_spec_id'],
                            'title' => $o['title'],
                            'stock' => $o['stock_num'],
                            'costprice' => $o['goods_costprice'],
                            'productprice' => $o['line_price'],
                            'marketprice' => $o['goods_price'],
                            'weight' => $o['goods_weight'],
                        ];
                        break;
                    }
                }
                $hh .= '<td class="info">';
                $hh .= '<input name="option_stock_'.$ids.'[]"  type="text" class="form-control option_stock option_stock_'.$ids.'" value="'.$val['stock'].'"/></td>';
                $hh .= '<input name="option_id_'.$ids.'[]"  type="hidden" class="form-control option_id option_id_'.$ids.'" value="'.$val['goods_spec_id'].'"/>';
                $hh .= '<input name="option_ids[]"  type="hidden" class="form-control option_ids option_ids_'.$ids.'" value="'.$ids.'"/>';
                $hh .= '<input name="option_title_'.$ids.'[]"  type="hidden" class="form-control option_title option_title_'.$ids.'" value="'.$val['title'].'"/>';
                $hh .= '</td>';
                $hh .= '<td class="success"><input name="option_marketprice_'.$ids.'[]" type="text" class="form-control option_marketprice option_marketprice_'.$ids.'" value="'.$val['marketprice'].'"/></td>';
                $hh .= '<td class="warning"><input name="option_productprice_'.$ids.'[]" type="text" class="form-control option_productprice option_productprice_'.$ids.'" " value="'.$val['productprice'].'"/></td>';
                $hh .= '<td class="danger"><input name="option_costprice_'.$ids.'[]" type="text" class="form-control option_costprice option_costprice_'.$ids.'" " value="'.$val['costprice'].'"/></td>';
                $hh .= '<td class="info"><input name="option_weight_'.$ids.'[]" type="text" class="form-control option_weight option_weight_'.$ids.'" " value="'.$val['weight'].'"/></td>';
                $hh .= '</tr>';
            }
            $html .= $hh;
            $html .= '</table>';
        }

        return $html;

        return $specArray;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'thumb' => '属性图片',
            'spec_item_show' => '属性是否显示',
            'goods_id' => '商品ID',
            'spec_id' => '属性分类ID',
            'spec_value_id' => '属性值ID',
            'wxapp_id' => 'Wxapp ID',
            'create_time' => 'Create Time',
        ];
    }
}
