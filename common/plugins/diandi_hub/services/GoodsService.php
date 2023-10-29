<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-04 17:15:42
 * @Last Modified by:   Radish <minradish@163.com>
 * @Last Modified time: 2022-10-13 18:03:29
 */

namespace common\plugins\diandi_hub\services;

use common\plugins\diandi_hub\models\advertising\HubLocation;
use common\plugins\diandi_hub\models\advertising\HubLocationGoods;
use common\plugins\diandi_hub\models\enums\GoodsStatus;
use common\plugins\diandi_hub\models\enums\GoodsTypeStatus;
use common\plugins\diandi_hub\models\goods\HubGift;
use common\plugins\diandi_hub\models\goods\HubGoods as GoodsHubGoods;
use common\plugins\diandi_hub\models\goods\HubGoodsBaseGoods;
use common\plugins\diandi_hub\models\goods\HubGoodsBaseLabel;
use common\plugins\diandi_hub\models\goods\HubGoodsBaseSpec;
use common\plugins\diandi_hub\models\goods\HubGoodsLevel;
use common\plugins\diandi_hub\models\goods\HubSpec;
use common\plugins\diandi_hub\models\goods\HubSpecValue;
use common\helpers\ArrayHelper;
use common\helpers\ErrorsHelper;
use common\helpers\FileHelper;
use common\helpers\ImageHelper;
use common\helpers\loggingHelper;
use common\helpers\ResultHelper;
use common\helpers\StringHelper;
use common\models\DdMemberAccount;
use common\services\BaseService;
use diandi\addons\models\BlocStore;
use Yii;
use yii\data\Pagination;
use yii\db\Transaction;

class GoodsService extends BaseService
{
    public $modelClass = '';

    /**
     * 获取商品列表
     * 默认分页参数为page.
     *
     * @param int|null post
     *
     * @return array
     *
     * @throws NotFoundHttpException
     */
    public static function getList($locationId = 0, $keywords = '', $intypes = 0, $pageSize = 10, $user_id = 0)
    {
        global $_GPC;
        $list = [];
        $page = Yii::$app->request->get('page', 1);

        $intypeAr = ['NOT IN', 'IN'];

        $intype = $intypeAr[$intypes];

        $loca_goods = HubLocationGoods::find()->where(['location_id' => $locationId])->select(['goods_id'])->asArray()->column();
        $where = []; //初始化条件数组
        $wherelike = [];
        $whereNotin = [];
        $wherein = [];
        $where['goods_status'] = GoodsStatus::getValueByName('上架'); //确认上架
        if (!empty($locationId) && $intypes == 1) {
            $wherein = [$intype, 'goods_id', $loca_goods];
            if (empty($loca_goods)) {
                return [];
            }
        } elseif (!empty($locationId) && $intypes == 0) {
            // 获取当前广告位对应的页面
            $pages = HubLocation::findOne($locationId);

            $location_ids = HubLocation::find()->where(['page' => $pages['page']])->select('id')->column();

            $whereGoods = [];

            $whereGoods['store_id'] = Yii::$app->params['store_id'];
            $whereGoods['bloc_id'] = Yii::$app->params['bloc_id'];

            // 根据页面返回已有商品进行排除
            $loca_goods = HubLocationGoods::find()->where(['IN', 'location_id', $location_ids])->andWhere($whereGoods)->select(['goods_id'])->column();

            $whereNotin = [$intype, 'goods_id', $loca_goods];
        }

        if (!empty($keywords)) {
            $wherelike = ['like', 'goods_name', $keywords];
        }

        $storeWhere = [];

        if (!empty($_GPC['storeName'])) {
            $storetable = BlocStore::tableName();

            $storeWhere = ['like', $storetable . '.name', $_GPC['storeName']];
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
        $query = HubGoodsBaseGoods::find()->where($where)
            ->andFilterWhere($wherelike)
            ->andFilterWhere($whereNotin)
            ->andFilterWhere($wherein)
            ->with(['category', 'specRel', 'goodsSpec'])
            ->innerJoinWith(['store' => function ($query) use ($storeWhere) {
                $query->where($storeWhere);
            }])
            ->orderBy('goods_sort');
        $count = $query->count();

        // 使用总数来创建一个分页对象
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $pageSize,
            // 'page'=>$page-1
            // 'pageParam'=>'page'
        ]);

        $list = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->asArray()
            ->all();

        // 获取当前用户购物车数量
        $cartlist = [];
        $cart = [];

        if (!empty($user_id)) {
            $cartlist = CartService::list($user_id);

            $cart = ArrayHelper::arrayKey($cartlist['goods'], 'goods_id');
        }

        // 获取标签
        $labels = HubGoodsBaseLabel::find()->all();
        $label = ArrayHelper::arrayKey($labels, 'label');

        // 获取系统所有的规格项参数
        $specAll = HubSpec::find()->indexBy('spec_id')->all();
        $specValAll = HubSpecValue::find()->indexBy('spec_value_id')->all();

        foreach ($list as &$item) {
            $item['goods_name'] = StringHelper::subtext($item['goods_name'], 8);

            $item['thumb'] = ImageHelper::tomedia($item['thumb']);
            $images = unserialize($item['images']);
            $item['images'] = ImageHelper::tomedia($images);
            $item['number'] = $cart[$item['goods_id']]['number'] ? $cart[$item['goods_id']]['number'] : 0;
            if (!empty($item['label'])) {
                $item['label_color'] = $label[$item['label']]['color'];
            }

            $specs = [];
            if (!empty($item['specRel'])) {
                $spec_value_ids = array_column($item['specRel'], 'spec_value_id');
                $spec_ids = array_column($item['specRel'], 'spec_id');
                $thumbspecs = [];
                $specitem = [];
                $specs['list'] = [];
                foreach ($item['specRel'] as &$itemspec) {
                    $itemspec['spec_title'] = $specAll[$itemspec['spec_id']]['spec_name'];
                    $itemspec['specVal_title'] = $specValAll[$itemspec['spec_value_id']]['spec_value'];
                    $specs['list'][$itemspec['spec_title']][] = [
                        'id' => $itemspec['spec_value_id'],
                        'name' => $itemspec['specVal_title'],
                        'selected' => false,
                    ];
                    $thumb = !empty($itemspec['thumb']) ? $itemspec['thumb'] : $item['thumb'];
                    $img = ImageHelper::tomedia($thumb);
                    $specitem[] = $itemspec['specVal_title'];
                    $thumbspecs[$itemspec['specVal_title']] = $img;
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
                    }
                }
            }
            $specs['specKey'] = $speckey[0];

            $item['specs'] = $specs;
        }

        return $list;
    }

    /**
     * 获取商品列表
     * 默认分页参数为page.
     *
     * @param int|null post
     *
     * @return array
     *
     * @throws NotFoundHttpException
     */
    public static function getListLocation($locationId = 0, $keywords = '', $intypes = 0, $pageSize = 10, $user_id = 0)
    {
        global $_GPC;
        $list = [];
        // $store_id = $_GPC['store_id'];
        // $bloc_id = $_GPC['bloc_id'];
        $page = empty($_GPC['page']) ? 1 : intval($_GPC['page']);

        $intypeAr = ['NOT IN', 'IN'];

        $intype = $intypeAr[$intypes];

        $loca_goods = HubLocationGoods::find()->where(['location_id' => $locationId])->select(['goods_id'])->asArray()->column();
        $where = []; //初始化条件数组
        $wherelike = [];
        $whereNotin = [];
        $wherein = [];
        $where['goods_status'] = GoodsStatus::getValueByName('上架'); //确认上架
        if (!empty($locationId) && $intypes == 1) {
            $wherein = [$intype, 'goods_id', $loca_goods];
            if (empty($loca_goods)) {
                return [];
            }
        } elseif (!empty($locationId) && $intypes == 0) {
            // 获取当前广告位对应的页面
            $pages = HubLocation::findOne($locationId);

            $location_ids = HubLocation::find()->where(['page' => $pages['page']])->select('id')->column();

            $whereGoods = [];

            $whereGoods['store_id'] = Yii::$app->params['store_id'];
            $whereGoods['bloc_id'] = Yii::$app->params['bloc_id'];

            // 根据页面返回已有商品进行排除
            $loca_goods = HubLocationGoods::find()->where(['IN', 'location_id', $location_ids])->andWhere($whereGoods)->select(['goods_id'])->column();

            $whereNotin = [$intype, 'goods_id', $loca_goods];
        }

        if (!empty($keywords)) {
            $wherelike = ['like', 'goods_name', $keywords];
        }

        $storeWhere = [];

        if (!empty($_GPC['storeName'])) {
            $storetable = BlocStore::tableName();

            $storeWhere = ['like', $storetable . '.name', $_GPC['storeName']];
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
        $query = HubGoodsBaseGoods::find()->where($where)
            ->andFilterWhere($wherelike)
            ->andFilterWhere($whereNotin)
            ->andFilterWhere($wherein)
            ->with(['category', 'specRel', 'goodsSpec'])
            ->innerJoinWith(['store' => function ($query) use ($storeWhere) {
                $query->where($storeWhere);
            }])
            ->orderBy('goods_sort');
        $count = $query->count();

        // 使用总数来创建一个分页对象
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $pageSize,
            'page' => $page - 1,
            'pageParam' => 'page',
        ]);

        // var_dump($query->createCommand()->getRawSql());die;
        $list = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->asArray()
            ->all();

        // 获取当前用户购物车数量
        $cartlist = [];
        $cart = [];

        if (!empty($user_id)) {
            $cartlist = CartService::list($user_id);

            $cart = ArrayHelper::arrayKey($cartlist['goods'], 'goods_id');
        }

        // 获取标签
        $labels = HubGoodsBaseLabel::find()->all();
        $label = ArrayHelper::arrayKey($labels, 'label');

        // 获取系统所有的规格项参数
        $specAll = HubSpec::find()->indexBy('spec_id')->all();
        $specValAll = HubSpecValue::find()->indexBy('spec_value_id')->all();

        foreach ($list as &$item) {
            $item['goods_name'] = StringHelper::subtext($item['goods_name'], 8);

            $item['thumb'] = ImageHelper::tomedia($item['thumb']);
            $images = unserialize($item['images']);
            $item['images'] = ImageHelper::tomedia($images);
            $item['number'] = $cart[$item['goods_id']]['number'] ? $cart[$item['goods_id']]['number'] : 0;
            if (!empty($item['label'])) {
                $item['label_color'] = $label[$item['label']]['color'];
            }

            $specs = [];
            if (!empty($item['specRel'])) {
                $spec_value_ids = array_column($item['specRel'], 'spec_value_id');
                $spec_ids = array_column($item['specRel'], 'spec_id');
                $thumbspecs = [];
                $specitem = [];
                $specs['list'] = [];
                foreach ($item['specRel'] as &$itemspec) {
                    $itemspec['spec_title'] = $specAll[$itemspec['spec_id']]['spec_name'];
                    $itemspec['specVal_title'] = $specValAll[$itemspec['spec_value_id']]['spec_value'];
                    $specs['list'][$itemspec['spec_title']][] = [
                        'id' => $itemspec['spec_value_id'],
                        'name' => $itemspec['specVal_title'],
                        'selected' => false,
                    ];
                    $thumb = !empty($itemspec['thumb']) ? $itemspec['thumb'] : $item['thumb'];
                    $img = ImageHelper::tomedia($thumb);
                    $specitem[] = $itemspec['specVal_title'];
                    $thumbspecs[$itemspec['specVal_title']] = $img;
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
                    }
                }
            }
            $specs['specKey'] = $speckey[0];

            $item['specs'] = $specs;
        }

        return [
            'count' => $count,
            'list' => $list,
        ];
    }

    public static function goodsGifts($keywords = '', $page = 1, $pageSize = 10)
    {
        global $_GPC;
        $list = [];

        $where = []; //初始化条件数组
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
        $query = HubGift::find()->where($where)
            ->with(['goods'])
            ->andWhere($wherelike);

        $count = $query->count();

        // 使用总数来创建一个分页对象
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $pageSize,
            // 'page'=>$page-1
            // 'pageParam'=>'page'
        ]);

        $list = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->asArray()
            ->all();

        foreach ($list as $key => &$value) {
            $value['thumb'] = ImageHelper::tomedia($value['thumb']);
        }

        $user_id = Yii::$app->user->identity->user_id;

        // 获取标签
        $labels = HubGoodsBaseLabel::find()->all();
        $label = ArrayHelper::arrayKey($labels, 'label');

        return $list;
    }

    public static function Giftsdetail($goods_id)
    {
        global $_GPC;
        //  获取基础得产品信息

        $basewhere = [];

        $basewhere['goods_id'] = $goods_id;
        $goods = HubGoodsBaseGoods::find()
            ->with(['category', 'specRel', 'goodsSpec', 'share'])
            ->where($basewhere)
            ->asArray()
            ->one();

        $store_id = $goods['store_id'];
        $store = Yii::$app->service->commonGlobalsService->getStoreDetail($store_id);
        $goods['store'] = $store;

        $gift = HubGift::findOne(['goods_id' => $goods_id]);

        $goods['goods_price'] = $gift['gift_price'];

        // 处理分享信息
        if (empty($goods['share'])) {
            if (empty($goods['share']['agemoney'])) {
                $agemoney = $store['agemoney'];
                $moneyradio = $store['moneyradio'];
                $douradio = $store['douradio'];
                $goods['share'] = [
                    'integral_redio' => $douradio,
                    'money_redio' => $moneyradio,
                    'provide_redio' => $agemoney,
                ];
            }
        }

        //礼包商品

        $specs = [];
        $images = [];
        // 处理图片
        $goods['thumb'] = ImageHelper::tomedia($gift['thumb']);
        $images = ImageHelper::tomedia(unserialize($gift['images']));
        $slides = [];
        if ($goods['video']) {
            $slides[] = [
                'type' => 'video',
                'url' => ImageHelper::tomedia($goods['video']),
            ];
        }

        if (is_array($images)) {
            foreach ($images as $key => $value) {
                $slides[] = [
                    'type' => 'image',
                    'url' => $value,
                ];
            }
        }

        $goods['slides'] = $slides;
        if (!empty($goods['specRel'])) {
            $spec_value_ids = array_column($goods['specRel'], 'spec_value_id');
            $spec_ids = array_column($goods['specRel'], 'spec_id');

            $spec = HubSpec::find()->where(['spec_id' => $spec_ids])->indexBy('spec_id')->all();
            $specVal = HubSpecValue::find()->where(['spec_value_id' => $spec_value_ids])
                ->indexBy('spec_value_id')->all();
            $thumbspecs = [];
            $specitem = [];
            foreach ($goods['specRel'] as &$item) {
                // 按照礼包价格输出
                $item['goods_price'] = $gift['gift_price'];
                // $item['thumb'] = ImageHelper::tomedia($item['thumb']);
                $item['spec_title'] = $spec[$item['spec_id']]['spec_name'];
                $item['specVal_title'] = $specVal[$item['spec_value_id']]['spec_value'];
                $specs['list'][$item['spec_title']][] = [
                    'id' => $item['spec_value_id'],
                    'name' => $item['specVal_title'],
                    'selected' => false,
                ];
                $thumb = !empty($item['thumb']) ? $item['thumb'] : $goods['thumb'];
                $img = ImageHelper::tomedia($thumb);
                $specitem[] = $item['specVal_title'];
                $thumbspecs[$item['specVal_title']] = $img;
                $specs['list'][$item['spec_title']][0]['selected'] = true;
            }
            $specs['specitem'] = $specitem[0];
            $specs['thumb'] = $thumbspecs;

            $specSets = ArrayHelper::arrayKey($goods['goodsSpec'], 'spec_sku_id');
            if (!empty($specSets)) {
                foreach ($specSets as $key => $item) {
                    // 按照礼包价格输出
                    $item['goods_price'] = $gift['gift_price'];
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

        if (empty($specs)) {
            $goods['spec_type'] = 0;
        }

        $goods['specs'] = $specs;

        // 增加一次浏览
        HubGoodsBaseGoods::updateAllCounters(['browse' => 1], ['goods_id' => $goods_id]);

        return ['goods' => $goods, 'gift' => $gift];
    }

    public static function addGoods($goods_id, $goods_type, $type, $member_price, $prices, $disInfo, $goodsSpecs, $baseprice)
    {
        // 数据初始
        $goodsSpecs = json_decode($goodsSpecs, true);
        $disInfo = json_decode($disInfo, true);
        $prices = json_decode($prices, true);
        $baseprice = json_decode($baseprice, true);

        $transaction = Yii::$app->db->beginTransaction(Transaction::READ_COMMITTED);
        try {
            $goods = self::getDetail($goods_id, $goods_type);

            $disgoods = new GoodsHubGoods();
            $disgoodsData = [
                'goods_id' => $goods_id,
                'member_price' => $member_price,
                'type' => $type,
                'price1' => number_format($baseprice['price1'], 2, '.', ''),
                'price2' => number_format($baseprice['price2'], 2, '.', ''),
                'price3' => number_format($baseprice['price3'], 2, '.', ''),
                'price4' => number_format($baseprice['price4'], 2, '.', ''),
                'price5' => number_format($baseprice['price5'], 2, '.', ''),
                'price6' => number_format($baseprice['price6'], 2, '.', ''),
            ];

            if ($disgoods->load($disgoodsData, '') && $disgoods->save()) {
                $disgoodsSpec = new HubGoodsBaseSpec();

                foreach ($disInfo as $key => $value) {
                    $_disgoodsSpec = clone $disgoodsSpec;

                    list($spec_id, $levelnum, $level) = explode('_', $key);

                    if (!empty($goods['goodsSpec']) && is_array($goods['goodsSpec'])) {
                        $goodsSpec = ArrayHelper::arrayKey($goods['goodsSpec'], 'goods_spec_id');

                        $goods_price = $goodsSpec[$goodsSpecs[$spec_id]]['goods_price'];
                    } else {
                        $goods_price = $goods['goods_price'];
                    }
                    $specData = [
                        'row_col_levelnum' => $key,
                        'goods_id' => $goods_id,
                        'goods_price' => $goods_price,
                        'member_price' => $member_price,
                        'goods_spec_id' => intval($goodsSpecs[$spec_id]),
                        'dislevel' => $level,
                        'levelnum' => $levelnum,
                        'money' => $value,
                        'type' => $type, //分佣方式
                        'price1' => number_format($prices[$spec_id . '_price1'], 2, '.', ''),
                        'price2' => number_format($prices[$spec_id . '_price2'], 2, '.', ''),
                        'price3' => number_format($prices[$spec_id . '_price3'], 2, '.', ''),
                        'price4' => number_format($prices[$spec_id . '_price4'], 2, '.', ''),
                        'price5' => number_format($prices[$spec_id . '_price5'], 2, '.', ''),
                        'price6' => number_format($prices[$spec_id . '_price6'], 2, '.', ''),
                    ];
                    $Res = loggingHelper::writeLog('diandi_hub', 'goodsService', '分销活动创建', $specData);
                    $_disgoodsSpec->setAttributes($specData);
                    if (!$_disgoodsSpec->save()) {
                        $msg = ErrorsHelper::getModelError($_disgoodsSpec);

                        return ResultHelper::json(400, $msg, $specData);
                    }
                }
            } else {
                $msg = ErrorsHelper::getModelError($disgoods);

                return ResultHelper::json(400, $msg, []);
            }

            $transaction->commit();

            return ResultHelper::json(200, '发布成功', []);
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    public static function updateGoods($goods_id, $goods_type, $type, $member_price, $prices, $disInfo, $goodsSpecs, $baseprice)
    {
        // 数据初始
        $goodsSpecs = json_decode($goodsSpecs, true);
        $disInfo = json_decode($disInfo, true);
        $prices = json_decode($prices, true);
        $baseprice = json_decode($baseprice, true);
        $goods = [];
        $dis = self::goodsDis($goods_id);
        $transaction = Yii::$app->db->beginTransaction(Transaction::READ_COMMITTED);
        try {
            $goods = self::getDetail($goods_id, $goods_type);
            $disgoods = new GoodsHubGoods();

            $disgoodsData = [
                'goods_id' => $goods_id,
                'member_price' => $member_price,
                'type' => $type,
                'price1' => number_format($baseprice['price1'], 2, '.', ''),
                'price2' => number_format($baseprice['price2'], 2, '.', ''),
                'price3' => number_format($baseprice['price3'], 2, '.', ''),
                'price4' => number_format($baseprice['price4'], 2, '.', ''),
                'price5' => number_format($baseprice['price5'], 2, '.', ''),
                'price6' => number_format($baseprice['price6'], 2, '.', ''),
            ];

            $Res = $disgoods->updateAll($disgoodsData, [
                'goods_id' => $goods_id,
            ]);

            $disgoodsSpec = new HubGoodsBaseSpec();

            foreach ($disInfo as $key => $value) {
                $_disgoodsSpec = clone $disgoodsSpec;

                list($spec_id, $levelnum, $level) = explode('_', $key);

                if (!empty($goods['goodsSpec']) && is_array($goods['goodsSpec']) && !empty($goodsSpecs)) {
                    $goodsSpec = ArrayHelper::arrayKey($goods['goodsSpec'], 'goods_spec_id');
                    $goods_price = $goodsSpec[$goodsSpecs[$spec_id]]['goods_price'];
                } else {
                    $goods_price = $goods['goods_price'];
                }

                $specData = [
                    'row_col_levelnum' => $key,
                    'goods_id' => $goods_id,
                    'goods_price' => $goods_price,
                    'member_price' => $member_price,
                    'goods_spec_id' => intval($goodsSpecs[$spec_id]),
                    'dislevel' => $level,
                    'levelnum' => $levelnum,
                    'money' => $value,
                    'type' => $type, //分佣方式
                    'price1' => number_format($prices[$spec_id . '_price1'], 2, '.', ''),
                    'price2' => number_format($prices[$spec_id . '_price2'], 2, '.', ''),
                    'price3' => number_format($prices[$spec_id . '_price3'], 2, '.', ''),
                    'price4' => number_format($prices[$spec_id . '_price4'], 2, '.', ''),
                    'price5' => number_format($prices[$spec_id . '_price5'], 2, '.', ''),
                    'price6' => number_format($prices[$spec_id . '_price6'], 2, '.', ''),
                ];

                if (!empty($dis['disGroup'][$key]) && !empty($dis['disGroup'])) {
                    $_disgoodsSpec->updateAll($specData, [
                        'row_col_levelnum' => $key,
                        'goods_id' => $goods_id,
                    ]);
                } else {
                    $_disgoodsSpec->load($specData, '');
                    if (!$_disgoodsSpec->save()) {
                        $msg = ErrorsHelper::getModelError($_disgoodsSpec);
                        loggingHelper::writeLog('diandi_hub', 'goodsserver', '更新分销参数', $msg);

                        return ResultHelper::json(400, $msg, $specData);
                    }
                }
            }

            $transaction->commit();

            return ResultHelper::json(200, '发布成功', []);
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    // 获取某一个商品分销信息
    public static function goodsDis($goods_id)
    {
        $basewhere = [];

        $basewhere['goods_id'] = $goods_id;
        $goods = HubGoodsBaseGoods::find()
            ->with(['category', 'specRel', 'goodsSpec'])
            ->where($basewhere)
            ->asArray()
            ->one();

        //礼包商品

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

        if (!empty($images) && is_array($images)) {
            foreach ($images as $key => $value) {
                $slides[] = [
                    'type' => 'image',
                    'url' => $value,
                ];
            }
        }

        $goods['slides'] = $slides;
        if (!empty($goods['specRel'])) {
            $spec_value_ids = array_column($goods['specRel'], 'spec_value_id');
            $spec_ids = array_column($goods['specRel'], 'spec_id');

            $spec = HubSpec::find()->where(['spec_id' => $spec_ids])->indexBy('spec_id')->asArray()->all();
            $specVal = HubSpecValue::find()->where(['spec_value_id' => $spec_value_ids])
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
                $thumb = !empty($item['thumb']) ? $item['thumb'] : $goods['thumb'];
                $img = ImageHelper::tomedia($thumb);
                $specitem[] = $item['specVal_title'];
                $thumbspecs[$item['specVal_title']] = $img;
                $specs['list'][$item['spec_title']][0]['selected'] = true;
            }
            $specs['specitem'] = $specitem[0];
            $specs['thumb'] = $thumbspecs;

            $specSets = ArrayHelper::arrayKey($goods['goodsSpec'], 'spec_sku_id');
            if (!empty($specSets)) {
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

        if (empty($specs)) {
            $goods['spec_type'] = 0;
        }

        $goods['specs'] = $specs;

        // 增加一次浏览
        HubGoodsBaseGoods::updateAllCounters(['browse' => 1], ['goods_id' => $goods_id]);

        $list = GoodsHubGoods::find()->where(['goods_id' => $goods_id])->with(['goodsspec' => function ($query) {
            return $query->orderBy('goods_spec_id,levelnum');
        }])->asArray()->one();
        if ($list['goodsspec']) {
            $goods_spec_id = array_column($list['goodsspec'], 'goods_spec_id');
            $goods_spec_ids = array_values(array_unique($goods_spec_id));

            $disGroup = [];
            if ($goods_spec_ids[0] == 0) {
                foreach ($list['goodsspec'] as $key => $value) {
                    $index = $value['levelnum'] - 1;
                    $disGroup[$index . '_' . $value['levelnum'] . '_' . $value['dislevel']] = $value['money'];
                }
            } else {
                foreach ($list['goodsspec'] as $key => $value) {
                    $row_col_levelnum = $value['row_col_levelnum'];
                    $disGroup[$row_col_levelnum] = $value['money'];
                }
            }

            // p($goods_spec_ids);
            //    $disGroup = array_chunk($list['goodsspec'],3);
        }

        return ['goods' => $goods, 'dis' => $list, 'disGroup' => $disGroup];
    }

    // 获取某一个商品分销信息
    public static function goodsDisList($goods_ids = [])
    {
        $logPath = Yii::getAlias('@runtime/diandi_hub/OrderLog/' . date('Y/md') . '.log');

        $basewhere = [];

        $basewhere['goods_id'] = $goods_ids;
        $goodsAll = HubGoodsBaseGoods::find()
            ->with(['category', 'specRel', 'goodsSpec'])
            ->where($basewhere)->orderBy('goods_id')
            ->asArray()
            ->all();

        $bloc_id = Yii::$app->params['bloc_id'];
        $store_id = Yii::$app->params['store_id'];

        $spec = HubSpec::find()->where(['bloc_id' => $bloc_id, 'store_id' => $store_id])->indexBy('spec_id')->all();
        $specVal = HubSpecValue::find()->where(['bloc_id' => $bloc_id, 'store_id' => $store_id])->indexBy('spec_value_id')->all();

        $HubGoods = GoodsHubGoods::find()->where(['IN', 'goods_id', $goods_ids])->with(['goodsspec'])->asArray()->indexBy('goods_id')->all();

        FileHelper::writeLog($logPath, '分销商品' . json_encode($goods_ids));

        FileHelper::writeLog($logPath, '分销商品sql' . GoodsHubGoods::find()->where(['IN', 'goods_id', $goods_ids])->createCommand()->getRawSql());
        FileHelper::writeLog($logPath, '分销商品' . json_encode($HubGoods));

        foreach ($goodsAll as $goods_id => &$goods) {
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
            if (is_array($images)) {
                foreach ($images as $key => $value) {
                    $slides[] = [
                        'type' => 'image',
                        'url' => $value,
                    ];
                }
            }

            $goods['slides'] = $slides;
            if (!empty($goods['specRel'])) {
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
                    $thumb = !empty($item['thumb']) ? $item['thumb'] : $goods['thumb'];
                    $img = ImageHelper::tomedia($thumb);
                    $specitem[] = $item['specVal_title'];
                    $thumbspecs[$item['specVal_title']] = $img;
                    $specs['list'][$item['spec_title']][0]['selected'] = true;
                }
                $specs['specitem'] = $specitem[0];
                $specs['thumb'] = $thumbspecs;

                $specSets = ArrayHelper::arrayKey($goods['goodsSpec'], 'spec_sku_id');
                if (!empty($specSets)) {
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
        }

        return ['goods' => $goods, 'dis' => $HubGoods];
    }

    /**
     * function_description.
     *
     * @param goods_type int 0分销1礼包
     *
     * @return array
     *
     * @throws NotFoundHttpException
     */
    public static function getDetail($goods_id)
    {
        global $_GPC;

        $basewhere = [];

        $basewhere['goods_id'] = $goods_id;
        $goods = HubGoodsBaseGoods::find()
            ->with(['category', 'specRel', 'goodsSpec', 'share', 'addons'])
            ->where($basewhere)
            ->asArray()
            ->one();

        //  获取基础得产品信息
        $store_id = $goods['store_id'];
        $store = Yii::$app->service->commonGlobalsService->getStoreDetail($store_id);
        $goods['store'] = $store;
        if (empty($goods['share'])) {
            if (empty($goods['share']['agemoney'])) {
                $agemoney = $store['agemoney'];
                $moneyradio = $store['moneyradio'];
                $douradio = $store['douradio'];
                $goods['share'] = [
                    'integral_redio' => $douradio,
                    'money_redio' => $moneyradio,
                    'provide_redio' => $agemoney,
                ];
            }
        }

        $specs = [];
        $images = [];
        // 处理图片

        $goods['thumb'] = ImageHelper::tomedia($goods['thumb']);
        if ($goods['addons']) {
            $goods['addons']['logo'] = ImageHelper::tomedia($goods['addons']['logo']);
            $goods['addons']['applets'] = ImageHelper::tomedia($goods['addons']['applets']);
        }
        $images = ImageHelper::tomedia(unserialize($goods['images']));
        $slides = [];
        if ($goods['video']) {
            $slides[] = [
                'type' => 'video',
                'url' => ImageHelper::tomedia($goods['video']),
            ];
        }
        if (!empty($images) && is_array($images)) {
            foreach ($images as $key => $value) {
                $slides[] = [
                    'type' => 'image',
                    'url' => $value,
                ];
            }
        }

        $goods['slides'] = $slides;
        if (!empty($goods['specRel'])) {
            $spec_value_ids = array_column($goods['specRel'], 'spec_value_id');
            $spec_ids = array_column($goods['specRel'], 'spec_id');

            $spec = HubSpec::find()->where(['spec_id' => $spec_ids])->indexBy('spec_id')->all();
            $specVal = HubSpecValue::find()->where(['spec_value_id' => $spec_value_ids])
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
                $thumb = !empty($item['thumb']) ? $item['thumb'] : $goods['thumb'];
                $img = ImageHelper::tomedia($thumb);
                $specitem[] = $item['specVal_title'];
                $thumbspecs[$item['specVal_title']] = $img;
                $specs['list'][$item['spec_title']][0]['selected'] = true;
            }
            $specs['specitem'] = $specitem[0];
            $specs['thumb'] = $thumbspecs;

            $specSets = ArrayHelper::arrayKey($goods['goodsSpec'], 'spec_sku_id');
            if (!empty($specSets)) {
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

        if (empty($specs)) {
            $goods['spec_type'] = 0;
        }

        $goods['specs'] = $specs;

        // 增加一次浏览
        HubGoodsBaseGoods::updateAllCounters(['browse' => 1], ['goods_id' => $goods_id]);

        return $goods;
    }

    public static function getSelfDetail($goods_id)
    {
        $goods = self::getDetail($goods_id);
        $dis = self::goodsDis($goods_id);

        return [
            'goods' => $goods,
            'dis' => $dis,
        ];
    }

    public static function getOrderDetail($goods_id, $num, $spec_id, $goods_type = 2, $order_type = 0, $region_id = 0, $express_type = 0, $express_id = 0)
    {
        global $_GPC;

        $store_id = Yii::$app->params['store_id'];

        $member_id = Yii::$app->user->identity->user_id;

        $member = DdMemberAccount::find()->where(['member_id' => $member_id])->select(['credit1'])->one();

        $goods = HubGoodsBaseGoods::find()
            ->with([
                'category',
                'disgoods',
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

        $specVal = HubSpecValue::find()->where(['spec_value_id' => $spec_id])->one();

        if (empty($goods_type)) {
            $goods_type = 2;
        }



        switch ($goods_type) {
            case  GoodsTypeStatus::getValueByName('礼包商品'):
                // 礼包商品
                $gift = HubGift::findOne(['goods_id' => $goods_id]);
                $goods['goods_price'] = $gift['gift_price'];
                $goods['thumb'] = ImageHelper::tomedia($gift['thumb']);

                $total_price = 0;
                $goods['number'] = $num;
                $lists['goodsTotalNumber'] = $num;

                $goods['spec_val'] = $specVal['spec_value'];

                $goods_price = !empty($spec_id) ? $goods['goodsSpec'][0]['goods_price'] : $goods['goods_price'];

                $goods_costprice = !empty($spec_id) ? $goods['goodsSpec'][0]['goods_costprice'] : $goods['goods_costprice'];

                $goods['goods_costprice'] = $goods_costprice;

                $goods['goods_price'] = $goods_price;
                $lists['goods'][0] = $goods;
                $lists['goods'][0]['goods'] = $goods;
                $lists['number'] = $num;
                $lists['total_price'] = $goods_price * $num;
                // 计算运费
                $goods_ids[0] = $goods_id;
                $goods_nums[$goods_id] = $num;
                $lists['freight'] = ExpressService::getExpressPrice($member_id, $express_type, $region_id, $goods_ids, $goods_nums, $express_id);

                $lists['pay_price'] = number_format($lists['total_price'] + $lists['freight'], 2, '.', '');

                $lists['is_credit1'] = false;

                break;
            case GoodsTypeStatus::getValueByName('自营商品'):
                $total_price = 0;
                $goods['number'] = $num;
                $lists['goodsTotalNumber'] = $num;

                $goods['spec_val'] = $specVal['spec_value'];

                $goods_price = !empty($spec_id) ? $goods['goodsSpec'][0]['goods_price'] : $goods['goods_price'];
                $goods_costprice = !empty($spec_id) ? $goods['goodsSpec'][0]['goods_costprice'] : $goods['goods_costprice'];

                $goods['goods_costprice'] = $goods_costprice;
                $goods['goods_price'] = $goods_price;
                $lists['goods'][0] = $goods;
                $lists['goods'][0]['goods'] = $goods;
                $lists['number'] = $num;
                $lists['total_price'] = $goods_price * $num;
                // 计算运费
                $goods_ids[0] = $goods_id;
                $goods_nums[$goods_id] = $num;
                $lists['freight'] = ExpressService::getExpressPrice($member_id, $express_type, $region_id, $goods_ids, $goods_nums, $express_id);

                $lists['pay_price'] = number_format($lists['total_price'] + $lists['freight'], 2, '.', '');

                $lists['credit1'] = $member['credit1'];

                $lists['is_credit1'] = true;

                break;
            case GoodsTypeStatus::getValueByName('店铺商品'):
                $total_price = 0;
                $goods['number'] = $num;
                $lists['goodsTotalNumber'] = $num;

                $goods['spec_val'] = $specVal['spec_value'];
                $goods_price = !empty($spec_id) ? $goods['goodsSpec'][0]['goods_price'] : $goods['goods_price'];
                $goods_costprice = !empty($spec_id) ? $goods['goodsSpec'][0]['goods_costprice'] : $goods['goods_costprice'];

                $goods['goods_costprice'] = $goods_costprice;
                $goods['goods_price'] = $goods_price;
                $lists['goods'][0] = $goods;
                $lists['goods'][0]['goods'] = $goods;
                $lists['number'] = $num;

                $lists['total_price'] = $goods_price * $num;
                // 计算运费
                $goods_ids[0] = $goods_id;
                $goods_nums[$goods_id] = $num;
                $lists['freight'] = ExpressService::getExpressPrice($member_id, $express_type, $region_id, $goods_ids, $goods_nums, $express_id);

                $lists['pay_price'] = number_format($lists['total_price'] + $lists['freight'], 2, '.', '');

                $lists['is_credit1'] = true;

                $lists['credit1'] = $member['credit1'];

                break;
        }

        loggingHelper::writeLog('diandi_hub', 'GoodsService/getOrderDetail', '订单详情信息获取', $lists);

        return $lists;
    }

    /**
     * 获取商品列表
     * 默认分页参数为page.
     *
     * @param int|null post
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public static function getLists($category_pid = 0, $category_id = 0, $keywords = '', $pageSize = 10, $user_id = '', $orderby = 'goods_sort desc', $label_id = 0)
    {
        global $_GPC;
        $list = [];

        $page = Yii::$app->request->get('page', 1);

        $keys = 'goodsinfo_' . $category_pid . $category_id . $page;

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

        $bloc_id = Yii::$app->params['bloc_id'];
        $store_id = Yii::$app->params['store_id'];

        if ($bloc_id) {
            $where['bloc_id'] = $bloc_id;
        }

        if ($store_id) {
            $where['store_id'] = $store_id;
        }

        if (!empty(intval($label_id))) {
            $labels = HubGoodsBaseLabel::findOne($label_id);
            $where['label'] = $labels['label'];
        }

        // 排除礼包商品
        $whereNotGift = ['!=', 'goods_type', GoodsTypeStatus::getValueByName('礼包商品')];

        // p($where);
        // die;
        // 创建一个 DB 查询来获得所有
        $query = HubGoodsBaseGoods::find()->where($where)
            ->andWhere($wherelike)
            ->andWhere($whereNotGift)
            ->with(['category', 'specRel', 'goodsSpec', 'addons'])
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
        $sql = $query->createCommand()->getRawSql();
        loggingHelper::writeLog('diandi_hub', 'GoodsService', '获取商品sql', $sql);
        // 获取当前用户购物车数量
        $cartlist = CartService::list($user_id);
        $cart = ArrayHelper::arrayKey($cartlist['goods'] ?: [], 'goods_id');
        // 获取标签
        $labels = HubGoodsBaseLabel::find()->where([
            'bloc_id' => $bloc_id,
            'store_id' => $store_id,
        ])->all();

        $label = ArrayHelper::arrayKey($labels, 'label');

        // 获取系统所有的规格项参数
        $specAll = HubSpec::find()->indexBy('spec_id')->all();
        $specValAll = HubSpecValue::find()->indexBy('spec_value_id')->all();

        foreach ($list as &$item) {
            $item['goods_name'] = StringHelper::subtext($item['goods_name'], 8);

            $item['thumb'] = ImageHelper::tomedia($item['thumb']);
            if ($item['addons']) {
                $item['addons']['logo'] = ImageHelper::tomedia($item['addons']['logo']);
                $item['addons']['applets'] = ImageHelper::tomedia($item['addons']['applets']);
            }
            $images = unserialize($item['images']);
            $item['images'] = ImageHelper::tomedia($images);
            $item['number'] = $cart[$item['goods_id']]['number'] ? $cart[$item['goods_id']]['number'] : 0;
            if (!empty($item['label'])) {
                $item['label_color'] = $label[$item['label']]['color'];
            }

            $specs = [];
            if (!empty($item['specRel'])) {
                $spec_value_ids = array_column($item['specRel'], 'spec_value_id');
                $spec_ids = array_column($item['specRel'], 'spec_id');
                $thumbspecs = [];
                $specitem = [];
                $specs['list'] = [];
                foreach ($item['specRel'] as &$itemspec) {
                    $itemspec['spec_title'] = $specAll[$itemspec['spec_id']]['spec_name'];
                    $itemspec['specVal_title'] = $specValAll[$itemspec['spec_value_id']]['spec_value'];
                    $specs['list'][$itemspec['spec_title']][] = [
                        'id' => $itemspec['spec_value_id'],
                        'name' => $itemspec['specVal_title'],
                        'selected' => false,
                    ];
                    $thumb = !empty($itemspec['thumb']) ? $itemspec['thumb'] : $item['thumb'];
                    $img = ImageHelper::tomedia($thumb);

                    $specitem[] = $itemspec['specVal_title'];
                    $thumbspecs[$itemspec['specVal_title']] = $img;
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
                    }
                }
            }
            $specs['specKey'] = $speckey[0];

            $item['specs'] = $specs;
        }

        return $list;
    }

    // 生成海报数据
    public static function CreatePainter($goods_id, $user_id)
    {
        // 获取商品详情
        $detail = self::getDetail($goods_id, 0);

        $user = MemberService::getByUid($user_id);
        list($goods_price, $price2) = explode('.', $detail['goods_price']);

        $conf = [
            'width' => '700rpx',
            'height' => '1114rpx',
            'background' => 'linear-gradient(135deg, #ff971b 0%, #ff5000 100%)',
            'views' => [
                [
                    'type' => 'view',
                    'css' => [
                        'left' => '10rpx',
                        'top' => '144rpx',
                        'background' => '#ffffff',
                        'radius' => '16rpx',
                        'width' => '680rpx',
                        'height' => '930rpx',
                        'shadow' => '0 20rpx 48rpx rgba(0,0,0,.05)',
                    ],
                ],
                // 头像
                [
                    'type' => 'image',
                    'url' => ImageHelper::tomedia($user['avatarUrl']),
                    'css' => [
                        'left' => '10rpx',
                        'top' => '40rpx',
                        'width' => '84rpx',
                        'height' => '84rpx',
                        // border: '1px solid #000',
                        'radius' => '50%',
                        'color' => '#999999',
                    ],
                ],
                // 昵称
                [
                    'type' => 'text',
                    'text' => $user['username'],
                    'css' => [
                        'color' => '#ffffff',
                        'left' => '144rpx',
                        'top' => '40rpx',
                        'fontSize' => '32rpx',
                        'fontWeight' => 'bold',
                    ],
                ],
                // 推荐话术
                [
                    'type' => 'text',
                    'text' => '为您挑选了一个好物',
                    'css' => [
                        'color' => 'rgba(255,255,255,.7)',
                        'left' => '144rpx',
                        'top' => '90rpx',
                        'fontSize' => '24rpx',
                    ],
                ],
                // 商品主图
                [
                    'type' => 'image',
                    'url' => ImageHelper::tomedia($detail['thumb']),
                    'css' => [
                        'left' => '32rpx',
                        'top' => '176rpx',
                        'width' => '636rpx',
                        'height' => '606rpx',
                        'radius' => '12rpx',
                    ],
                ],
                [
                    'type' => 'view',
                    'css' => [
                        'height' => '58rpx',
                        'color' => '#FF0000',
                        'left' => '66rpx',
                        'top' => '812rpx',
                        'fontWeight' => 'bold',
                        'fontSize' => '28rpx',
                        'lineHeight' => '.61em',
                        'verticalAlign' => 'bottom',
                    ],
                    'views' => [
                        [
                            'type' => 'text',
                            'text' => '￥',
                            'css' => [],
                        ],
                        [
                            'type' => 'text',
                            'text' => $goods_price,
                            'css' => [
                                'fontSize' => '58rpx',
                            ],
                        ],
                        [
                            'type' => 'text',
                            'text' => '.' . $price2,
                            'css' => [],
                        ],
                        [
                            'type' => 'text',
                            'text' => '￥' . $detail['line_price'],
                            'css' => [
                                'paddingLeft' => '20rpx',
                                'fontWeight' => 'normal',
                                'textDecoration' => 'line-through',
                                'color' => '#999',
                            ],
                        ],
                    ],
                ],
                // 商品名称
                [
                    'type' => 'text',
                    'text' => $detail['goods_name'],
                    'css' => [
                        'maxLines' => 2,
                        'width' => '396rpx',
                        'color' => '#333333',
                        'left' => '62rpx',
                        'top' => '948rpx',
                        'fontSize' => '36rpx',
                        'lineHeight' => '50rpx',
                    ],
                ],
                // 二维码
            ],
        ];

        return $conf;
    }

    public static function updateGoodsType($goods_id, $goods_type)
    {
        return HubGoodsBaseGoods::updateAll([
            'goods_type' => $goods_type,
        ], [
            'goods_id' => $goods_id,
        ]);
    }

    public static function addGoodsRule($goods_id, $share_title, $share_desc, $share_img, $type, $levelsValue, $oneOptions, $twoOptions, $threeOptions)
    {
        $transaction = GoodsHubGoods::getDb()->beginTransaction();

        try {
            // 保存分销活动
            $GoodsHubGoods = new GoodsHubGoods();
            $goods = [
                'goods_id' => $goods_id,
                'share_title' => $share_title,
                'share_desc' => $share_desc,
                'share_img' => $share_img,
                'type' => $type,
                'one_options' => $oneOptions,
                'two_options' => $twoOptions,
                'three_options' => $threeOptions,
            ];

            $GoodsHubGoods->load($goods, '');
            $Res = $GoodsHubGoods->save();
            if ($Res) {
                $dis_id = $GoodsHubGoods->id;
                // 获取当前等级
                $levelss = levelService::getLevels();
                $levels = array_values($levelss);
                // 保存分销活动规则
                $HubGoodsLevel = new HubGoodsLevel();

                for ($i = 0; $i <= 2; ++$i) {
                    foreach ($levels as $key => $value) {
                        $_HubGoodsLevel = clone  $HubGoodsLevel;
                        $goodsLevel = [
                            'goods_id' => $goods_id,
                            'dis_id' => $dis_id,
                            'level_num' => $i,
                            'team_num' => $value['levelnum'],
                            'dis_option' => $levelsValue[$i][$value['levelnum']],
                        ];
                        $_HubGoodsLevel->setAttributes($goodsLevel);
                        $_HubGoodsLevel->save();
                    }
                }
            } else {
                $msg = ErrorsHelper::getModelError($GoodsHubGoods);
                ErrorsHelper::throwError($Res, $msg);
            }

            $transaction->commit();

            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

        return false;
    }

    public static function upGoodsRule($dis_id, $goods_id, $share_title, $share_desc, $share_img, $type, $levelsValue, $oneOptions, $twoOptions, $threeOptions)
    {
        $transaction = GoodsHubGoods::getDb()->beginTransaction();

        try {
            // 保存分销活动
            $GoodsHubGoods = new GoodsHubGoods();
            $goods = [
                'goods_id' => $goods_id,
                'share_title' => $share_title,
                'share_desc' => $share_desc,
                'share_img' => $share_img,
                'type' => $type,
                'one_options' => $oneOptions,
                'two_options' => $twoOptions,
                'three_options' => $threeOptions,
            ];

            $Res = $GoodsHubGoods->updateAll($goods, [
                'goods_id' => $goods_id,
                'id' => $dis_id,
            ]);

            // 获取当前等级
            $levelss = levelService::getLevels();
            $levels = array_values($levelss);
            // 保存分销活动规则
            $HubGoodsLevel = new HubGoodsLevel();

            for ($i = 0; $i <= 2; ++$i) {
                foreach ($levels as $key => $value) {
                    $_HubGoodsLevel = clone  $HubGoodsLevel;
                    $goodsLevel = [
                        'dis_option' => $levelsValue[$i][$value['levelnum']],
                    ];
                    $Res1 = $_HubGoodsLevel->updateAll($goodsLevel, [
                        'goods_id' => $goods_id,
                        'dis_id' => $dis_id,
                        'level_num' => $i,
                        'team_num' => $value['levelnum'],
                    ]);
                }
            }

            $transaction->commit();

            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

        return false;
    }

    public static function getGoodsRules($dis_id)
    {
        $HubGoodsLevel = new HubGoodsLevel();
        $levelsInfo = $HubGoodsLevel->find()->where(['dis_id' => $dis_id])->asArray()->all();
        $levelsValue = [];
        foreach ($levelsInfo as $key => $value) {
            $levelsValue[$value['level_num']][$value['team_num']] = $value['dis_option'];
        }

        return $levelsValue;
    }

    public static function deleteGoodsRule($dis_id)
    {
        $HubGoodsLevel = new HubGoodsLevel();

        return $HubGoodsLevel->deleteAll(['dis_id' => $dis_id]);
    }
}
