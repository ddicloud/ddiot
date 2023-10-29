<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-12 04:22:42
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-07-13 15:56:07
 */

namespace common\plugins\diandi_hub\services;

use common\plugins\diandi_hub\models\goods\HubGoodsBaseGoods;
use common\plugins\diandi_hub\models\goods\HubGoodsBaseSpec;
use common\plugins\diandi_hub\models\goods\HubSpecValue;
use common\plugins\diandi_hub\models\order\HubDiandiShopCart;
use common\helpers\ErrorsHelper;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use common\models\DdMemberAccount;
use common\services\BaseService;
use diandi\addons\models\BlocStore;
use Yii;

/**
 * Class SmsService.
 *
 * @author chunchun <2192138785@qq.com>
 */
class CartService extends BaseService
{
    public static function confirm($user_id, $goods_id, $num, $spec_id = 0)
    {
        $where = [
            'user_id' => $user_id, 'goods_id' => $goods_id,
        ];

        if ($spec_id) {
            $where['spec_id'] = $spec_id;
        }

        $isHave = HubDiandiShopCart::findOne($where);
        $spec_value_ids = explode('_', $spec_id);
        $specVal = HubSpecValue::find()
            ->where(['spec_value_id' => $spec_value_ids])
            ->indexBy('spec_value_id')
            ->all();
        $specs = [];

        if (!empty($spec_value_ids) && $spec_id) {
            foreach ($spec_value_ids as $key => $item) {
                $ks[] = $specVal[$item]['spec_value'];
            }
            $newKey = implode('_', $ks);
            $specs[$spec_id] = $newKey;
        }
        $goods = HubGoodsBaseGoods::find()->where(['goods_id' => $goods_id])->one();

        // 校验库存
        if ($goods['stock'] < $num) {
            return ResultHelper::json(401, $goods['goods_name'] . '库存不足', []);
        }

        if (!empty($isHave)) {
            if ($num < 0) {
                return ResultHelper::json(401, '商品数量不能为负数', []);
            } elseif ($num == 0) {
                HubDiandiShopCart::deleteAll($where);
            }

            $goods_price = $goods['goods_price'];

            if (!empty($spec_id)) {
                $spec = HubGoodsBaseSpec::find()->where([
                    'goods_id' => $goods_id,
                    'spec_sku_id' => $spec_id,
                ])->select(['goods_price', 'line_price'])->one();
                $goods_price = $spec['goods_price'];
            }
            if (empty($goods_price)) {
                $goods_price = $goods['goods_price'];
            }

            $total_price = $num * $goods_price;

            HubDiandiShopCart::updateAll([
                'number' => $num,
                'total_price' => number_format($total_price, 2, '.', ''),
                'goods_price' => $goods_price,
                'line_price' => empty($spec_id) ? $goods['line_price'] : $spec['line_price'],
            ], $where);
        } else {
            $goods_price = $goods['goods_price'];

            if (!empty($spec_id)) {
                $spec = HubGoodsBaseSpec::find()->where([
                    'goods_id' => $goods_id,
                    'spec_sku_id' => $spec_id,
                ])->select(['goods_price', 'line_price'])->one();
                $goods_price = $spec['goods_price'];
            }

            if (empty($goods_price)) {
                $goods_price = $goods['goods_price'];
            }

            $total_price = $num * $goods_price;
            $DdDiandiShopCart = new HubDiandiShopCart();
            $datas = [
                'bloc_id' => $goods['bloc_id'],
                'store_id' => $goods['store_id'],
                'user_id' => $user_id,
                'goods_id' => $goods_id,
                'number' => $num,
                'line_price' => empty($spec['line_price']) ? $goods['line_price'] : $spec['line_price'],
                'goods_price' => $goods_price,
                'total_price' => number_format($total_price, 2, '.', ''),
                'spec_id' => $spec_id,
                'spec_val' => isset($specs[$spec_id]) ? $specs[$spec_id] : '',
                'create_time' => time(),
            ];
            if (!$DdDiandiShopCart->load($datas, '') || !$DdDiandiShopCart->save()) {
                return ErrorsHelper::getModelError($DdDiandiShopCart);
            }
        }

        return self::list($user_id);
    }

    public static function list($user_id, $ids = [], $express_type = 0, $region_id = 0, $express_id = 0)
    {
        $lists = [];
        $goods_num = [];
        $where = [];
        $where['user_id'] = $user_id;

        // 购物车不限定是那个商户的

        // $bloc_id = Yii::$App->params['bloc_id'];
        // $store_id = Yii::$App->params['store_id'];
        // if ($bloc_id) {
        //     $where['bloc_id'] = $bloc_id;
        // }

        // if ($store_id) {
        //     $where['store_id'] = $store_id;
        // }

        if (!empty($ids)) {
            $where = ['IN', 'id', $ids];
        }

        $list = HubDiandiShopCart::find()
            ->where($where)
            ->with(['goods', 'goodsSpec'])
            ->asArray()
            ->all();

        $member = DdMemberAccount::find()->where(['member_id' => $user_id])->select(['credit1'])->one();
        $lists = [];
        $total_price = 0;
        // $total_price = 0;
        $goodsTotalNumber = 0;
        if (!empty($list)) {
            $DdDiandiShopCart = new HubDiandiShopCart();
            foreach ($list as $k => &$item) {
                $_DdDiandiShopCart = clone $DdDiandiShopCart;

                // 初始化购物车选项
                $item['selected'] = false;

                if (empty($item['goods'])) {
                    $_DdDiandiShopCart::deleteAll([
                        'user_id' => $user_id,
                        'goods_id' => $item['goods_id'],
                    ]);
                    unset($list[$k]);
                }
                // 商品总数
                // $goodsTotalNumber += $item['number'];
                ++$goodsTotalNumber;
                // 总价格
                $total_price += $item['total_price'];
                // 处理图片
                $item['goods']['thumb'] = ImageHelper::tomedia($item['goods']['thumb']);
                $item['specVal'] = str_replace('_', '/', $item['spec_val']);
                if (!isset($goods_num[$item['goods_id']])) {
                    $goods_num[$item['goods_id']] = $item['number'];
                } else {
                    $goods_num[$item['goods_id']] += $item['number'];
                }
                $goods_ids[] = $item['goods_id'];
                $store_ids[$item['store_id']] = $item['store_id'];
            }

            $stores = BlocStore::find()->where(['IN', 'store_id', $store_ids])->indexBy('store_id')->select(['store_id', 'name', 'logo'])->asArray()->all();

            foreach ($list as $key => $value) {
                $storeGoods[$value['store_id']][] = $value;
            }

            foreach ($stores as $key => $row) {
                $stores[$key]['logo'] = ImageHelper::tomedia($row['logo']);
            }

            $lists['stores'] = $stores;

            $lists['goodsTotalNumber'] = $goodsTotalNumber;
            $lists['goods'] = $storeGoods;
            $lists['goodslist'] = $list;
            $lists['goods_num'] = $goods_num;
            $lists['total_price'] = number_format($total_price, 2, '.', '');
            // 计算运费
            $lists['freight'] = ExpressService::getExpressPrice($user_id, $express_type, $region_id, $goods_ids, $goods_num, $express_id);

            $lists['pay_price'] = number_format($total_price + $lists['freight'], 2, '.', '');
        } else {
            $lists['goodsTotalNumber'] = 0;
            $lists['stores'] = [];
            $lists['goodslist'] = [];

            // 总价格
            $lists['total_price'] = 0;
            $lists['pay_price'] = number_format($total_price, 2, '.', '');
            $lists['goods'] = [];
            // 计算运费
            $lists['freight'] = self::freight();
        }

        // $store = Yii::$App->service->commonGlobalsService->getStoreDetail($store_id);
        // $sendtime = $store['sendtime'];

        // $lists['delivery_times'] = self::delivery_time($sendtime);

        // $startingPrice = is_numeric($store['startingPrice'])?$store['startingPrice']:0;

        // $lists['diffprice'] = number_format($startingPrice - $lists['total_price'], 2, '.', '');

        $lists['is_credit1'] = true;

        $lists['credit1'] = $member['credit1'];

        return $lists;
    }

    // 获取配送范围内的时间
    public static function delivery_time($sendtime)
    {
        $times = explode(',', $sendtime);
        $time = [];
        $time[1] = $times;
        $day[1] = '明天';

        // 今天的：
        foreach ($times as $key => $item) {
            list($start, $end) = explode('-', $item);
            $starttime = strtotime($start);
            $endtime = strtotime($end);
            // 12:00-17:00,17:00-03:00
            $num = $starttime < time() ? time() : $starttime;
            $s[] = $endtime - 60 * 60;
            if ($endtime - 60 * 60 > time()) {
                $time[0][] = $item;
                $day[0] = '今天';
            }
        }

        return [$day, $time, $s];
    }

    public static function clearAll($user_id)
    {
        $res = HubDiandiShopCart::deleteAll(['user_id' => $user_id]);

        return self::list($user_id);
    }

    public static function deleteCart($user_id, $cart_ids)
    {
        if (!is_array($cart_ids)) {
            $cart_ids = explode(',', $cart_ids);
        }
        $DdDiandiShopCart = new HubDiandiShopCart();
        $where = 'user_id=:user_id and id IN(:id)';
        $res = HubDiandiShopCart::deleteAll([
            'user_id' => $user_id,
            'id' => $cart_ids,
        ]);

        return self::list($user_id);
    }

    public static function freight()
    {
        $store_id = Yii::$app->params['store_id'];
        $store = Yii::$app->service->commonGlobalsService->getStoreDetail($store_id);

        return  $store['shippingDees'] ? $store['shippingDees'] : 0;
    }
}
