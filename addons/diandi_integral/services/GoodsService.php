<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-10 20:37:35
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-06-16 14:45:00
 */

namespace addons\diandi_integral\services;

use addons\diandi_integral\models\enums\GoodsStatus;
use addons\diandi_integral\models\IntegralGoods;
use addons\diandi_integral\models\IntegralGoodsParam;
use addons\diandi_integral\models\IntegralGoodsSpec;
use addons\diandi_integral\models\IntegralGoodsSpecRel;
use addons\diandi_integral\models\IntegralSlide;
use addons\diandi_integral\models\IntegralSpec;
use addons\diandi_integral\models\IntegralSpecValue;
use common\helpers\ArrayHelper;
use common\helpers\ImageHelper;
use common\helpers\loggingHelper;
use common\helpers\StringHelper;
use common\services\BaseService;
use Yii;
use yii\data\Pagination;

class GoodsService extends BaseService
{
    const INACTIVE = 0;
    const ACTIVE = 10;

    /**
     * 获取商品列表
     * 默认分页参数为page.
     *
     * @param int|null $category_pid post
     * @param int $category_id
     * @param string $keywords
     * @param int $pageSize
     * @param string $orderby
     * @return array
     */
    public static function getList(?int $category_pid = 0, int $category_id = 0, string $keywords = '', int $pageSize = 10, string $orderby = 'goods_sort desc'): array
   {
        $list = [];

        $page = Yii::$app->request->get('page', 1);

        $keys = 'goodsinfo_' . $category_pid . $category_id . $page;
        // if (Yii::$App->cache->get($keys)) { //如果有缓存数据则返回缓存数据，没有则从数据库取病存入缓存中

        //     return Yii::$App->cache->get($keys);
        // } else {
        $where = []; //初始化条件数组
        $where['goods_status'] = GoodsStatus::getValueByName('上架'); //确认上架

        if (!empty($category_pid)) {
            $where['category_pid'] = $category_pid;
        }
        if (!empty($category_id)) {
            $where['category_id'] = $category_id;
        }
        $wherelike = [];
        if (!empty($keywords)) {
            $wherelike = ['like', 'goods_name', $keywords];
        }

        // $bloc_id = Yii::$App->params['bloc_id'];
        // $store_id = Yii::$App->params['store_id'];

        // if ($bloc_id) {
        //     $where['bloc_id'] = $bloc_id;
        // }

        // if ($store_id) {
        //     $where['store_id'] = $store_id;
        // }

        // 创建一个 DB 查询来获得所有
        $query = IntegralGoods::find()->where($where)
            ->andWhere($wherelike)
            ->with(['category', 'specRel', 'goodsSpec'])
            ->orderBy($orderby);

        $count = $query->count();

        // 使用总数来创建一个分页对象
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $pageSize,
            'page' => $page - 1,
            // 'pageParam'=>'page'
        ]);

        $list = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->asArray()
            ->all();

        // 获取系统所有的规格项参数
        $specAll = IntegralSpec::find()->indexBy('spec_id')->all();
        $specValAll = IntegralSpecValue::find()->indexBy('spec_value_id')->all();

        foreach ($list as &$item) {
            $item['goods_name'] = StringHelper::subtext($item['goods_name'], 8);

            $item['thumb'] = ImageHelper::tomedia($item['thumb']);
            $images = unserialize($item['images']);
            $item['images'] = ImageHelper::tomedia($images);

            $specs = [];
            if (!empty($item['specRel'])) {
                $spec_value_ids = array_column($item['specRel'], 'spec_value_id');
                $spec_ids = array_column($item['specRel'], 'spec_id');
                $thumbspecs = [];
                $specitem = [];
                foreach ($item['specRel'] as &$itemspec) {
                    $itemspec['spec_title'] = $specAll[$itemspec['spec_id']]['spec_name'];
                    $itemspec['specVal_title'] = $specValAll[$itemspec['spec_value_id']]['spec_value'];
                    $specs['list'][$itemspec['spec_title']][] = [
                        'id' => $itemspec['spec_value_id'],
                        'name' => $itemspec['specVal_title'],
                        'selected' => false,
                    ];
                    $img = ImageHelper::tomedia($itemspec['thumb']);
                    $specitem[] = $itemspec['specVal_title'];
                    $thumbspecs[$itemspec['specVal_title']] = !empty($itemspec['thumb']) ? $img : $item['thumb'];
                    $specs['list'][$itemspec['spec_title']][0]['selected'] = true;
                }
                $specs['specitem'] = $specitem[0];
                $specs['thumb'] = $thumbspecs;
                if ($item['goodsSpec']) {
                    $specSets = ArrayHelper::arrayKey($item['goodsSpec'], 'spec_sku_id');
                    if (!empty($specSets)) {
                        $speckey = [];
                        foreach ($specSets as $key => $items) {
                            $k = explode('_', $key);
                            $ks = [];
                            foreach ($k as $val) {
                                $ks[] = $specValAll[$val]['spec_value'];
                            }
                            $speckey[] = implode('_', $ks);
                            $newKey = implode('_', $ks);
                            $specs['specVal'][$newKey] = $items;
                        }
                        $specs['specKey'] = $speckey[0];
                    }
                }
            }

            $item['specs'] = $specs;
        }

        Yii::$app->cache->set($keys, $list, 3600);

        return $list;
    }

    public static function getSlides($store_id, $bloc_id): array
    {
        $top_slides = IntegralSlide::find()->where(['store_id' => $store_id, 'bloc_id' => $bloc_id, 'type' => 1])->asArray()->all();
        foreach ($top_slides as $key => &$value) {
            $value['slide'] = ImageHelper::tomedia($value['slide']);
        }

        return $top_slides;
    }

    public static function getDetail($goods_id): array
    {
        $goods = IntegralGoods::find()
            ->with(['category', 'specRel', 'goodsSpec'])
            ->where(['goods_id' => $goods_id])
            ->asArray()
            ->one();
        $specs = [];
        $images = [];
        // 处理图片
        $goods['thumb'] = ImageHelper::tomedia($goods['thumb']);
        $images = ImageHelper::tomedia(unserialize($goods['images']));
        $slides = [];
        if ($goods['video']) {
            $slides[] = [
                'type' => 'video',
                'url' => ImageHelper::tomedia($goods['video']),
            ];
        }
        foreach ($images as $key => $value) {
            $slides[] = [
                'type' => 'image',
                'url' => $value,
            ];
        }

        $goods['slides'] = $slides;
        if (!empty($goods['specRel'])) {
            $spec_value_ids = array_column($goods['specRel'], 'spec_value_id');
            $spec_ids = array_column($goods['specRel'], 'spec_id');

            $spec = IntegralSpec::find()->where(['spec_id' => $spec_ids])->indexBy('spec_id')->all();
            $specVal = IntegralSpecValue::find()->where(['spec_value_id' => $spec_value_ids])
                ->indexBy('spec_value_id')->all();
            $thumbspecs = [];
            $specitem = [];
            foreach ($goods['specRel'] as &$item) {
                // $item['thumb'] = ImageHelper::tomedia($item['thumb']);
                $item['spec_title'] = $spec[$item['spec_id']]['spec_name'];
                $item['specVal_title'] = $specVal[$item['spec_value_id']]['spec_value'];
                $specs['list'][$item['spec_title']][] = [
                    'id' => $item['spec_value_id'],
                    'name' => $item['specVal_title'],
                    'selected' => false,
                ];
                $img = ImageHelper::tomedia($item['thumb']);
                $specitem[] = $item['specVal_title'];
                $thumbspecs[$item['specVal_title']] = !empty($item['thumb']) ? $img : $goods['thumb'];
                $specs['list'][$item['spec_title']][0]['selected'] = true;
            }
            $specs['specitem'] = $specitem[0];
            $specs['thumb'] = $thumbspecs;

            $specSets = ArrayHelper::arrayKey($goods['goodsSpec'], 'spec_sku_id');
            if (!empty($specSets)) {
                unset($item);
                foreach ($specSets as $key => $item) {
                    $k = explode('_', $key);
                    $ks = [];
                    foreach ($k as $val) {
                        $ks[] = $specVal[$val]['spec_value'];
                    }
                    $newKey = implode('_', $ks);
                    $specs['specSet'][$newKey] = $item;
                    $specs['specVal'][$newKey] = $item;
                }
            }
        }
        $goods['specs'] = $specs;

        if (empty($specs)) {
            $goods['spec_type'] = 0;
        }

        // 增加一次浏览
        IntegralGoods::updateAllCounters(['browse' => 1], ['goods_id' => $goods_id]);

        return $goods;
    }

    public static function getOrderDetail($goods_id, $num, $spec_id, $express_type, $region_id): array
   {
        $goods = IntegralGoods::find()
            ->with([
                'category',
                'goodsSpec' => function ($query) use ($spec_id) {
                    $query->where(['spec_sku_id' => $spec_id]);
                }, 'specRel',
            ])
            ->where(['goods_id' => $goods_id])
            ->asArray()
            ->one();
        $specs = [];
        $images = [];
        // 处理图片
        $goods['thumb'] = ImageHelper::tomedia($goods['thumb']);
        $images = ImageHelper::tomedia(unserialize($goods['images']));
        $slides = [];

        $specVal = IntegralSpecValue::find()->where(['spec_value_id' => $spec_id])->one();

        if ($goods['video']) {
            $slides[] = [
                'type' => 'video',
                'url' => ImageHelper::tomedia($goods['video']),
            ];
        }
        foreach ((array)$images as $key => $value) {
            $slides[] = [
                'type' => 'image',
                'url' => $value,
            ];
        }
        $total_price = 0;
        $goods['number'] = $num;
        $lists['$slides'] = $slides;
        $lists['goodsTotalNumber'] = $num;

        $goods['spec_val'] = $specVal['spec_value']??'';

        $lists['goods'][0] = $goods;
        $lists['goods'][0]['goods'] = $goods;
        $lists['number'] = $num;
        $lists['total_integral'] = $goods['goods_integral'] * $num;

        // 计算运费
        $goods_ids[0] = $goods_id;
        $goods_nums[$goods_id] = $num;
        $store_id = Yii::$app->params['global_store_id'];

        $lists['freight'] = ExpressService::getExpressPrice($express_type, $store_id, $region_id, $goods_ids, $goods_nums);
        // 需要支付的费用
        $lists['goods_money'] = StringHelper::currency_format($goods['goods_price']);
        $pay_price = $lists['freight'] + $lists['goods_money'];
        $lists['pay_price'] = StringHelper::currency_format($pay_price);
        $lists['optionss'] = [$express_type, $store_id, $region_id, $goods_ids, $goods_nums];

        return $lists;
    }

    /**
     * 保存商品的规格.
     *
     * @param int|null $goods_id post
     * @param array $specs
     * @return bool|array
     */
    public static function saveSpec(?int $goods_id, array $specs = []): bool|array
    {
        loggingHelper::writeLog('diandi_distribution', 'saveSpec', '保存多规格', [
            'goods_id' => $goods_id,
            'specs' => $specs,
        ]);

        if (empty($specs['option_ids'])) {
            return true;
        }
        $spec_value_ids = [];
        $goods_spec_ids = [];
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
        $spec_item_thumbs = $specs['DistributionGoodsBaseGoods']['spec_item_thumb'];

        // 全局规格项
        $DdSpec = new IntegralSpec();
        // 全局规格值
        $DdSpecValue = new IntegralSpecValue();
        // 商品规格关系表
        $DdGoodsSpecRel = new IntegralGoodsSpecRel();
        // 删除商品已有的
        $DdGoodsSpecRel::deleteAll(['goods_id' => $goods_id]);

        // 保存规格类型
        if (!empty($spec_titles)) {
            loggingHelper::writeLog('diandi_distribution', 'saveSpec', '保存规格类型', $spec_titles);

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
                    loggingHelper::writeLog('diandi_distribution', 'saveSpec', '保存规格值', $spec_item_titles);

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
//                        $spec_sku_id[$key][$k] = Yii::$App->db->getLastInsertID();
                    }
                }
            }
        }

        /* 存储规格属性值 */

        $DdGoodsSpec = new IntegralGoodsSpec();

        $specOldIds = $DdGoodsSpec::find()->where(['goods_id' => $goods_id])->asArray()->select('goods_spec_id')->column();

        loggingHelper::writeLog('diandi_distribution', 'saveSpec', '根据组合id写入商品属性值', $option_ids);

        // 根据组合id写入商品属性值
        $stock_num = 0;
        $idss = [];
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
                    'goods_price' => StringHelper::currency_format($specs['option_marketprice_' . $value][0]),
                    'line_price' => StringHelper::currency_format($specs['option_productprice_' . $value][0]),
                    'stock_num' => intval($specs['option_stock_' . $value][0]),
                    'goods_costprice' => StringHelper::currency_format($specs['option_costprice_' . $value][0]),
                    'goods_weight' => intval($specs['option_weight_' . $value][0]),
                    'spec_sku_id' => implode('_', $idss[$key]),
                    'create_time' => time(),
                ]
            );
            $stock_num += intval($specs['option_stock_' . $value][0]);

            $goods_spec_id = $specs['option_id_' . $value][0];
            $goods_spec_ids[] = $goods_spec_id;

            loggingHelper::writeLog('diandi_distribution', 'saveSpec', '校验是更新还是写入', $goods_spec_ids);

            loggingHelper::writeLog('diandi_distribution', 'saveSpec', '校验更新1', $goods_spec_id);

            if (!empty($goods_spec_id)) {
                $res[] = $_DdGoodsSpec::updateAll([
                    'goods_id' => $goods_id,
                    'goods_no' => '123',
                    'goods_price' => StringHelper::currency_format($specs['option_marketprice_' . $value][0]),
                    'line_price' => StringHelper::currency_format($specs['option_productprice_' . $value][0]),
                    'stock_num' => intval($specs['option_stock_' . $value][0]),
                    'goods_costprice' => StringHelper::currency_format($specs['option_costprice_' . $value][0]),
                    'goods_weight' => floatval($specs['option_weight_' . $value][0]),
                    'spec_sku_id' => implode('_', $idss[$key]),
                    'create_time' => time(),
                ], ['goods_spec_id' => $goods_spec_id]);

                loggingHelper::writeLog('diandi_distribution', 'saveSpec', '校验是更新数据', [
                    'goods_id' => $goods_id,
                    'goods_no' => '123',
                    'option_marketprice_' => $specs['option_marketprice_' . $value][0],
                    'option_productprice_' => $specs['option_productprice_' . $value][0],
                    'option_costprice_' => $specs['option_costprice_' . $value][0],
                    'goods_price' => StringHelper::currency_format($specs['option_marketprice_' . $value][0]),
                    'line_price' => StringHelper::currency_format($specs['option_productprice_' . $value][0]),
                    'stock_num' => intval($specs['option_stock_' . $value][0]),
                    'goods_costprice' => StringHelper::currency_format($specs['option_costprice_' . $value][0]),
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
        IntegralGoods::updateAll(['stock' => $stock_num], ['goods_id' => $goods_id]);


        // 存储属性
        if (!empty($params)) {
            $DdGoodsParam = new IntegralGoodsParam();

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
        return  $res;
    }
}
