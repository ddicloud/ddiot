<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-07-12 13:02:30
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-22 15:09:37
 */

namespace common\plugins\diandi_hub;

use common\plugins\diandi_hub\models\enums\OrderStatus;
use common\plugins\diandi_hub\models\enums\OrderTypeStatus;
use common\plugins\diandi_hub\models\enums\PayTypeStatus;
use common\plugins\diandi_hub\models\enums\StorePayStatus;
use common\plugins\diandi_hub\models\goods\HubGoodsBaseGoods;
use common\plugins\diandi_hub\models\order\HubOrder;
use common\plugins\diandi_hub\models\order\HubOrderGoods;
use common\plugins\diandi_hub\models\store\HubAccountStorePay;
use common\plugins\diandi_hub\services\account\OrderAccount;
use common\plugins\diandi_hub\services\AftersaleService;
use common\plugins\diandi_hub\services\GiftService;
use common\plugins\diandi_hub\services\OrderService;
use common\components\addons\AddonsModule;
use common\helpers\ArrayHelper;
use common\helpers\ErrorsHelper;
use common\helpers\FileHelper;
use common\helpers\loggingHelper;
use common\helpers\StringHelper;
use common\models\DdCorePaylog;
use common\models\PayRefundLog;
use Yii;
use yii\helpers\Json;

/**
 * diandi_dingzuo module definition class.
 */
class api extends AddonsModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = "common\plugins\diandi_hub\api";

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();
    }

    // 支付回调
    // {
    //     "appid": "wx028eb56f4b4a7d99",
    //     "bank_type": "OTHERS",
    //     "cash_fee": "5",
    //     "fee_type": "CNY",
    //     "is_subscribe": "N",
    //     "mch_id": "1228641802",
    //     "nonce_str": "5e6be567474bb",
    //     "openid": "oE5EC0aqNTAdAXpPfikBpkHiSG1o",
    //     "out_trade_no": "2020031455505497",
    //     "result_code": "SUCCESS",
    //     "return_code": "SUCCESS",
    //     "sign": "99C78A7B9A9110E9A4EA4D5040596700",
    //     "time_end": "20200314035649",
    //     "total_fee": "5",
    //     "trade_type": "JSAPI",
    //     "transaction_id": "4200000518202003141950666245"
    // }

    /**
     * Undocumented function.
     *
     * @param [type] $params
     *
     * @return void
     */
    public function Notify($params)
    {
        $logPath = Yii::getAlias('@runtime/diandi_hub/paynotify/'.date('Y/md').'.log');

        loggingHelper::writeLog('diandi_hub', 'Notify', '模块内回调', $params);
        loggingHelper::writeLog('diandi_hub', 'Notify', '模块内回调Store', strpos($params['out_trade_no'], 'Store'));

        $GorderType = StringHelper::msubstr($params['out_trade_no'], 0, 1);
        loggingHelper::writeLog('diandi_hub', 'Notify', '订单类型', $GorderType);

        if ($GorderType == 'S') {
            loggingHelper::writeLog('diandi_hub', 'Notify', '到店订单开始回调', $GorderType);

            // 到店支付订单 Store2020121499549755
            $orderInfo = HubAccountStorePay::find()->where(['order_no' => $params['out_trade_no']])->asArray()->one();

            loggingHelper::writeLog('diandi_hub', 'Notify', '到店订单详情sql', HubAccountStorePay::find()->where(['order_no' => $params['out_trade_no']])->createCommand()->getRawSql());
            loggingHelper::writeLog('diandi_hub', 'Notify', '到店订单详情', $orderInfo);

            if ($orderInfo['status'] >= StorePayStatus::getValueByName('支付')) {
                return ArrayHelper::toXml(['return_code' => 'SUCCESS', 'return_msg' => 'OK']);
            }

            $transaction = HubAccountStorePay::getDb()->beginTransaction();

            try {
                loggingHelper::writeLog('diandi_hub', 'Notify', '到店订单处理', [
                    'status' => StorePayStatus::getValueByName('支付'),
                    'pay_time' => time(),
                    'transaction_id' => $params['transaction_id'],
                ]);

                $Res = HubAccountStorePay::updateAll([
                    'status' => StorePayStatus::getValueByName('支付'),
                    'pay_time' => time(),
                    'pay_type' => PayTypeStatus::getValueByName('微信支付'),
                    'transaction_id' => $params['transaction_id'],
                ], ['order_no' => $params['out_trade_no']]);

                loggingHelper::writeLog('diandi_hub', 'Notify', '到店订单处理', $Res);

                loggingHelper::writeLog('diandi_hub', 'Notify', '到店订单处理分销处理开始', $Res);

                OrderAccount::addOrderAccount($orderInfo['member_id'], $orderInfo['id'], 1);

                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                loggingHelper::writeLog('diandi_hub', 'Notify', '到店订单处理,错误信息Exception', $e);
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                loggingHelper::writeLog('diandi_hub', 'Notify', '到店订单处理,错误信息Throwable', $e);

                throw $e;
            }

            return ArrayHelper::toXml(['return_code' => 'SUCCESS', 'return_msg' => 'OK']);
        } else {
            // 正常订单
            //支付金额校验
            $orderInfo = HubOrder::find()->where(['order_no' => $params['out_trade_no']])->asArray()->one();

            loggingHelper::writeLog('diandi_hub', 'Notify', '订单获取', [
                    'orderInfo' => $orderInfo,
                    'order_no' => $params['out_trade_no'],
                    'pay_status' => $orderInfo['pay_status'],
                ]);

            if ($orderInfo['pay_status'] == OrderStatus::getValueByName('已付款')) {
                return ArrayHelper::toXml(['return_code' => 'SUCCESS', 'return_msg' => 'OK']);
            }
            $transaction = HubOrder::getDb()->beginTransaction();

            try {
                loggingHelper::writeLog('diandi_hub', 'Notify', '模块内回调1');

                // if ($orderInfo['pay_price'] * 100 != $params['total_fee']) {
                //     return false;
                // }
                // 订单状态、微信支付订单号码更新修改
                $Res = HubOrder::updateAll([
                        'order_status' => OrderStatus::getValueByName('已付款'),
                        'pay_status' => 1,
                        'pay_type' => PayTypeStatus::getValueByName('微信支付'),
                        'pay_time' => time(),
                        'transaction_id' => $params['transaction_id'],
                    ], [
                        'or',
                        [
                            'order_no' => $params['out_trade_no'],
                        ],
                        [
                            'parent_order_no' => $params['out_trade_no'],
                        ],
                    ]);

                loggingHelper::writeLog('diandi_hub', 'Notify', '订单支付状态更新结果', $Res);

                // 支付减库存处理
                $order_goods = HubOrderGoods::find()->where([
                        'order_id' => $orderInfo['order_id'],
                        'user_id' => $orderInfo['user_id'],
                    ])->select(['goods_id', 'total_num', 'goods_name'])->all();

                loggingHelper::writeLog('diandi_hub', 'Notify', '支付减库存处理', $order_goods);

                $DdGoods = new HubGoodsBaseGoods();
                // 实时获取当前商品库存
                $goods_ids = array_keys(ArrayHelper::arrayKey($order_goods, 'goods_id'));
                loggingHelper::writeLog('diandi_hub', 'Notify', '所有商品ID', $goods_ids);

                // 获取所有的商品库存
                $stocks = $DdGoods->find()
                        ->where(['goods_id' => $goods_ids])
                        ->select(['stock', 'goods_id'])
                        ->indexBy('goods_id')
                        ->asArray()
                        ->all();
                loggingHelper::writeLog('diandi_hub', 'Notify', '所有商品库存', $stocks);
                if (!empty($order_goods)) {
                    foreach ($order_goods as $item) {
                        // 'deduct_stock_type' => 20,//减库存的方式
                        // 'stock_up' => 0,//库存是否处理

                        if ($item['deduct_stock_type'] == 20 && $item['stock_up'] == 0) {
                            // 更新库存
                            // 实时库存
                            $stock = $stocks[$item['goods_id']]['stock'];

                            loggingHelper::writeLog('diandi_hub', 'Notify', '商品实时库存', [
                                    'goods_id' => $item['goods_id'],
                                    'stock' => $stock,
                                ]);

                            if ($item['total_num'] > $stock) {
                                loggingHelper::writeLog('diandi_hub', 'Notify', '库存不足', [
                                        'goods_id' => $item['goods_id'],
                                        'goods_name' => $item['goods_name'],
                                        'stock' => $stock,
                                    ]);

                                throw new \Exception($item['goods_name'].'库存不足');
                            }
                            $res = HubGoodsBaseGoods::updateAllCounters([
                                    'stock' => -$item['total_num'],
                                    'sales_initial' => +$item['total_num'],
                                    'sales_actual' => +$item['total_num'],
                                ], ['goods_id' => $item['goods_id']]);

                            loggingHelper::writeLog('diandi_hub', 'Notify', '下单商品库存处理结果', [
                                    'res' => $res,
                                    'stock' => -$item['total_num'],
                                    'goods_id' => $item['goods_id'],
                                ]);
                        }
                    }
                }

                // 分销核算开始
                loggingHelper::writeLog('diandi_hub', 'Notify', '分销核算开始', [
                        'user_id' => $orderInfo['user_id'],
                        'order_id' => $orderInfo['order_id'],
                    ]);

                if ($orderInfo['is_split'] == 1) {
                    // 合并订单
                    $orderAll = HubOrder::findAll(['parent_order_no' => $params['out_trade_no']]);

                    foreach ($orderAll as $key => $value) {
                        OrderAccount::addOrderAccount($value['user_id'], $value['order_id']);

                        loggingHelper::writeLog('diandi_hub', 'Notify', '分订单分销核算结束', [
                                'user_id' => $value['user_id'],
                                'order_id' => $value['order_id'],
                            ]);

                        loggingHelper::writeLog('diandi_hub', 'Notify', '库存处理完成，订单类型：', [
                                'order_type' => $value['order_type'],
                            ]);

                        // 日志状态、微信支付订单号码更新修改
                        DdCorePaylog::updateAll([
                                'status' => 1,
                                'tid' => $params['transaction_id'],
                            ], ['uniontid' => $value['order_no']]);
                    }
                } else {
                    OrderAccount::addOrderAccount($orderInfo['user_id'], $orderInfo['order_id']);

                    loggingHelper::writeLog('diandi_hub', 'Notify', '分销核算结束', [
                            'user_id' => $orderInfo['user_id'],
                            'order_id' => $orderInfo['order_id'],
                        ]);

                    loggingHelper::writeLog('diandi_hub', 'Notify', '库存处理完成，订单类型：', [
                            'order_type' => $orderInfo['order_type'],
                        ]);

                    // 日志状态、微信支付订单号码更新修改
                    DdCorePaylog::updateAll([
                            'status' => 1,
                            'tid' => $params['transaction_id'],
                        ], ['uniontid' => $params['out_trade_no']]);
                }

                loggingHelper::writeLog('diandi_hub', 'membergift', '购买礼包订单类型', $orderInfo['order_type']);
                loggingHelper::writeLog('diandi_hub', 'membergift', '礼包订单类型对应的数值', OrderTypeStatus::getValueByName('尊享订单'));
                if ($orderInfo['order_type'] == OrderTypeStatus::getValueByName('尊享订单')) {
                    loggingHelper::writeLog('diandi_hub', 'membergift', '礼包的商品id', $order_goods[0]['goods_id']);

                    loggingHelper::writeLog('diandi_hub', 'membergift', '下单人id', $orderInfo['user_id']);

                    // 礼包权益更新
                    GiftService::UpdateUserLevelByGoods($order_goods[0]['goods_id'], $orderInfo['user_id']);
                }

                // $printRes =  OrderService::cloudPrint([$orderInfo['order_id']]);

                // 返回成功

                // FileHelper::writeLog($logPath, '打印日志查看' . Json::encode($printRes));

                $transaction->commit();

                return true;
            } catch (\Exception $e) {
                $transaction->rollBack();

                loggingHelper::writeLog('diandi_hub', 'Notify', '错误信息1', ErrorsHelper::throwMsg($e));

                // throw $e;
                return false;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                loggingHelper::writeLog('diandi_hub', 'Notify', '错误信息2', ErrorsHelper::throwMsg($e));
                // throw $e;
                return false;
            }

            // return ArrayHelper::toXml(['return_code' => 'SUCCESS', 'return_msg' => 'OK']);
            return false;
        }

        return ArrayHelper::toXml(['return_code' => 'SUCCESS', 'return_msg' => 'OK']);
    }

    public function Refundednotify($reqInfo)
    {
        loggingHelper::writeLog('diandi_hub', 'api/Refundednotify', '退款通知开始', $reqInfo);

        $transaction = PayRefundLog::getDb()->beginTransaction();

        try {
            AftersaleService::rundAccountOrder($reqInfo['out_refund_no']);

            $transaction->commit();

            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            loggingHelper::writeLog('diandi_hub', 'api/Refundednotify', '错误信息1Exception', ErrorsHelper::throwMsg($e));
            // throw $e;
            return false;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            loggingHelper::writeLog('diandi_hub', 'api/Refundednotify', '错误信息2Throwable', ErrorsHelper::throwMsg($e));
            // throw $e;
            return false;
        }

        // return ArrayHelper::toXml(['return_code' => 'SUCCESS', 'return_msg' => 'OK']);

        return false;
    }
}
