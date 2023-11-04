<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-17 09:17:03
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-07-02 15:24:50
 */

namespace addons\diandi_tea\services;

use addons\diandi_tea\models\marketing\TeaCoupon;
use addons\diandi_tea\models\marketing\TeaMemberCoupon;
use addons\diandi_tea\models\order\TeaCouponBuyList;
use addons\diandi_tea\models\order\TeaMeituan;
use common\helpers\ErrorsHelper;
use common\helpers\loggingHelper;
use common\helpers\ResultHelper;
use common\models\DdMemberAccount;
use common\services\BaseService;
use Yii;

class TuanService extends BaseService
{
    public static function addTuan($meituan_code, $coupon_id, $hourse_id): array
    {
        $TeaMeituan = new TeaMeituan();
        $detail = $TeaMeituan->find()->where(['meituan_code' => $meituan_code])->asArray()->one();
        if (!empty($detail)) {
            return ResultHelper::serverJson(1, '美团卡券号码重复');


        }
        $TeaMeituan->updateAll([
            'status' => 0,
            'meituan_code' => $meituan_code,
            'coupon_id' => $coupon_id,
            'hourse_id' => $hourse_id,
        ], [
            'meituan_code' => $meituan_code,
        ]);

        //  重新读取
        $detail = $TeaMeituan->find()->where(['meituan_code' => $meituan_code])->asArray()->one();


        $TeaMeituan->load([
           'status' => 0,
           'meituan_code' => $meituan_code,
           'coupon_id' => $coupon_id,
           'hourse_id' => $hourse_id,
        ], '') && $TeaMeituan->save();

        $msg = ErrorsHelper::getModelError($TeaMeituan);
        if (!empty($msg)) {
            return ResultHelper::serverJson(1, $msg);
        }

        return ResultHelper::serverJson(0, '获取成功', $TeaMeituan);
    }

    // 免费领取卡券
    public static function giveCoupon($id): array
    {
        $member_id = Yii::$app->user->identity->member_id??0;

        // 第一步校验是否扫码重复
        $TeaMeituan = TeaMeituan::find()->where(['id' => $id])->asArray()->one();
        $coupon_id = $TeaMeituan['coupon_id'];
        if (empty($TeaMeituan)) {
            return ResultHelper::json(400, '请在美团购买后领取');
        }

        if (!empty($TeaMeituan['status'])) {
            return ResultHelper::json(400, '重复扫码无效');
        }

        // 更新用户ID

        // 创建卡券免费购买记录
        $data = TeaCoupon::find()->where(['id' => $coupon_id])->asArray()->one();

        if ($coupon_id && $data['price'] && $data['name'] && $data['type']) {
            $price = $data['price'];
            $coupon_name = $data['name'];
            $coupon_type = $data['type'];
        } else {
            return ResultHelper::json(400, '缺少参数');
        }

        $member_coupon_model = TeaMemberCoupon::find()->where(['member_id' => $member_id, 'coupon_id' => $coupon_id])->asArray()->one();
        if ($member_coupon_model) {
            $max_num = TeaCoupon::find()->where(['id' => $coupon_id])->select('max_num')->scalar();
            if (($member_coupon_model['surplus_num'] + $member_coupon_model['use_num'] + 1) > $max_num) {
                return ResultHelper::json(400, '购买该卡券已达上限');
            }
        }

        $orderInfo = OrderService::createBuyCouponOrder($member_id, $coupon_id, $coupon_name, $price, $coupon_type);

        $order_number = $orderInfo['order_number'];
        // 创建支付
        //卡券购买余额支付
        loggingHelper::writeLog('diandi_tea', 'giveCoupon', '卡券余额购买', 'K');

        // 卡券购买订单 K2020121499549755 测试用户专用，正式使用下面的
        $orderInfo = TeaCouponBuyList::find()->where(['order_number' => $order_number])->asArray()->one();
        //  $orderInfo = TeaCouponBuyList::find()->where(['order_number' => $order_number, 'price' => $price])->asArray()->one();
        if (empty($orderInfo['id'])) {
            return ResultHelper::json(401, '订单不存在');
        }

        loggingHelper::writeLog('diandi_tea', 'giveCoupon', '卡券购买详情sql', TeaCouponBuyList::find()->where(['order_number' => $order_number])->createCommand()->getRawSql());
        loggingHelper::writeLog('diandi_tea', 'giveCoupon', '卡券购买详情', $orderInfo);

        if ($orderInfo['status'] != 1) {
            return ResultHelper::json(401, '订单已支付');
        }

        //$transaction = DistributionAccountStorePay::getDb()->beginTransaction();
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $balance = DdMemberAccount::find()->where(['member_id' => $member_id])->select('user_money')->asArray()->one()['user_money'];

            //更新卡券购买订单状态
            $Res = TeaCouponBuyList::updateAll([
                 'status' => 2,
                 'pay_type' => 3,
                 'balance' => $balance,
                 'pay_time' => date('Y-m-d H:i:s'),
             ], ['id' => $orderInfo['id']]);
            loggingHelper::writeLog('diandi_tea', 'giveCoupon', '卡券购买处理', $Res);

            //增加已发售卡券数量
            TeaCoupon::updateAllCounters(['all_num' => 1], ['id' => $orderInfo['coupon_id']]);
            //增加用户卡券数量
            $is_have_id = TeaMemberCoupon::find()->select('id')
             ->where(['member_id' => $orderInfo['member_id'], 'coupon_id' => $orderInfo['coupon_id']])
             ->scalar();
            if ($is_have_id) {
                //增加剩余使用次数
                loggingHelper::writeLog('diandi_tea', 'giveCoupon', '增加用户卡券可用次数', $is_have_id);
                TeaMemberCoupon::updateAllCounters(['surplus_num' => 1], ['id' => $is_have_id]);
            } else {
                //创建用户卡券
                $data['member_id'] = $orderInfo['member_id'];
                $data['coupon_name'] = $orderInfo['coupon_name']; //卡券名称
                 $data['coupon_id'] = $orderInfo['coupon_id']; //卡券id
                 $data['coupon_type'] = $orderInfo['coupon_type']; //卡券类型
                 $data['surplus_num'] = 1; //剩余数量
                 $data['receive_type'] = 2; //卡券获取方式： 1.领取 2.购买
                 $MemberCouponModel = new TeaMemberCoupon();
                loggingHelper::writeLog('diandi_tea', 'giveCoupon', '创建用户卡券', $data);
                $MemberCouponModel->load($data, '');
                $MemberCouponModel->save();
            }

            //  更新卡券增加记录
            TeaMeituan::updateAll(['status' => 1, 'member_id' => $member_id, 'order_id' => $orderInfo['id']], ['coupon_id' => $coupon_id, 'id' => $id]);
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            loggingHelper::writeLog('diandi_tea', 'giveCoupon', '包间续费订单处理,错误信息Exception', $e);
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        } catch (\Throwable $e) {
            $transaction->rollBack();
            loggingHelper::writeLog('diandi_tea', 'giveCoupon', '包间续费订单处理,错误信息Throwable', $e);
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        }

        return ResultHelper::json(200, '卡券领取成功');
    }
}
