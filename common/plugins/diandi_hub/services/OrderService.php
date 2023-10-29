<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-12 23:31:55
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 19:06:13
 */

namespace common\plugins\diandi_hub\services;

use common\plugins\diandi_hub\models\enums\AccountChangeStatus;
use common\plugins\diandi_hub\models\enums\AccountTypeStatus;
use common\plugins\diandi_hub\models\enums\ExpressTypeStatus;
use common\plugins\diandi_hub\models\enums\GoodsTypeStatus;
use common\plugins\diandi_hub\models\enums\OrderStatus;
use common\plugins\diandi_hub\models\enums\OrderTypeStatus;
use common\plugins\diandi_hub\models\enums\PayStatus;
use common\plugins\diandi_hub\models\enums\PayTypeStatus;
use common\plugins\diandi_hub\models\goods\HubGift;
use common\plugins\diandi_hub\models\goods\HubGoodsBaseGoods;
use common\plugins\diandi_hub\models\goods\HubGoodsBaseSpec;
use common\plugins\diandi_hub\models\goods\HubSpecValue;
use common\plugins\diandi_hub\models\order\HubOrder;
use common\plugins\diandi_hub\models\order\HubOrderAddress;
use common\plugins\diandi_hub\models\order\HubOrderGoods;
use common\plugins\diandi_hub\services\account\logAccount;
use common\plugins\diandi_hub\services\account\OrderAccount;
use common\plugins\diandi_hub\services\events\DdOrderEvent;
use api\modules\wechat\models\DdWxappFans;
use common\components\printcloud\Feie;
use common\helpers\ArrayHelper;
use common\helpers\ErrorsHelper;
use common\helpers\FileHelper;
use common\helpers\ImageHelper;
use common\helpers\loggingHelper;
use common\helpers\ResultHelper;
use common\models\DdCorePaylog;
use common\models\DdRegion;
use common\models\DdUserAddress;
use common\services\BaseService;
use Exception;
use Yii;
use yii\data\Pagination;
use yii\helpers\Json;

class OrderService extends BaseService
{
    public static $listeners = [
        // 主模块的业务事件
        DdOrderEvent::EVENT_ORDER_CREATE => [
            ['createOrder', 1],
            ['createAddonsOrder', 1],
        ],
    ];

    public static function createOrderFlower($event)
    {
        //$event->setOrder(123);

        $user_id = $event->user_id;
        $cartIds = $event->cartIds;
        $total_price = $event->total_price;
        $express_price = $event->express_price;
        $express_type = $event->express_type;
        $address_id = $event->address_id;
        $remark = $event->remark;
        $name = $event->name;
        $phone = $event->phone;
        $delivery_time = $event->delivery_time;

        $res = self::createOrder($user_id, $cartIds, $total_price, $express_price, $express_type, $address_id, $remark, $name, $phone, $delivery_time);

        $event->setOrderId($res['order_id']);
    }

    /**
     * 购物车创建订单.
     *
     * @return void
     */
    public static function createOrder($event)
    {
        $user_id = $event->user_id;
        $cartIds = $event->cartIds;
        $total_price = $event->total_price;
        $express_price = $event->express_price;
        $express_type = $event->express_type;
        $address_id = $event->address_id;
        $remark = $event->remark;
        $name = $event->name;
        $phone = $event->phone;
        $delivery_time = $event->delivery_time;

        loggingHelper::writeLog('diandi_hub', 'OrderService/createOrder', '购物车ID', $cartIds);

        $express_price = $express_type == 0 ? $express_price : 0;

        $good = CartService::list($user_id, $cartIds);

        loggingHelper::writeLog('diandi_hub', 'OrderService/createOrder', '购物车商品', $good);

        $goods = $good['goodslist'];
        $order_body = $goods[0]['goods']['goods_name'];

        foreach ($goods as $key => $value) {
            $goodsAll[$value['store_id']] = $value;
        }

        // 0:分订单 1总订单
        $is_split = count($goodsAll) > 1 ? 1 : 0; //是否为分订单

        if ($is_split == 0) {
            // 单一商户订单直接使用商品的集团商户数据
            $store_id = intval($good[0]['store_id']);
            $bloc_id = intval($good[0]['bloc_id']);

            if ($store_id == Yii::$app->params['global_store_id']) {
                $order_type = OrderTypeStatus::getValueByName('自营订单');
            } else {
                $order_type = OrderTypeStatus::getValueByName('在线订单');
            }
        } else {
            $store_id = intval(Yii::$app->params['global_store_id']);
            $bloc_id = intval(Yii::$app->params['global_bloc_id']);

            $order_type = OrderTypeStatus::getValueByName('合并订单');
        }

        $parent_order_no = self::CreateOrderno();

        // 订单基础信息写入
        $orderbase = [
            'store_id' => $store_id,
            'bloc_id' => $bloc_id,
            'order_no' => $parent_order_no, //订单编号
            'total_price' => $total_price, //付款总额
            'pay_price' => $total_price + $express_price, //订单金额
            'pay_status' => PayStatus::NONPAYMENT, //支付状态
            'remark' => $remark, //订单备注
            'order_body' => $order_body,
            'express_type' => $express_type,
            // "pay_time" => $order['pay_time'], //付款时间
            'express_price' => $express_price, //运费
            'order_type' => $order_type,
            'is_split' => $is_split,
            // "express_company" => $order['express_company'], //快递公司
            // "express_no" => $order['express_no'], //快递号码
            // "delivery_status" => $order['delivery_status'], //发货状态
            // "delivery_time" => $order['delivery_time'], //发货时间
            // "receipt_status" => $order['receipt_status'], //收货状态
            // "receipt_time" => $order['receipt_time'], //收货时间
            'order_status' => OrderStatus::NONPAYMENT, //订单状态
            // "transaction_id" => $order['transaction_id'], //微信支付订单号
            'user_id' => $user_id, //会员id
        ];

        loggingHelper::writeLog('diandi_hub', 'OrderService/createOrder', '创建订单', $orderbase);

        $transaction = HubOrder::getDb()->beginTransaction();
        try {
            $DdOrder = new HubOrder();
            loggingHelper::writeLog('diandi_hub', 'OrderService/createOrder', '开始写入');

            if ($DdOrder->load($orderbase, '') && $DdOrder->save()) {
                $order_id = $DdOrder->order_id;
                // 订单商品
                if ($goods) {
                    // 保存订单商品信息
                    $DdOrderGoods = new  HubOrderGoods();
                    $DdGoodsSpec = new HubGoodsBaseSpec();
                    $goods_ids = array_column($goods, 'goods_id');
                    $specAll = $DdGoodsSpec::find()->where(['goods_id' => $goods_ids])->with(['goodsSpecRel'])
                        ->asArray()
                        ->all();
                    foreach ($specAll as $key => $value) {
                        $goods_specs[$value['goods_id']][$value['spec_sku_id']] = $value;
                    }
                    $store_id = Yii::$app->params['store_id'];
                    $specValueAll = HubSpecValue::find()->where(['store_id' => $store_id])->indexBy('spec_value_id')->asArray()->all();
                    loggingHelper::writeLog('diandi_hub', 'CreateOrder', '全部属性', $specValueAll);
                    foreach ($goods as $items) {
                        $item = $items['goods'];
                        $orderbase_body[] = $item['goods_name'];
                        $goods_spec = $goods_specs[$items['goods_id']][$items['spec_id']];
                        $goods_price = $items['goods_price'];
                        $line_price = $items['line_price'];
                        $total_num = (int) $items['number'];
                        $goods_weight = empty($items['spec_id']) ? $item['goods_weight'] : $goods_spec['goods_weight'];
                        $goods_no = empty($items['spec_id']) ? $item['goods_no'] : $goods_spec['goods_no'];
                        $total_price = $goods_price * $total_num;
                        $goods_id = $item['goods_id'];
                        $spec_id = $item['spec_id'];
                        $goods_spec_id = $goods_specs[$item['goods_id']][$items['spec_id']]['goods_spec_id'];

                        $spec_sku_id = $goods_specs[$goods_id][$spec_id]['spec_sku_id'];

                        loggingHelper::writeLog('diandi_hub', 'CreateOrder', 'goods_spec_id', $goods_spec_id);

                        loggingHelper::writeLog('diandi_hub', 'CreateOrder', 'specValueAll', $specValueAll[$goods_spec_id]);

                        $order_goods = [
                            'store_id' => $item['store_id'],
                            'bloc_id' => $item['bloc_id'],
                            'goods_id' => $item['goods_id'],
                            'goods_name' => $item['goods_name'],
                            'goods_type' => $item['goods_type'],
                            'goods_costprice' => $item['goods_costprice'] * $total_num,
                            'thumb' => $item['thumb'],
                            'deduct_stock_type' => $item['deduct_stock_type'],
                            'stock_up' => $item['deduct_stock_type'] == 10 ? 1 : 0,
                            'spec_type' => empty($item['spec_id']) ? 1 : 0,
                            'spec_sku_id' => $spec_sku_id,
                            'goods_spec_id' => $goods_spec_id,
                            'goods_attr' => $specValueAll[$spec_sku_id]['spec_value'],
                            'content' => $item['content'] ? $item['content'] : 'rr',
                            'goods_no' => $goods_no,
                            'goods_price' => $goods_price,
                            'line_price' => $line_price,
                            'goods_weight' => $goods_weight,
                            'total_num' => $total_num,
                            'total_price' => $total_price,
                            'order_id' => $order_id,
                            'user_id' => $user_id,
                        ];
                        $_DdOrderGoods = clone $DdOrderGoods;
                        $_DdOrderGoods->setAttributes($order_goods);
                        $_DdOrderGoods->save();
                    }
                    // 校验库存并操作库存
                    self::stockReduce($goods);
                }
                $DdOrderAddress = new HubOrderAddress();
                // 0 外卖配送-取用户的地址  1上门取货-取配送点
                $region_id = 0;

                if ($express_type == ExpressTypeStatus::getValueByName('快递配送')) {
                    $areas = DdUserAddress::findOne(['address_id' => $address_id]);
                    $order_address = [
                        'name' => $areas['name'],
                        'phone' => $areas['phone'],
                        'province_id' => $areas['province_id'],
                        'city_id' => $areas['city_id'],
                        'region_id' => $areas['region_id'],
                        'detail' => $areas['detail'],
                        'delivery_time' => $delivery_time,
                        'order_id' => $order_id,
                        'user_id' => $user_id,
                    ];
                    $region_id = $areas['region_id'];
                    $DdOrderAddress->load($order_address, '');
                } else {
                    // 配送点取货或送货
                    $store_id = Yii::$app->params['store_id'];
                    $storeInfo = Yii::$app->service->commonGlobalsService->getStoreDetail($store_id);

                    $order_address = [
                        'name' => $storeInfo['name'],
                        'phone' => $storeInfo['mobile'],
                        'province_id' => intval($storeInfo['province']),
                        'city_id' => intval($storeInfo['city']),
                        'region_id' => intval($storeInfo['county']),
                        'detail' => $storeInfo['address'],
                        'delivery_time' => $delivery_time,
                        'order_id' => $order_id,
                        'user_id' => $user_id,
                    ];
                    $DdOrderAddress->load($order_address, '');
                }
                $DdOrderAddress->save($order_address);
            // 订单收货地址
            } else {
                $msg = ErrorsHelper::getModelError($DdOrder);

                loggingHelper::writeLog('diandi_hub', 'OrderService/createOrder', '写入订单错误', $msg);
            }

            if ($is_split == 1) {
                loggingHelper::writeLog('diandi_hub', 'OrderService/createOrder', '创建分订单');

                self::createSplitOrder($parent_order_no, $user_id, $good, $total_price, $express_price, $express_type, $address_id, $remark, $name, $phone, $delivery_time, $region_id);
            } else {
                // 写入分销财务日志
                HubService::disOrderLog($order_id);
            }

            // 删除购物车
            // CartService::clearAll($user_id);
            // 写入订单支付日志
            self::paylog($orderbase, $order_id);

            $transaction->commit();
        } catch (\Exception $e) {
            loggingHelper::writeLog('diandi_hub', 'OrderService/createOrder', 'Exception错误', $e);

            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            loggingHelper::writeLog('diandi_hub', 'OrderService/createOrder', 'Throwable错误', $e);

            $transaction->rollBack();
            throw $e;
        }
        $orderbase['order_id'] = $order_id;
        $orderbase['body'] = $orderbase_body[0];
        $event->order_id = $order_id;
        $event->orderInfo = $orderbase;

        return $orderbase;
    }

    public static function createAddonsOrder($event)
    {
    }

    public static function createSplitOrder($parent_order_no, $user_id, $good, $total_price, $express_price, $express_type, $address_id, $remark, $name, $phone, $delivery_time, $region_id)
    {
        $express_price = $express_type == 0 ? $express_price : 0;

        $goodsAll = $good['goods'];

        // $goods = $good['goodslist'];

        // 0:分订单 1总订单
        $is_split = 0; //是否为分订单

        $store_id = Yii::$app->params['store_id'];
        $specValueAll = HubSpecValue::find()->indexBy('spec_value_id')->asArray()->all();
        loggingHelper::writeLog('diandi_hub', 'CreateOrder', '全部属性', $specValueAll);

        foreach ($goodsAll as $store_id => $goods) {
            $store_id = $goods[0]['store_id'];
            $bloc_id = $goods[0]['bloc_id'];
            $order_body = $goods[0]['goods']['goods_name'];

            if ($store_id == Yii::$app->params['global_store_id']) {
                $order_type = OrderTypeStatus::getValueByName('自营订单');
            } else {
                $order_type = OrderTypeStatus::getValueByName('在线订单');
            }

            $goods_ids = array_column($goods, 'goods_id');

            $goods_nums = array_column($goods, 'number');

            $express_price = ExpressService::getExpressPrice($user_id, $express_type, $region_id, $goods_ids, $goods_nums);

            $total_prices = array_column($goods, 'total_price');
            $total_price = array_sum($total_prices);

            // 订单基础信息写入
            $orderbaseSplit = [
                'store_id' => $store_id,
                'bloc_id' => $bloc_id,
                'order_no' => self::CreateOrderno(), //订单编号
                'parent_order_no' => $parent_order_no,
                'total_price' => $total_price, //付款总额
                'pay_price' => $total_price + $express_price, //订单金额
                'pay_status' => PayStatus::NONPAYMENT, //支付状态
                'remark' => $remark, //订单备注
                'order_body' => $order_body,
                'express_type' => $express_type,
                // "pay_time" => $order['pay_time'], //付款时间
                'express_price' => $express_price, //运费
                'order_type' => $order_type,
                'is_split' => $is_split,
                // "express_company" => $order['express_company'], //快递公司
                // "express_no" => $order['express_no'], //快递号码
                // "delivery_status" => $order['delivery_status'], //发货状态
                // "delivery_time" => $order['delivery_time'], //发货时间
                // "receipt_status" => $order['receipt_status'], //收货状态
                // "receipt_time" => $order['receipt_time'], //收货时间
                'order_status' => OrderStatus::NONPAYMENT, //订单状态
                // "transaction_id" => $order['transaction_id'], //微信支付订单号
                'user_id' => $user_id, //会员id
            ];

            $DdOrder = new HubOrder();
            if ($DdOrder->load($orderbaseSplit, '') && $DdOrder->save()) {
                $order_id = $DdOrder->order_id;
                // 订单商品
                if ($goods) {
                    // 保存订单商品信息
                    $DdOrderGoods = new  HubOrderGoods();
                    $DdGoodsSpec = new HubGoodsBaseSpec();
                    $goods_ids = array_column($goods, 'goods_id');
                    $specAll = $DdGoodsSpec::find()->where(['goods_id' => $goods_ids])->with(['goodsSpecRel'])
                        ->asArray()
                        ->all();
                    foreach ($specAll as $key => $value) {
                        $goods_specs[$value['goods_id']][$value['spec_sku_id']] = $value;
                    }
                    foreach ($goods as $items) {
                        $item = $items['goods'];
                        $orderbase_body[] = $item['goods_name'];
                        $goods_spec = $goods_specs[$items['goods_id']][$items['spec_id']];
                        $goods_price = $items['goods_price'];
                        $line_price = $items['line_price'];
                        $total_num = (int) $items['number'];
                        $goods_weight = empty($items['spec_id']) ? $item['goods_weight'] : $goods_spec['goods_weight'];
                        $goods_no = empty($items['spec_id']) ? $item['goods_no'] : $goods_spec['goods_no'];
                        $total_price = $goods_price * $total_num;
                        $goods_id = $item['goods_id'];
                        $spec_id = $item['spec_id'];
                        $goods_spec_id = $goods_specs[$item['goods_id']][$items['spec_id']]['goods_spec_id'];

                        $spec_sku_id = $goods_specs[$goods_id][$spec_id]['spec_sku_id'];

                        loggingHelper::writeLog('diandi_hub', 'CreateOrder', 'goods_spec_id', $goods_spec_id);

                        loggingHelper::writeLog('diandi_hub', 'CreateOrder', 'specValueAll', $specValueAll[$goods_spec_id]);

                        $order_goods = [
                            'store_id' => $item['store_id'],
                            'bloc_id' => $item['bloc_id'],
                            'goods_id' => $item['goods_id'],
                            'goods_name' => $item['goods_name'],
                            'goods_costprice' => $item['goods_costprice'] * $total_num,
                            'thumb' => $item['thumb'],
                            'deduct_stock_type' => $item['deduct_stock_type'],
                            'stock_up' => $item['deduct_stock_type'] == 10 ? 1 : 0,
                            'spec_type' => empty($item['spec_id']) ? 1 : 0,
                            'spec_sku_id' => $spec_sku_id,
                            'goods_type' => $item['goods_type'],
                            'goods_spec_id' => $goods_spec_id,
                            'goods_attr' => $specValueAll[$spec_sku_id]['spec_value'],
                            'content' => $item['content'] ? $item['content'] : 'rr',
                            'goods_no' => $goods_no,
                            'goods_price' => $goods_price,
                            'line_price' => $line_price,
                            'goods_weight' => $goods_weight,
                            'total_num' => $total_num,
                            'total_price' => $total_price,
                            'order_id' => $order_id,
                            'user_id' => $user_id,
                        ];
                        $_DdOrderGoods = clone $DdOrderGoods;
                        $_DdOrderGoods->setAttributes($order_goods);
                        $_DdOrderGoods->save();
                    }
                    // 校验库存并操作库存
                    self::stockReduce($goods);
                }
                $DdOrderAddress = new HubOrderAddress();
                // 0 外卖配送-取用户的地址  1上门取货-取配送点

                if ($express_type == ExpressTypeStatus::getValueByName('快递配送')) {
                    $areas = DdUserAddress::findOne(['address_id' => $address_id]);
                    $order_address = [
                        'name' => $areas['name'],
                        'phone' => $areas['phone'],
                        'province_id' => $areas['province_id'],
                        'city_id' => $areas['city_id'],
                        'region_id' => $areas['region_id'],
                        'detail' => $areas['detail'],
                        'delivery_time' => $delivery_time,
                        'order_id' => $order_id,
                        'user_id' => $user_id,
                    ];
                    $DdOrderAddress->load($order_address, '');
                } else {
                    // 配送点取货或送货
                    $store_id = Yii::$app->params['store_id'];
                    $storeInfo = Yii::$app->service->commonGlobalsService->getStoreDetail($store_id);

                    $order_address = [
                        'name' => $storeInfo['name'],
                        'phone' => $storeInfo['mobile'],
                        'province_id' => intval($storeInfo['province']),
                        'city_id' => intval($storeInfo['city']),
                        'region_id' => intval($storeInfo['county']),
                        'detail' => $storeInfo['address'],
                        'delivery_time' => $delivery_time,
                        'order_id' => $order_id,
                        'user_id' => $user_id,
                    ];
                    $DdOrderAddress->load($order_address, '');
                }
                $DdOrderAddress->save($order_address);
                // 订单收货地址
            }

            // 删除购物车
            // CartService::clearAll($user_id);
            // 写入订单支付日志
            self::paylog($orderbaseSplit, $order_id);
            // 写入分销财务日志
            HubService::disOrderLog($order_id);
        }
    }

    /**
     * 商品直接购买.
     *
     * @param [type] $user_id       用户id
     * @param float  $total_price   订单总额
     * @param [type] $express_price 运费
     * @param [type] $express_type  地址类型 1配送点 2自由地址
     * @param [type] $name          姓名
     * @param [type] $phone         电话
     *
     * @return void
     */
    public static function creategoodsorder($user_id, $goods_id, $goods_num, $total_price, $express_price, $express_type, $address_id, $remark, $name, $phone, $delivery_time, $spec_id = '', $goods_type = 0)
    {
        loggingHelper::writeLog('diandi_hub', 'OrderService/creategoodsorder', '商品类型', $goods_type);

        $express_price = $express_type == 0 ? $express_price : 0;

        $goods_type = HubGoodsBaseGoods::find()->where(['goods_id' => $goods_id])->select('goods_type')->scalar();

        $good = GoodsService::getOrderDetail($goods_id, $goods_num, $spec_id, $goods_type);

        $goods = $good['goods'];
        $order_body = $goods[0]['goods']['goods_name'];

        $store_id = $goods[0]['store_id'];
        $bloc_id = $goods[0]['bloc_id'];

        switch ($goods_type) {
            case GoodsTypeStatus::getValueByName('店铺商品'):
                // 店铺商品
                $order_type = OrderTypeStatus::getValueByName('在线订单');
                break;
            case  GoodsTypeStatus::getValueByName('礼包商品'):
                // 礼包商品
                $order_type = OrderTypeStatus::getValueByName('尊享订单');

                break;
            case  GoodsTypeStatus::getValueByName('自营商品'):
                // 自营商品
                $order_type = OrderTypeStatus::getValueByName('自营订单');

                break;
        }

        // 订单基础信息写入
        $orderbase = [
            'store_id' => $store_id,
            'bloc_id' => $bloc_id,
            'order_no' => self::CreateOrderno(), //订单编号
            'total_price' => $total_price, //付款总额
            'pay_price' => $total_price + $express_price, //订单金额
            'pay_status' => PayStatus::NONPAYMENT, //支付状态
            'remark' => $remark, //订单备注
            'order_body' => $order_body,
            'express_type' => $express_type,
            'order_type' => $order_type,
            // "pay_time" => $order['pay_time'], //付款时间
            'express_price' => $express_price, //运费
            'is_split' => 0,
            // "express_company" => $order['express_company'], //快递公司
            // "express_no" => $order['express_no'], //快递号码
            // "delivery_status" => $order['delivery_status'], //发货状态
            // "delivery_time" => $order['delivery_time'], //发货时间
            // "receipt_status" => $order['receipt_status'], //收货状态
            // "receipt_time" => $order['receipt_time'], //收货时间
            'order_status' => OrderStatus::NONPAYMENT, //订单状态
            // "transaction_id" => $order['transaction_id'], //微信支付订单号
            'user_id' => $user_id, //会员id
        ];
        $transaction = HubOrder::getDb()->beginTransaction();
        try {
            $DdOrder = new HubOrder();
            $checkAddressBool = false;
            if ($DdOrder->load($orderbase, '') && $DdOrder->save()) {
                $order_id = $DdOrder->order_id;
                // 订单商品
                if ($goods) {
                    // 保存订单商品信息
                    $DdOrderGoods = new  HubOrderGoods();
                    $DdGoodsSpec = new HubGoodsBaseSpec();
                    $goods_ids = array_column($goods, 'goods_id');
                    $specAll = $DdGoodsSpec::find()->where(['goods_id' => $goods_ids])->with(['goodsSpecRel'])
                        ->asArray()
                        ->all();

                    // 获取所有的礼包数据，以商品id做区分
                    $giftAll = HubGift::find()
                        ->select(['goods_id', 'performance'])
                        ->indexBy('goods_id')
                        ->asArray()->all();

                    foreach ($specAll as $key => $value) {
                        $goods_specs[$value['goods_id']][$value['spec_sku_id']] = $value;
                    }
                    $store_id = Yii::$app->params['store_id'];

                    $specValueAll = HubSpecValue::find()->indexBy('spec_value_id')->asArray()->all();

                    loggingHelper::writeLog('diandi_hub', 'OrderService/creategoodsorder', '订单商品写入数据', $goods);

                    foreach ($goods as $items) {
                        $item = $items['goods'];

                        if (!$checkAddressBool && !in_array($item['goods_type'], [GoodsTypeStatus::APPLICATION, GoodsTypeStatus::COMBO])) {
                            $checkAddressBool = true;
                        }

                        // 礼包按照业绩分红，做特殊处理
                        $performance = $giftAll[$goods_id]['performance'];

                        $orderbase_body[] = $item['goods_name'];
                        $goods_spec = $goods_specs[$goods_id][$spec_id];
                        $goods_price = $items['goods_price'];
                        $line_price = $items['line_price'];
                        $total_num = (int) $items['number'];
                        $goods_weight = empty($spec_id) ? $item['goods_weight'] : $goods_spec['goods_weight'];
                        $goods_no = empty($spec_id) ? $item['goods_no'] : $goods_spec['goods_no'];
                        $total_price = $goods_price * $total_num;
                        $goods_spec_id = $goods_specs[$goods_id][$spec_id]['goods_spec_id'];

                        $spec_sku_id = $goods_specs[$goods_id][$spec_id]['spec_sku_id'];

                        loggingHelper::writeLog('diandi_hub', 'OrderService/creategoodsorder', '全部属性', $specValueAll);

                        loggingHelper::writeLog('diandi_hub', 'OrderService/creategoodsorder', '属性id', $spec_sku_id);

                        $order_goods = [
                            'store_id' => $item['store_id'],
                            'bloc_id' => $item['bloc_id'],
                            'goods_id' => $item['goods_id'],
                            'goods_name' => $item['goods_name'],
                            'goods_costprice' => $item['goods_costprice'] * $total_num,
                            'goods_type' => $goods_type,
                            'thumb' => $item['thumb'],
                            'deduct_stock_type' => $item['deduct_stock_type'],
                            'stock_up' => $item['deduct_stock_type'] == 10 ? 1 : 0,
                            'spec_type' => empty($spec_id) ? 1 : 0,
                            'spec_sku_id' => $spec_sku_id,
                            'goods_spec_id' => $goods_spec_id,
                            'goods_attr' => $specValueAll[$spec_sku_id]['spec_value'],
                            'content' => $item['content'] ? $item['content'] : 'rr',
                            'goods_no' => $goods_no,
                            'goods_price' => $goods_price,
                            'line_price' => $line_price,
                            'goods_weight' => $goods_weight,
                            'total_num' => $total_num,
                            'total_price' => $total_price,
                            'order_id' => $order_id,
                            'user_id' => $user_id,
                            'performance' => $performance,
                        ];

                        loggingHelper::writeLog('diandi_hub', 'OrderService/creategoodsorder', '订单商品单条数据', $order_goods);

                        if (empty($spec_id)) {
                            $order_goods['spec_sku_id'] = '';
                            $order_goods['goods_spec_id'] = 0;
                        }

                        $_DdOrderGoods = clone $DdOrderGoods;
                        $_DdOrderGoods->setAttributes($order_goods);
                        if (!$_DdOrderGoods->save()) {
                            $msg = ErrorsHelper::getModelError($_DdOrderGoods);
                            loggingHelper::writeLog('diandi_hub', 'OrderService/creategoodsorder', '订单商品单条数据写入失败', $msg);

                            return  $msg;
                        }
                    }
                    // 校验库存并操作库存
                    self::stockReduce($goods);
                }
                $DdOrderAddress = new HubOrderAddress();
                // 0 外卖配送-取用户的地址  1上门取货-取配送点
                if ($checkAddressBool === true) {
                    if ($checkAddressBool && $address_id <= 0) {
                        throw new Exception('无效的收货地址');
                    } else {
                        $areas = DdUserAddress::findOne(['address_id' => $address_id]);
                        if ($express_type == ExpressTypeStatus::getValueByName('快递配送')) {
                            $order_address = [
                                'name' => $areas['name'],
                                'phone' => $areas['phone'],
                                'province_id' => $areas['province_id'],
                                'city_id' => $areas['city_id'],
                                'region_id' => $areas['region_id'],
                                'detail' => $areas['detail'],
                                'delivery_time' => $delivery_time,
                                'order_id' => $order_id,
                                'user_id' => $user_id,
                            ];
                            $DdOrderAddress->load($order_address, '');
                        } else {
                            // 配送点取货或送货
                            $store_id = Yii::$app->params['store_id'];
                            $storeInfo = Yii::$app->service->commonGlobalsService->getStoreDetail($store_id);

                            $order_address = [
                                'name' => $storeInfo['name'],
                                'phone' => $storeInfo['mobile'],
                                'province_id' => intval($storeInfo['province']),
                                'city_id' => intval($storeInfo['city']),
                                'region_id' => intval($storeInfo['county']),
                                'detail' => $storeInfo['address'],
                                'delivery_time' => $delivery_time,
                                'order_id' => $order_id,
                                'user_id' => $user_id,
                            ];
                            $DdOrderAddress->load($order_address, '');
                        }
                        $DdOrderAddress->save($order_address);
                        // 订单收货地址
                        loggingHelper::writeLog('diandi_hub', 'OrderService/creategoodsorder', '订单ID1', $order_id);
                    }
                }
            } else {
                $msg = ErrorsHelper::getModelError($DdOrder);
                loggingHelper::writeLog('diandi_hub', 'OrderService/creategoodsorder', '订单写入失败', $msg);
            }

            loggingHelper::writeLog('diandi_hub', 'OrderService/creategoodsorder', '订单ID2', $order_id);

            // 删除购物车
            // CartService::clearAll($user_id);
            // 写入订单支付日志
            self::paylog($orderbase, $order_id);

            loggingHelper::writeLog('diandi_hub', 'OrderService/creategoodsorder', '订单ID3', $order_id);

            // 写入分销财务日志
            HubService::disOrderLog($order_id);
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            loggingHelper::writeLog('diandi_hub', 'OrderService/creategoodsorder', 'Exception错误', $e->getMessage());

            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            loggingHelper::writeLog('diandi_hub', 'OrderService/creategoodsorder', 'Throwable错误', $e);

            throw $e;
        }
        $orderbase['order_id'] = $order_id;
        $orderbase['body'] = $orderbase_body[0];

        return $orderbase;
    }

    // 减少库存
    public static function stockReduce($goods)
    {
        $path = Yii::getAlias('@runtime/diandi_hub/log/order.log');
        if (!empty($goods) && is_array($goods)) {
            FileHelper::writeLog($path, '下单商品库存处理'.json_encode($goods));
            $DdGoods = new HubGoodsBaseGoods();
            // 实时获取当前商品库存
            $goods_ids = array_column($goods, 'goods_id');
            // 获取所有的商品库存
            $stocks = $DdGoods->find()
                ->where(['goods_id' => $goods_ids])
                ->select(['stock', 'goods_id'])
                ->indexBy('goods_id')
                ->asArray()
                ->all();
            $DdGoodsSpec = new HubGoodsBaseSpec();
            foreach ($goods as $item) {
                $_DdGoods = clone $DdGoods;
                $_DdGoodsSpec = clone $DdGoodsSpec;
                // 更新库存
                if ($item['deduct_stock_type'] == 10) {
                    // 实时库存
                    $stock = $stocks[$item['goods_id']]['stock'];
                    if ($item['number'] > $stock) {
                        throw new \Exception($item['goods_name'].'库存不足');
                    }
                    $res = $_DdGoods::updateAllCounters(['stock' => -$item['number']], ['goods_id' => $item['goods_id']]);
                    FileHelper::writeLog($path, '下单商品库存处理结果'.json_encode($res));
                    FileHelper::writeLog($path, '更新数据'.json_encode([['stock' => -$item['number']], ['goods_id' => $item['goods_id']]]));
                    if (!empty($item['spec_id'])) {
                        $_DdGoodsSpec::updateAllCounters(
                            [
                                'stock_num' => -$item['number'],
                                'sales_initial' => +$item['total_num'],
                                'sales_actual' => +$item['total_num'],
                            ],
                            [
                                'goods_id' => $item['goods_id'],
                                'spec_sku_id' => $item['spec_id'],
                            ]
                        );
                    }
                }
            }
        }
    }

    // 写入订单支付日志
    public static function paylog($order, $order_id)
    {
        $user_id = $order['user_id'];
        $fans = DdWxappFans::getFansByUid($user_id);
        $openid = $fans['openid'];
        $data = [
            'type' => 'wechat',
            'openid' => $openid,
            'member_id' => $user_id,
            'uniontid' => $order['order_no'],
            'fee' => $order['total_price'],
            'status' => 0,
            'module' => 'diandi_hub',
            'tag' => '小程序下单',
        ];
        $DdCorePaylog = new DdCorePaylog();
        $DdCorePaylog->load($data, '');
        $res = $DdCorePaylog->save();

        return $res;
    }

    /**
     * 付款成功后回调.
     *
     * @param [type] $out_trade_no   订单编号
     * @param [type] $total_fee      总金额
     * @param string $transaction_id 微信单号
     * @param string $logPath        日志路径
     *
     * @return void
     */
    public static function orderNotify($out_trade_no, $total_fee, $transaction_id = '', $logPath = '@api/modules/wechat/log/paynotify/wechat.log')
    {
        // $logPath =$is_app=='wechat'?'@api/modules/wechat/log/paynotify/wechat.log': '@backend/modules/diandi_hub/log/paynotify/wechat.log';

        // $transaction_id = $is_app=='wechat'?$params['transaction_id']:'';
        // $out_trade_no = $is_app=='wechat'?$params['out_trade_no']:$params['order_no'];
        // $total_fee = $is_app=='wechat'?$params['total_fee'] :$params['pay_price'];

        FileHelper::writeLog($logPath, '模块内回调'.$out_trade_no);
        //支付金额校验
        $orderInfo = HubOrder::findOne(['order_no' => $out_trade_no]);
        FileHelper::writeLog($logPath, '订单获取'.Json::encode($orderInfo));

        FileHelper::writeLog($logPath, '付款状态'.OrderStatus::getValueByName('已付款'));

        if ($orderInfo['order_status'] == OrderStatus::getValueByName('已付款') && !empty($transaction_id)) {
            return ArrayHelper::toXml(['return_code' => 'SUCCESS', 'return_msg' => 'OK']);
        }
        $transaction = HubOrder::getDb()->beginTransaction();

        try {
            FileHelper::writeLog($logPath, '模块内回调1');
            // if ($orderInfo['pay_price'] * 100 != $total_fee) {
            //     return false;
            // }
            // 订单状态、微信支付订单号码更新修改
            HubOrder::updateAll([
                'order_status' => OrderStatus::getValueByName('已付款'),
                'pay_status' => 1,
                'pay_time' => time(),
                'transaction_id' => $transaction_id,
            ], ['order_no' => $out_trade_no]);
            FileHelper::writeLog($logPath, '模块内回调2');

            // 支付减库存处理
            $order_goods = HubOrderGoods::find()->where([
                'order_id' => $orderInfo['order_id'],
                'user_id' => $orderInfo['user_id'],
                'stock_up' => 0,
                'deduct_stock_type' => 20,
            ])->select(['goods_id', 'total_num', 'goods_name'])->all();
            FileHelper::writeLog($logPath, '模块内回调3');

            $DdGoods = new HubGoodsBaseGoods();
            $DdGoodsSpec = new  HubGoodsBaseSpec();
            // 实时获取当前商品库存
            $goods_ids = array_keys(ArrayHelper::arrayKey($order_goods, 'goods_id'));
            FileHelper::writeLog($logPath, '所有商品id'.json_encode($goods_ids));
            FileHelper::writeLog($logPath, '所有商品'.json_encode($order_goods));

            // 获取所有的商品库存
            $stocks = $DdGoods->find()
                ->where(['goods_id' => $goods_ids])
                ->select(['stock', 'goods_id'])
                ->indexBy('goods_id')
                ->asArray()
                ->all();
            FileHelper::writeLog($logPath, '所有商品库存'.json_encode($stocks));
            if (!empty($order_goods)) {
                foreach ($order_goods as $item) {
                    $_DdGoods = clone $DdGoods;
                    $_DdGoodsSpec = clone $DdGoodsSpec;
                    // 更新库存
                    // 实时库存
                    $stock = $stocks[$item['goods_id']]['stock'];
                    FileHelper::writeLog($logPath, '实时'.$stock);
                    if ($item['total_num'] > $stock) {
                        FileHelper::writeLog($logPath, $item['goods_name'].'库存不足');
                        throw new \Exception($item['goods_name'].'库存不足');
                    }
                    $res = $_DdGoods::updateAllCounters(['stock' => -$item['total_num']], ['goods_id' => $item['goods_id']]);
                    FileHelper::writeLog($logPath, '下单商品库存处理结果'.json_encode($res));
                    FileHelper::writeLog($logPath, '更新数据'.json_encode([['stock' => -$item['total_num']], ['goods_id' => $item['goods_id']]]));
                    $_DdGoodsSpec::updateAllCounters(
                        [
                            'stock_num' => -$item['total_num'],
                        ],
                        [
                            'goods_id' => $item['goods_id'],
                            'spec_sku_id' => $item['spec_sku_id'],
                        ]
                    );
                }
            }

            FileHelper::writeLog($logPath, '库存处理完成');

            // 日志状态、微信支付订单号码更新修改
            DdCorePaylog::updateAll([
                'status' => 1,
                'tid' => $transaction_id,
            ], ['uniontid' => $out_trade_no]);
            // 返回成功
            FileHelper::writeLog($logPath, '支付回调返回成功');
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            FileHelper::writeLog($logPath, '错误信息1'.Json::encode($e));
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            FileHelper::writeLog($logPath, '错误信息2'.Json::encode($e));
            throw $e;
        }
    }

    public static function integralPay($order_id)
    {
        loggingHelper::writeLog('diandi_hub', 'OrderService/integralPay', '余额支付', $order_id);

        $orderInfo = HubOrder::findOne(['order_id' => $order_id]);

        if ($orderInfo['order_type'] == OrderTypeStatus::getValueByName('尊享订单')) {
            loggingHelper::writeLog('diandi_hub', 'OrderService/integralPay', '尊享订单不能使用余额支付');

            return  [
                'status' => 1,
                'msg' => '尊享订单不能使用余额支付',
            ];
        }

        loggingHelper::writeLog('diandi_hub', 'OrderService/integralPay', '订单获取', $orderInfo);

        if ($orderInfo['pay_status'] == OrderStatus::getValueByName('已付款')) {
            loggingHelper::writeLog('diandi_hub', 'OrderService/integralPay', '重复支付');

            return [
                'status' => 1,
                'msg' => '订单已付款',
            ];
        }
        $transaction = HubOrder::getDb()->beginTransaction();

        try {
            // 订单状态、微信支付订单号码更新修改
            HubOrder::updateAll([
                'order_status' => OrderStatus::getValueByName('已付款'),
                'pay_status' => 1,
                'pay_type' => PayTypeStatus::getValueByName('余额支付'),
                'pay_time' => time(),
            ], [
                'or',
                [
                    'order_no' => $orderInfo['order_no'],
                ],
                [
                    'parent_order_no' => $orderInfo['order_no'],
                ],
            ]);

            // 支付减库存处理
            $order_goods = HubOrderGoods::find()->where([
                'order_id' => $orderInfo['order_id'],
                'user_id' => $orderInfo['user_id'],
            ])->select(['goods_id', 'total_num', 'goods_name'])->all();

            $DdGoods = new HubGoodsBaseGoods();
            // 实时获取当前商品库存
            $goods_ids = array_keys(ArrayHelper::arrayKey($order_goods, 'goods_id'));

            loggingHelper::writeLog('diandi_hub', 'OrderService/integralPay', '所有商品id', $goods_ids);
            loggingHelper::writeLog('diandi_hub', 'OrderService/integralPay', '所有商品id', $order_goods);

            // 获取所有的商品库存
            $stocks = $DdGoods->find()
                ->where(['goods_id' => $goods_ids])
                ->select(['stock', 'goods_id'])
                ->indexBy('goods_id')
                ->asArray()
                ->all();

            loggingHelper::writeLog('diandi_hub', 'OrderService/integralPay', '所有商品库存', $stocks);

            if (!empty($order_goods)) {
                foreach ($order_goods as $item) {
                    // 'deduct_stock_type' => 20,//减库存的方式
                    // 'stock_up' => 0,//库存是否处理

                    if ($item['deduct_stock_type'] == 20 && $item['stock_up'] == 0) {
                        // 更新库存
                        // 实时库存
                        $stock = $stocks[$item['goods_id']]['stock'];
                        if ($item['total_num'] > $stock) {
                            loggingHelper::writeLog('diandi_hub', 'OrderService/integralPay', '库存不足', [
                                $item['goods_name'], $stock,
                            ]);

                            throw new \Exception($item['goods_name'].'库存不足');
                        }

                        $res = HubGoodsBaseGoods::updateAllCounters([
                            'stock' => -$item['total_num'],
                            'sales_initial' => +$item['total_num'],
                            'sales_actual' => +$item['total_num'],
                        ], ['goods_id' => $item['goods_id']]);

                        loggingHelper::writeLog('diandi_hub', 'OrderService/integralPay', '更新数据', [
                            'stock' => -$item['total_num'],
                            'sales_initial' => +$item['total_num'],
                            'sales_actual' => +$item['total_num'],
                        ]);
                    }
                }
            }

            if ($orderInfo['is_split'] == 1) {
                // 合并订单
                $orderAll = HubOrder::findAll(['parent_order_no' => $orderInfo['order_no']]);

                foreach ($orderAll as $key => $value) {
                    OrderAccount::addOrderAccount($value['user_id'], $value['order_id']);

                    loggingHelper::writeLog('diandi_hub', 'Notify', '分订单分销核算结束', [
                        'user_id' => $value['user_id'],
                        'order_id' => $value['order_id'],
                    ]);
                }
            } else {
                OrderAccount::addOrderAccount($orderInfo['user_id'], $orderInfo['order_id']);

                loggingHelper::writeLog('diandi_hub', 'Notify', '分销核算结束', [
                    'user_id' => $orderInfo['user_id'],
                    'order_id' => $orderInfo['order_id'],
                ]);
            }

            // 日志状态、微信支付订单号码更新修改

            loggingHelper::writeLog('diandi_hub', 'membergift', '购买礼包订单类型', $orderInfo['order_type']);
            loggingHelper::writeLog('diandi_hub', 'membergift', '礼包订单类型对应的数值', OrderTypeStatus::getValueByName('尊享订单'));

            // 余额支付写日志
            $goods_type = GoodsTypeStatus::getValueByName('其他商品');

            $account_type = AccountTypeStatus::getValueByName('余额');

            $change_type = AccountChangeStatus::getValueByName('余额消费');

            $order_type = $orderInfo['order_type'];

            $performance = 0;

            $order_goods_id = 0;

            $order_goods_id = 0;

            $order_goods_id = 0;

            $goods_id = 0;

            $goods_price = 0;

            $account_log_id = logAccount::addorderMoneyLog($orderInfo['user_id'], $order_id, -$orderInfo['pay_price'], $order_goods_id, $change_type, $account_type, $order_type, $goods_type, $orderInfo['total_price'], $goods_id, $goods_price, $performance);

            MemberService::updateAccountBymid($orderInfo['user_id'], 'credit1', -$orderInfo['pay_price'], $account_log_id, '余额支付订单');

            // 返回成功
            loggingHelper::writeLog('diandi_hub', 'membergift', '处理完毕');

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            loggingHelper::writeLog('diandi_hub', 'membergift', '错误信息1', $e);
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();

            loggingHelper::writeLog('diandi_hub', 'membergift', '错误信息2', $e);
            throw $e;
        }
    }

    // 订单详情
    public static function detail($id)
    {
        $DdOrder = new HubOrder();
        $detail = $DdOrder->find()
            ->with(['goods', 'address', 'express'])
            ->where(['order_id' => $id])
            ->asArray()->one();
        $region = DdRegion::find()->where(['id' => $detail['address']['region_id']])->select('merger_name')->one();
        $detail['address']['address_detail'] = $region['merger_name'];

        if (!empty($detail['goods'])) {
            $total_nums = array_column($detail['goods'], 'total_num');
            $detail['goods_total'] = array_sum($total_nums);
        } else {
            $detail['goods_total'] = 0;
        }

        $detail['pay_time'] = date('Y-m-d H:i:s', $detail['pay_time']);
        $detail['receipt_time'] = date('Y-m-d H:i:s', $detail['receipt_time']);
        $detail['delivery_time'] = date('Y-m-d H:i:s', $detail['delivery_time']);
        $detail['create_time'] = date('Y-m-d H:i:s', $detail['create_time']);

        $detail['status_label'] = OrderStatus::getLabel($detail['order_status']);

        $detail['pay_type_str'] = PayTypeStatus::getLabel($detail['pay_type']);

        return $detail;
    }

    // 订单详情
    public static function details($ids)
    {
        $DdOrder = new HubOrder();
        $details = $DdOrder->find()
            ->with(['goods', 'address', 'express'])
            ->where(['order_id' => $ids])
            ->asArray()->all();

        foreach ($details as $key => $value) {
            $region_ids[] = $value['address']['region_id'];
        }
        $regions = DdRegion::find()->where(['id' => $region_ids])->select(['id', 'merger_name'])
            ->indexBy('id')
            ->all();

        foreach ($details as $key => &$detail) {
            $region_id = $value['address']['region_id'];
            $region = $regions[$region_id];
            $detail['address']['address_detail'] = $region['merger_name'];

            $total_nums = array_column($detail['goods'], 'total_num');
            $detail['goods_total'] = array_sum($total_nums);

            $detail['pay_time'] = date('Y-m-d H:i:s', $detail['pay_time']);
            $detail['receipt_time'] = date('Y-m-d H:i:s', $detail['receipt_time']);
            $detail['create_time'] = date('Y-m-d H:i:s', $detail['create_time']);
        }

        return $details;
    }

    // 物流跟踪
    public function logistics()
    {
    }

    // 生成订单编号
    public static function CreateOrderno()
    {
        return date('Ymd').substr(implode('', array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }

    // 订单打印
    public static function cloudPrint($order_ids = [])
    {
        global $_GPC;
        $logPath = Yii::getAlias('@runtime/diandi_hub/print/log/'.date('Y/m/d').'/wechat.log');

        $list = self::details($order_ids);

        $info = Yii::$app->settings->getAllBySection('DiandiShopStroe');
        $info['logo'] = ImageHelper::tomedia($info['logo']);
        $info['banner'] = ImageHelper::tomedia($info['banner']);
        $wxappName = Yii::$app->settings->get('Wxapp', 'name');
        $wxappHeadimg = Yii::$app->settings->get('Wxapp', 'headimg');

        $Lodop_ip = Yii::$app->settings->get('DiandiShopStroe', 'Lodop_ip');

        $Feie = new Feie();
        $DdOrder = new HubOrder();
        foreach ($list as $key => $value) {
            $storeInfo = Yii::$app->service->commonGlobalsService->getStoreDetail($value['store_id']);
            $conf = Yii::$app->service->commonGlobalsService->getConf($value['bloc_id']);

            FileHelper::writeLog($logPath, '打印参数'.Json::encode($storeInfo).'/store_id:'.Yii::$app->params['store_id']);
            FileHelper::writeLog($logPath, '打印参数公司'.Json::encode($storeInfo).'/store_id:'.Yii::$app->params['bloc_id']);

            $codeUrl = $conf['wxapp']['codeUrl'];
            FileHelper::writeLog($logPath, 'codeUrl'.Json::encode($codeUrl));

            if (!empty($value['print_id'])) {
                continue;
            }
            $_DdOrder = clone $DdOrder;
            $order_id = $value['order_id'];
            $pay_status_str = $value['pay_status'] == 0 ? '未付款' : '已付款';
            $address = $value['address']['address_detail'].$value['address']['detail'];
            $mobile = $value['address']['phone'];
            $create_name = $value['address']['name'];
            $remark = $value['remark'] ? $value['remark'] : '无';
            $content[$order_id] = "<CB>{$wxappName}</CB><BR>";
            $create_time = $value['create_time'];
            $content[$order_id] .= '<C>空港食品&物流公司联合打造</C><BR>';

            $content[$order_id] .= '名称　　　　　 单价  数量 金额<BR>';

            $content[$order_id] .= '--------------------------------<BR>';
            foreach ($value['goods'] as $k => $goods) {
                $goods_name_str = mb_substr($goods['goods_name'], 0, 8, 'utf-8');
                $goods_name = str_pad($goods_name_str, 18, ' ', STR_PAD_RIGHT);
                $total_num = str_pad($goods['total_num'], 4, ' ', STR_PAD_RIGHT);
                $goods_price = str_pad($goods['goods_price'], 5, ' ', STR_PAD_RIGHT);
                $total_price = str_pad($goods['total_price'], 4, ' ', STR_PAD_RIGHT);
                $content[$order_id] .= "{$goods_name} {$goods_price} {$total_num}  {$total_price}<BR>";
            }
            $content[$order_id] .= '--------------------------------<BR>';
            $content[$order_id] .= '<C>付款信息</C><BR>';
            $content[$order_id] .= "是否付款：{$pay_status_str}<BR>";
            $content[$order_id] .= "合计：{$value['pay_price']}(含运费{$value['express_price']})元<BR>";

            $content[$order_id] .= '--------------------------------<BR>';
            $content[$order_id] .= '<C>送货信息</C><BR>';
            $content[$order_id] .= "订单备注：{$remark}<BR>";

            $content[$order_id] .= '--------------------------------<BR>';
            $content[$order_id] .= "送货地点：{$address}<BR>";
            $content[$order_id] .= "联 系 人：{$create_name}<BR>";
            $content[$order_id] .= "联系电话：{$mobile}<BR>";
            $content[$order_id] .= "下单时间：{$create_time}<BR>";
            $content[$order_id] .= "送达时间：{$value['address']['delivery_time']}<BR>";
            $content[$order_id] .= '--------------------------------<BR><BR>';

            $content[$order_id] .= "<QR>{$codeUrl}</QR>"; //把二维码字符串用标签套上即可自动生成二维码
            FileHelper::writeLog($logPath, '打印内容'.$content[$order_id]);

            $res[$order_id] = $Feie::printMsg($content[$order_id], $storeInfo['printNum']);
            FileHelper::writeLog($logPath, '打印结果'.$res[$order_id]);

            $Res[$order_id] = json_decode($res[$order_id], true);
            $_DdOrder->updateAll(['print_id' => $Res[$order_id]['data']], ['order_id' => $order_id]);
        }

        return $Res;
    }

    /**
     * 订单操作.
     *
     * @param [type] $order_id
     * @param [type] $ctype
     *
     * @return void
     */
    public static function confirmOrder($order_id, $ctype)
    {
        $massage = '操作成功';
        switch ($ctype) {
            case 'qxdd':
                // 取消订单
                $res = HubOrder::updateAll(['order_status' => OrderStatus::getValueByName('已取消')], ['order_id' => $order_id]);
                $massage = '取消成功';
                break;
            case 'qrfh':
                // 确认发货
                $res = HubOrder::updateAll([
                    'order_status' => OrderStatus::getValueByName('已发货'),
                    'delivery_status' => 1,
                    'delivery_time' => time(),
                ], ['order_id' => $order_id]);

                $orderInfo = HubOrder::find()->where(['order_id' => $order_id])->asArray()->one();

                $OrderCode = $orderInfo['order_no'];
                $ShipperCode = $orderInfo['express_company'];
                $LogisticCode = $orderInfo['express_no'];

                KdApiService::getOrderTracesByJson($OrderCode, $ShipperCode, $LogisticCode);
                $massage = '发货成功';
                break;
            case 'qrsh':
                // 确认收货
                $res = HubOrder::updateAll([
                    'order_status' => OrderStatus::getValueByName('已收货'),
                    'receipt_status' => 1,
                    'receipt_time' => time(),
                ], ['order_id' => $order_id]);

                loggingHelper::writeLog('diandi_hub', 'OrderAccount/thawMoney', '订单确认收货', [
                    'order_id' => $order_id,
                    'res' => $res,
                ]);

                if ($res) {
                    // 确认收货后资金解冻，补贴到账，店铺结算
                    OrderAccount::thawMoney($order_id);
                }
                $massage = '确认收货成功';
                break;
            case 'scdd':
                // 删除订单
                $DdOrder = new HubOrder();
                $DdOrderGoods = new HubOrderGoods();
                $DdOrderAddress = new HubOrderAddress();

                $DdOrder::deleteAll(['order_id' => $order_id]);
                $DdOrderGoods::deleteAll(['order_id' => $order_id]);
                $DdOrderAddress::deleteAll(['order_id' => $order_id]);
                $massage = '删除成功';

                break;
            case 'qrfk':
                // 确认付款
                $logPath = Yii::getAlias('@runtime/diandi_hub/order.log');
                $orders = HubOrder::findOne(['order_id' => $order_id]);
                OrderService::orderNotify($orders['order_no'], $orders['pay_price'], '', $logPath);
                $massage = '付款成功';
                break;
        }
        $orderinfo = self::detail($order_id);

        return  ResultHelper::json(200, $massage, $orderinfo);
    }

    // 订单列表
    public static function list($user_id, $order_status, $pageSize)
    {
        $page = Yii::$app->request->get('page');

        $where = []; //初始化条件数组
        $where['user_id'] = $user_id;
        $where['is_split'] = 0; //只读取分单，不读取合并订单

        if (is_numeric($order_status)) {
            $where['order_status'] = $order_status;
        }

        //  $bloc_id = Yii::$App->params['bloc_id'];
        //  $store_id = Yii::$App->params['store_id'];

        //  if ($bloc_id) {
        //      $where['bloc_id'] = $bloc_id;
        //      $condition['bloc_id'] = $bloc_id;
        //  }

        //  if ($store_id) {
        //      $where['store_id'] = $store_id;
        //      $condition['store_id'] = $store_id;
        //  }

        $andWhere = ['!=', 'order_status', OrderStatus::getValueByName('已取消')];

        // 创建一个 DB 查询来获得所有
        $query = HubOrder::find()->where($where)->andWhere($andWhere)->with([
            'goods', 'express', 'store',
        ])->orderBy('create_time desc');

        // 得到订单的总数（但是还没有从数据库取数据）
        $count = $query->count();
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $pageSize,
        ]);
        $list = $query->offset($pagination->offset)
            ->asArray()
            ->limit($pagination->limit)
            ->all();

        foreach ($list as &$item) {
            if (isset($item['store']['logo'])) {
                $item['store']['logo'] = \common\helpers\ImageHelper::tomedia($item['store']['logo']);
            }
            $item['create_time'] = date('m-d H:i:s', $item['create_time']);
            $item['status_label'] = OrderStatus::getLabel($item['order_status']);
        }

        return $list;
    }

    //  订单分销日志数据操作
    public static function CreateDisLog($order_id)
    {
        // 我的团队等级
        $my_level_num = 1;

        // 我的分销一级的团队等级
        $dis_level_num1 = 1;

        // 我的分销二级的团队等级
        $dis_level_num2 = 1;

        // 我的分销三级的团队等级
        $dis_level_num13 = 1;

        $member_id = 1;

        OrderAccount::orderInit($my_level_num, $dis_level_num1, $dis_level_num2, $dis_level_num13);
        OrderAccount::addOrderAccount($member_id, $order_id);
    }

    // 删除超过2个小时没有付款的订单
    public static function DeleteByTime()
    {
        $transaction = HubOrder::getDb()->beginTransaction();

        try {
            $Res = HubOrder::updateAll([
                'order_status' => OrderStatus::getValueByName('已取消'),
            ], [
                'and',
                ['<', 'create_time', time() - 60 * 60 * 2],
                ['pay_status' => PayStatus::NONPAYMENT],
            ]);

            $transaction->commit();
        } catch (\Exception $e) {
            loggingHelper::writeLog('diandi_hub', 'OrderService/DeleteByTime', 'Exception错误', $e);
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            loggingHelper::writeLog('diandi_hub', 'OrderService/DeleteByTime', 'Throwable错误', $e);

            $transaction->rollBack();
            throw $e;
        }
    }

    // 删除超过2个小时没有付款的订单
    public static function autoReceive()
    {
        $transaction = HubOrder::getDb()->beginTransaction();

        try {
            $Res = HubOrder::updateAll([
                'order_status' => OrderStatus::getValueByName('已收货'),
            ], [
                'and',
                ['<', 'delivery_time', time() - 60 * 60 * 24 * 7],
                ['delivery_status' => OrderStatus::getValueByName('已发货')],
            ]);

            $orders = HubOrder::find()->where([
                'and',
                ['<', 'delivery_time', time() - 60 * 60 * 24 * 7],
                ['delivery_status' => OrderStatus::getValueByName('已发货')],
            ])->asArray()->all();

            foreach ($orders as $key => $value) {
                $order_id = $value['order_id'];
                // 确认收货后资金解冻，补贴到账，店铺结算
                OrderAccount::thawMoney($order_id);
            }

            $transaction->commit();
        } catch (\Exception $e) {
            loggingHelper::writeLog('diandi_hub', 'OrderService/DeleteByTime', 'Exception错误', $e);
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            loggingHelper::writeLog('diandi_hub', 'OrderService/DeleteByTime', 'Throwable错误', $e);

            $transaction->rollBack();
            throw $e;
        }
    }
}
