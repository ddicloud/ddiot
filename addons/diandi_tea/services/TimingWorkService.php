<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-24 11:27:38
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-09 17:37:59
 */

namespace addons\diandi_tea\services;

use addons\diandi_tea\models\marketing\TeaMemberCoupon;
use addons\diandi_tea\models\order\TeaOrderList;
use common\helpers\loggingHelper;
use common\helpers\ResultHelper;
use common\services\BaseService;

class TimingWorkService extends BaseService
{
    public static function cancelOrder(): array
    {
        $time = time() - 300;
        $date = date('Y-m-d H:i:s', $time);
        $where = ['<', 'create_time', $date];
        $ids = TeaOrderList::find()->select('id')->where(['status' => 1])->andWhere($where)->asArray()->all();

        if (!empty($ids)) {
            foreach ($ids as $k) {
                if ($k['coupon_id']) {
                    $id = TeaMemberCoupon::find()->select(['id'])->where(['member_id' => $k['member_id'], 'coupon_id' => $k['coupon_id']])->asArray()->one();
                    TeaMemberCoupon::updateAllCounters(['surplus_num' => 1, 'use_num' => -1], 'id='.$id['id']);
                    loggingHelper::writeLog('diandi_tea', 'cancelOrder', '过期订单卡券返还', $id['id']);
                }

                TeaOrderList::updateAll([
                    'status' => 4,
                ], ['id' => $k['id']]);
                loggingHelper::writeLog('diandi_tea', 'cancelOrder', '过期订单取消', $k['id']);
            }

            return ResultHelper::json(200, '过期取消订单', $ids);
        } else {
            loggingHelper::writeLog('diandi_tea', 'cancelOrder', '无过期订单');

            return ResultHelper::json(200, '无过期取消订单');
        }
    }

    //完成订单
    public static function finishOrder(): array
    {
        $count_id = TeaOrderList::find()->select(['id', 'end_time'])->where(['status' => 2, 'order_type' => 1])->asArray()->all();
        if (count($count_id) < 1) {
            return ResultHelper::json(200, '无完成订单');
        }
        $finish_id = [];
        foreach ($count_id as $val) {
            //查询子订单
            $order_son = TeaOrderList::find()->select(['id', 'end_time'])->where(['renew_order_id' => $val['id'], 'status' => 2])->orderBy('create_time DESC')->asArray()->one();

            if (!empty($order_son['id'])) {
                //存在续费订单
                if (strtotime($order_son['end_time']) <= time()) {
                    $finish_id[] = $order_son['id'];
                    //$finish_id[] = $order_son['id'];
                    //订单完成修改订单状态
                    TeaOrderList::updateAll([
                        'status' => 3,
                    ], ['id' => $val['id']]);
                    TeaOrderList::updateAll([
                        'status' => 3,
                    ], ['renew_order_id' => $val['id']]);

                    loggingHelper::writeLog('diandi_tea', 'finishOrder', '续费完成订单', $val);
                }
            } else {
                //没有续费订单
                if (strtotime($val['end_time']) <= time()) {
                    $finish_id[] = $val['id'];
                    //订单完成修改订单状态
                    TeaOrderList::updateAll([
                        'status' => 3,
                    ], ['id' => $val['id']]);
                    loggingHelper::writeLog('diandi_tea', 'finishOrder', '完成订单', $val);
                }
            }
        }

        return ResultHelper::json(200, '完成订单', $finish_id);
    }
}
