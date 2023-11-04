<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-26 00:09:42
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-10 17:31:32
 */

namespace addons\diandi_integral;

use addons\diandi_integral\models\IntegralGoods;
use addons\diandi_integral\models\IntegralOrder;
use addons\diandi_integral\models\IntegralOrderGoods;
use addons\diandi_integral\models\enums\OrderStatus;
use addons\diandi_integral\services\OrderService;
use common\components\addons\AddonsModule;
use common\helpers\ArrayHelper;
use common\helpers\ErrorsHelper;
use common\helpers\FileHelper;
use common\helpers\loggingHelper;
use common\helpers\ResultHelper;
use common\models\DdCorePaylog;
use Yii;
use yii\db\Exception;
use yii\helpers\Json;
use yii\web\HttpException;

/**
 * diandi_dingzuo module definition class
 */
class api extends AddonsModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'addons\diandi_integral\api';

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
     * Undocumented function
     *
     * @param [type] $params
     * @return bool|string
     * @throws \Throwable
     * @throws Exception
     */
    public function Notify($params): bool|string
    {
        
        loggingHelper::writeLog('diandi_integral', 'Notify', '模块内回调',$params);
        loggingHelper::writeLog('diandi_integral', 'Notify', '模块内回调Store',strpos($params['out_trade_no'],'Store'));
        

    // 正常订单
        //支付金额校验
        $orderInfo = IntegralOrder::find()->where(['order_no' => $params['out_trade_no']])->asArray()->one();

        loggingHelper::writeLog('diandi_integral', 'Notify', '订单获取',$orderInfo);
        

        loggingHelper::writeLog('diandi_integral', 'Notify', '付款状态',$orderInfo['pay_status']);



        if ($orderInfo['pay_status'] == OrderStatus::getValueByName('已兑换')) {
            return ArrayHelper::toXml(['return_code' => 'SUCCESS', 'return_msg' => 'OK']);
        }
        
        $transaction = IntegralOrder::getDb()->beginTransaction();

        try {
    
            loggingHelper::writeLog('diandi_integral', 'Notify', '开始处理');

            // if ($orderInfo['pay_price'] * 100 != $params['total_fee']) {
            //     return false;
            // }
            // 订单状态、微信支付订单号码更新修改
            IntegralOrder::updateAll([
                'order_status' => OrderStatus::getValueByName('已兑换'),
                'pay_status' => 1,
                'pay_time' => time(),
                'transaction_id' => $params['transaction_id']
            ], ['order_no' => $params['out_trade_no']]);
            
            
            loggingHelper::writeLog('diandi_integral', 'Notify', '更新订单状态',[
                'order_status' => OrderStatus::getValueByName('已兑换'),
                'pay_status' => 1,
                'pay_time' => time(),
                'transaction_id' => $params['transaction_id']
            ], ['order_no' => $params['out_trade_no']]);


            $order_goods = IntegralOrderGoods::find()->where([
                'order_id' => $orderInfo['order_id'],
                'user_id' => $orderInfo['user_id'],
            ])->select(['goods_id', 'total_num', 'goods_name'])->all();

            loggingHelper::writeLog('diandi_integral', 'Notify', '订单商品',$order_goods);
            

            $DdGoods = new IntegralGoods();
            // 实时获取当前商品库存
            $goods_ids = array_keys(ArrayHelper::arrayKey($order_goods, 'goods_id'));
            
            loggingHelper::writeLog('diandi_integral', 'Notify', '商品ID',$goods_ids);

            

            // 获取所有的商品库存
            $stocks = $DdGoods->find()
                ->where(['goods_id' => $goods_ids])
                ->select(['stock', 'goods_id'])
                ->indexBy('goods_id')
                ->asArray()
                ->all();
            
            loggingHelper::writeLog('diandi_integral', 'Notify', '商品库存',$stocks);
            
            if (!empty($order_goods)) {
                foreach ($order_goods as $item) {
                    // 'deduct_stock_type' => 20,//减库存的方式
                    // 'stock_up' => 0,//库存是否处理

                    if($item['deduct_stock_type'] == 20 && $item['stock_up'] == 0 ){
                        // 更新库存
                        // 实时库存
                        $stock = $stocks[$item['goods_id']]['stock'];
                        
                        loggingHelper::writeLog('diandi_integral', 'Notify', '实时库存',$stock);
                        
                        if ($item['total_num'] > $stock) {
                            loggingHelper::writeLog('diandi_integral', 'Notify', '库存不足',$item['goods_name'] . '库存不足');
                            throw new \Exception($item['goods_name'] . '库存不足');
                        }
                        $res = IntegralGoods::updateAllCounters([
                            'stock' => -$item['total_num'],
                            'sales_initial'=>+$item['total_num'],
                            'sales_actual'=>+$item['total_num'],
                        ], ['goods_id' => $item['goods_id']]);

                        loggingHelper::writeLog('diandi_integral', 'Notify', '下单商品库存处理结果',$res);
                    }
                
                }
            }

            
            // 日志状态、微信支付订单号码更新修改
            DdCorePaylog::updateAll([
                'status' => 1,
                'tid' => $params['transaction_id']
            ], ['uniontid' => $params['out_trade_no']]);

            OrderService::exchangeCredit($orderInfo['order_id'],$orderInfo['total_price']);

                // 返回成功  
            loggingHelper::writeLog('diandi_integral', 'Notify', '处理结束');
            

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            loggingHelper::writeLog('diandi_integral', 'Exception错误信息1', ErrorsHelper::throwMsg($e));

            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            loggingHelper::writeLog('diandi_integral', 'Notify', 'Throwable错误信息2', ErrorsHelper::throwMsg($e));
            throw $e;
        }
        

        return ArrayHelper::toXml(['return_code' => 'SUCCESS', 'return_msg' => 'OK']);
    }
}
