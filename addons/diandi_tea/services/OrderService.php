<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-25 09:06:47
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-07-02 15:51:25
 */

namespace addons\diandi_tea\services;

use addons\diandi_tea\models\config\TeaHourse;
use addons\diandi_tea\models\enums\CouponType;
use addons\diandi_tea\models\enums\HoursesStatus;
use addons\diandi_tea\models\enums\OrderStatus;
use addons\diandi_tea\models\enums\SetMealType;
use addons\diandi_tea\models\marketing\TeaCoupon;
use addons\diandi_tea\models\marketing\TeaMemberCoupon;
use addons\diandi_tea\models\marketing\TeaSetMeal;
use addons\diandi_tea\models\order\TeaCouponBuyList;
use addons\diandi_tea\models\order\TeaInvoice;
use addons\diandi_tea\models\order\TeaOrderList;
use addons\diandi_tea\models\order\TeaRechargeList;
use addons\diandi_tea\services\jobs\Orderobs;
use api\modules\wechat\models\DdWxappFans;
use common\helpers\DateHelper;
use common\helpers\ErrorsHelper;
use common\helpers\ImageHelper;
use common\helpers\loggingHelper;
use common\helpers\ResultHelper;
use common\models\AccountLog;
use common\models\DdCorePaylog;
use common\models\DdMember;
use common\models\DdMemberAccount;
use common\services\BaseService;
use Yii;
use yii\db\Exception;

class OrderService extends BaseService
{
    //房间套餐列表
    public static function setMealList($hourse_id): array
    {
        $set_meal_ids = TeaHourse::find()->select(['set_meal_ids'])->where(['id' => $hourse_id])->asArray()->one();
        $set_meal_ids = explode(',', $set_meal_ids['set_meal_ids']);
        $list = TeaSetMeal::find()
            ->where(['id' => $set_meal_ids])
            ->asArray()
            ->all();
        $SetMealType = SetMealType::listData();
        foreach ($list as $key => &$value) {
            $value['type_str'] = $SetMealType[$value['type']];
            $value['use_start'] = date('H:i', strtotime($value['use_start']));
            $value['use_end'] = date('H:i', strtotime($value['use_end']));
            $value['enable_start'] = date('Y-m-d H:i', strtotime($value['enable_start']));
            $value['enable_end'] = date('Y-m-d H:i', strtotime($value['enable_end']));
        }

        return $list;
    }

    //房间详情
    public static function hourseInfo($hourse_id, $store_id, $bloc_id)
    {
        $teaHouse = TeaHourse::find()->where(['id' => $hourse_id, 'store_id' => $store_id, 'bloc_id' => $bloc_id])->asArray()->one();
        if (!empty($teaHouse['slide'])) {
            $teaHouse['slide'] = json_decode($teaHouse['slide'], true);

            if (is_array($teaHouse['slide'])) {
                foreach ($teaHouse['slide'] as $key => &$value) {
                    $value = ImageHelper::tomedia($value);
                }
            }
        }
        //详情
//        $HoursesStatus = HoursesStatus::listData();
        $time = date('Y-m-d H:i:s');
        $where_time = [
            'and',
            ['<', 'start_time', $time],
            ['>', 'end_time', $time],
        ];
        $is_use = TeaOrderList::find()->where(['hourse_id' => $hourse_id, 'status' => 2])->andWhere($where_time)->one();

        if ($is_use || $teaHouse['status'] != 1) {
            $teaHouse['status_num'] = 1;
            $teaHouse['status'] = '使用中';
        } else {
            $teaHouse['status_num'] = 0;
            $teaHouse['status'] = '空闲中';
        }
        //$teaHourse['status'] = $HoursesStatus[$teaHourse['status']];
        $teaHouse['picture'] = ImageHelper::tomedia($teaHouse['thumb']);

        //包间套餐
        $list = [];
        if (!empty($teaHouse['set_meal_ids'])) {
            $set_meal_ids = explode(',', $teaHouse['set_meal_ids']);
            $list = TeaSetMeal::find()
                ->where(['id' => $set_meal_ids])
                ->asArray()
                ->all();

            $SetMealType = SetMealType::listData();
            foreach ($list as &$value) {
                $value['type_str'] = $SetMealType[$value['type']];
//                $value['use_start'] = date('H:i', strtotime($value['use_start']));
//                $value['use_end'] = date('H:i', strtotime($value['use_end']));
//                $value['enable_start'] = date('Y-m-d H:i', strtotime($value['enable_start']));
//                $value['enable_end'] = date('Y-m-d H:i', strtotime($value['enable_end']));
            }
        }

        //不可选时间
        $now_hour = date('H');
        $now_minute = date('i');
        $start_m = $now_minute - $now_minute % 5 + 5;

        //从现在开始的全天五分钟间隔时间段
        $minn = self::fiveMin($now_hour, $start_m);
        //全天五分钟间隔时间段
        $minn_nomal = self::fiveMin();

        $weekArray = ['周日', '周一', '周二', '周三', '周四', '周五', '周六']; //先定义一个数组

        for ($i = 0; $i < 6; ++$i) {
            $data[$i]['day'] = date('m-d', strtotime("+$i day"));
            $data[$i]['week'] = $weekArray[date('w', strtotime("+$i day"))];
            $data[$i]['start'] = date('Y-m-d 00:00:00', strtotime("+$i day"));
            $add = $i + 2;
            $data[$i]['end'] = date('Y-m-d 00:00:00', strtotime("+$add day"));
        }

        //计算近六天的不可选时间
        foreach ($data as $ke => &$va) {
            if ($ke == 0) {
                $type = 1;
            } else {
                $type = 2;
            }
            $va['disable'] = self::disableTime($va, $hourse_id, $minn, $minn_nomal, $type);
        }

        return [
            'setMeal' => $list,
            'teaHourse' => $teaHouse,
            'disable' => $data,
        ];
    }

    //取消订单
    public static function cancelOrder($order_id)
    {
        $order_model = TeaOrderList::find()->where(['id' => $order_id])->asArray()->one();
        $status = $order_model['status'];

        if ((int)$status === OrderStatus::status1) {
            if ($order_model['coupon_id']) {
                $id = TeaMemberCoupon::find()->select(['id'])->where(['member_id' => $order_model['member_id'], 'coupon_id' => $order_model['coupon_id']])->scalar();
                TeaMemberCoupon::updateAllCounters(['surplus_num' => 1, 'use_num' => -1], 'id=' . $id);
                loggingHelper::writeLog('diandi_tea', 'cancelOrder', '过期订单卡券返还', $id);
            }

            TeaOrderList::updateAll([
                'status' => 4,
            ], ['id' => $order_id]);
        }
    }

    //所有卡券列表
    public static function couponList($type = '')
   {

        if ($type) {
            $where['type'] = $type;
        }
        $date = date('Y-m-d H:i:s');
        $list = TeaCoupon::find()
            ->where($where)
            ->andWhere(['<', 'enable_start', $date])
            ->andWhere(['>', 'enable_end', $date])
            ->asArray()
            ->all();
        $CouponType = CouponType::listData();

        $member_id = Yii::$app->user->identity->member_id ?? 0;

        foreach ($list as $key => &$value) {
            $member_coupon = TeaMemberCoupon::find()
                ->where(['member_id' => $member_id, 'coupon_id' => $value['id']])
                ->select(['use_num', 'surplus_num'])
                ->asArray()->one();
            if ($member_coupon) {
                //如果已使用数量+剩余数量等于卡券最大购买数则不显示购买
                if (($member_coupon['use_num'] + $member_coupon['surplus_num']) >= $value['max_num']) {
                    unset($list[$key]);
                    continue;
                }
            }
            $value['type_str'] = $CouponType[$value['type']];
            $value['use_start'] = date('H:i', strtotime($value['use_start']));
            $value['use_end'] = date('H:i', strtotime($value['use_end']));
            $value['enable_start'] = date('Y-m-d H:i', strtotime($value['enable_start']));
            $value['enable_end'] = date('Y-m-d H:i', strtotime($value['enable_end']));
            $value['background'] = ImageHelper::tomedia($value['background']);
            $value['experience_time'] = round((strtotime($value['use_end']) - strtotime($value['use_start'])) / 3600, 1);
        }

        return $list;
    }

    //我的卡券列表
    public static function myCoupon($type, $member_id): array
    {
        if ($type) {
            $where['type'] = $type;
        }
        $where['member_id'] = $member_id;
        $andwhere = ['>', 'surplus_num', 0];
        $list = TeaMemberCoupon::find()
            ->with('coupon')
            ->where($where)
            ->andWhere($andwhere)
            ->asArray()
            ->all();
        $CouponType = CouponType::listData();
        foreach ($list as $key => &$value) {
            $value['type_str'] = $CouponType[$value['coupon_type']];
            //$value['type'] = $value['coupon_type'];
            $value['cash'] = $value['coupon']['cash'];
            $value['discount'] = $value['coupon']['discount'];
            $value['use_start'] = date('H:i', strtotime($value['coupon']['use_start']));
            $value['use_end'] = date('H:i', strtotime($value['coupon']['use_end']));
            $value['enable_start'] = date('Y-m-d', strtotime($value['coupon']['enable_start']));
            $value['enable_end'] = date('Y-m-d', strtotime($value['coupon']['enable_end']));
            $value['max_time'] = $value['coupon']['max_time'];
            $value['background'] = ImageHelper::tomedia(TeaCoupon::findOne($value['coupon_id'])->background);
        }

        return $list;
    }

    //房间选择优惠券列表
    public static function chooseCoupon($hourse_id, $member_id)
    {
        $where['a.member_id'] = $member_id;
        $andwhere = ['>', 'a.surplus_num', 0];
        $time = date('H:i:s');
        $list = TeaMemberCoupon::find()
            ->alias('a')
            ->join('INNER JOIN', 'dd_diandi_tea_coupon b', 'a.coupon_id = b.id')
            ->select(['a.*', 'b.cash', 'b.cash', 'b.discount', 'b.max_time', 'b.enable_start', 'b.enable_end'])
            ->where($where)
            ->andWhere($andwhere)
            ->andWhere("FIND_IN_SET($hourse_id,b.use_hourse)")
            // ->andWhere(['<', 'b.use_start', $time])
            // ->andWhere(['>', 'b.use_end', $time])
            // ->createCommand()
            // ->getRawSql();
            ->asArray()
            ->all();
        loggingHelper::writeLog('diandi_tea', 'OrderService/chooseCoupon', '可使用卡券标记', [
            'list' => $list,
            'sql' => TeaMemberCoupon::find()
                ->alias('a')
                ->join('INNER JOIN', 'dd_diandi_tea_coupon b', 'a.coupon_id = b.id')
                ->select(['a.*', 'b.cash', 'b.cash', 'b.discount', 'b.max_time', 'b.enable_start', 'b.enable_end'])
                ->where($where)
                ->andWhere($andwhere)
                ->andWhere("FIND_IN_SET($hourse_id,b.use_hourse)")
                ->andWhere(['<', 'b.use_start', $time])
                ->andWhere(['>', 'b.use_end', $time])
                ->createCommand()
                ->getRawSql(),
        ]);
        $CouponType = CouponType::listData();
        foreach ($list as $key => &$value) {
            $value['type_str'] = $CouponType[$value['coupon_type']];
            $value['use_start'] = date('H:i', strtotime($value['use_start']));
            $value['use_end'] = date('H:i', strtotime($value['use_end']));
            $value['enable_start'] = date('Y-m-d', strtotime($value['enable_start']));
            $value['enable_end'] = date('Y-m-d', strtotime($value['enable_end']));
            $value['background'] = ImageHelper::tomedia(TeaCoupon::findOne($value['coupon_id'])->background);
            $value['max_time'] = (int)$value['max_time'];
        }

        return $list;
    }

    public static function isTest($member_id)
    {
        // 正式版需要去掉
        $host = Yii::$app->request->getHostInfo();
        if (strpos($host, 'dev') !== false) {
            return true;
        }

        return false;
    }

    /**
     * 预订包间创建订单.     *.
     *
     * @param $member_id
     * @param int $coupon_id
     * @param $amount_payable
     * @param float $discount
     * @param $real_pay
     * @param $hourse_id
     * @param $order_type
     * @param $set_meal_id
     * @param $set_meal_name
     * @param string $renew_order_id
     * @param $start_time
     * @param $end_time
     * @param $renew_price
     * @param string $renew_num
     * @return array
     * @throws Exception
     * @throws \Throwable
     */
    public static function createOrder($member_id, int $coupon_id, $amount_payable, float $discount, $real_pay, $hourse_id, $order_type, $set_meal_id, $set_meal_name, $renew_order_id, $start_time, $end_time, $renew_price, $renew_num = ''): array
    {
        // 订单基础信息写入
        $orderbase = [
            'hourse_id' => $hourse_id, //包间id
            'member_id' => $member_id, //用户id
            'coupon_id' => $coupon_id, //卡券id
            'set_meal_name' => $set_meal_name, //包间活动名
            'set_meal_id' => $set_meal_id, //包间活动id
            'real_pay' => $real_pay, //实际支付金额
            //'real_pay' => 0.01, //实际支付金额
            'amount_payable' => $amount_payable, //应付金额
            'discount' => $discount, //优惠金额
            //'pay_type' => $pay_type,//支付类型 1.现金支付 2.余额支付
            'renew_order_id' => $renew_order_id, //续费订单id
            'renew_price' => $renew_price, //半小时续费单价
            'order_type' => $order_type, //订单类型 1.包间订单  2.续费订单
            'start_time' => $start_time,
            'end_time' => $end_time,
            'status' => 1,
            'renew_num' => $renew_num,
        ];

        if (self::isTest($member_id)) {
            $orderbase['real_pay'] = 1;
        }
        if ($member_id) {
            if (strtotime($start_time) < time()) {
                return ResultHelper::json(401, '预定开始时间不能小于当前时间☹');
            }
        }

        $where_time1 = [
            'and',
            ['>=', 'start_time', $start_time],
            ['<=', 'end_time', $end_time],
        ];
        $where_time2 = [
            'and',
            ['<', 'start_time', $start_time],
            ['>', 'end_time', $start_time],
        ];
        $where_time3 = [
            'and',
            ['<', 'start_time', $end_time],
            ['>', 'end_time', $end_time],
        ];
        $where_time = [
            'or', $where_time1, $where_time2, $where_time3,
        ];

        $is_existence = TeaOrderList::find()->select(['id', 'member_id', 'status'])
            ->where(['hourse_id' => $hourse_id, 'status' => [1, 2, 3]])
            ->andWhere($where_time)
            ->asArray()->one();

        if (!empty($is_existence)) {
            loggingHelper::writeLog('diandi_tea', 'OrderService', '占用订单',[
                '占用订单' => $is_existence,
            ]);
            if ($is_existence['member_id'] != $member_id) {
                return ResultHelper::json(401, '该时段已被他人预定☹');
            } else {
                // 订单状态：1.待付款 2.支付成功 3.已完成 4.已取消
                // TeaOrderList::updateAll([
                //        'status' => 4,
                // ], [
                //     'id' => $is_existence['id'],
                // ]);
                self::cancelOrder($is_existence['id']);
            }
        }

        if ($coupon_id) {
            $TeaMemberCoupon = TeaMemberCoupon::find()->select(['id', 'surplus_num'])->where(['member_id' => $member_id, 'coupon_id' => $coupon_id])->asArray()->one();
            if ($TeaMemberCoupon['surplus_num'] < 1) {
                return ResultHelper::json(401, '优惠券不足☹');
            }
        }

        if ($order_type == 1) {
            loggingHelper::writeLog('diandi_tea', 'OrderService/createOrder', '包间id', $hourse_id);
            $parent_order_no = 'H' . self::CreateOrderno(); //包间订单为H开头
            $orderbase['order_number'] = $parent_order_no; //订单编号

            loggingHelper::writeLog('diandi_tea', 'OrderService/createOrder', '包间订单', $orderbase); //记录订单日志

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $HourseOrder = new TeaOrderList();
                loggingHelper::writeLog('diandi_tea', 'OrderService/createOrder', '开始写入');
                $order_id = 0;
                if ($HourseOrder->load($orderbase, '') && $HourseOrder->save()) {
                    $order_id = $HourseOrder->id;
                    //增加用户卡券已使用数量  减少用户卡券库存
                    if ($coupon_id) {
                        TeaMemberCoupon::updateAllCounters(['surplus_num' => -1, 'use_num' => 1], 'id=' . $TeaMemberCoupon['id']);
                        loggingHelper::writeLog('diandi_tea', 'OrderService/member_coupon', '开始写入', ['surplus_num' => -1, 'use_num' => 1, 'id' => $TeaMemberCoupon['id']]);
                    }
                } else {
                    $msg = ErrorsHelper::getModelError($HourseOrder);
                    loggingHelper::writeLog('diandi_tea', 'OrderService/createOrder', '写入订单错误', $msg);
                }
                self::payLog($orderbase, $order_id);

                $transaction->commit();
            } catch (\Exception $e) {
                loggingHelper::writeLog('diandi_tea', 'OrderService/createOrder', 'Exception错误', $e);

                $transaction->rollBack();
                throw $e;
            } catch (\Throwable $e) {
                loggingHelper::writeLog('diandi_tea', 'OrderService/createOrder', 'Throwable错误', $e);

                $transaction->rollBack();
                throw $e;
            }
        } elseif ($order_type == 2) {
            loggingHelper::writeLog('diandi_tea', 'OrderService/createOrder', '包间id', $hourse_id);
            $parent_order_no = 'X' . self::CreateOrderno(); //包间订单为H开头
            $orderbase['order_number'] = $parent_order_no; //订单编号
            $orderbase['status'] = 4; //订单编号
            loggingHelper::writeLog('diandi_tea', 'OrderService/createOrder', '包间续费订单', $orderbase); //记录订单日志

            $transaction = Yii::$app->db->beginTransaction();
            try {
                $HourseOrder = new TeaOrderList();
                loggingHelper::writeLog('diandi_tea', 'OrderService/createOrder', '开始写入');
                $order_id = 0;
                if ($HourseOrder->load($orderbase, '') && $HourseOrder->save()) {
                    $order_id = $HourseOrder->id;
                } else {
                    $msg = ErrorsHelper::getModelError($HourseOrder);
                    loggingHelper::writeLog('diandi_tea', 'OrderService/createOrder', '写入订单错误', $msg);
                }

                self::payLog($orderbase, $order_id);

                $transaction->commit();
            } catch (\Exception $e) {
                loggingHelper::writeLog('diandi_tea', 'OrderService/createOrder', 'Exception错误', $e);

                $transaction->rollBack();
                throw $e;
            } catch (\Throwable $e) {
                loggingHelper::writeLog('diandi_tea', 'OrderService/createOrder', 'Throwable错误', $e);

                $transaction->rollBack();
                throw $e;
            }
        } else {
            return ResultHelper::json(401, '订单类型错误');
        }

        $orderbase['id'] = $order_id;
        // //茶室名
        // $orderbase['hourse_name'] = TeaHourse::find()->select(['name'])->where(['id'=>$hourse_id])->asArray()->one()['name'];
        // //会员名
        // $orderbase['hourse_name'] = DdMember::find()->select(['nickName'])->where(['member_id'=>$member_id])->asArray()->one()['nickName'];
        // //卡券名
        // if(!empty($coupon_id)){
        //     $orderbase['coupon_name'] = TeaCoupon::find()->select(['name'])->where(['id'=>$coupon_id])->asArray()->one()['name'];
        // }else{
        //     $orderbase['coupon_name'] = '无';
        // }
        // 添加5分钟后检查订单
        Yii::$app->queue->delay(5 * 60)->push(new Orderobs([
            'order_id' => $order_id,
        ]));

        return $orderbase;
    }

    //生成余额充值订单
    public static function createRechargeOrder($member_id, $recharge_id, $price): array
    {
        // $balance = DdMemberAccount::find()->where(['member_id' => $member_id])->select('user_money')->asArray()->one()['user_money'];
        $parent_order_no = 'Y' . self::CreateOrderno(); //充值订单为C开头
        $orderbase = [
            'member_id' => $member_id,
            'recharge_id' => $recharge_id,
            'price' => $price,
            //'price' => 0.01,
            'status' => 1,
            'order_number' => $parent_order_no,
        ];
        if (self::isTest($member_id)) {
            $orderbase['price'] = 1;
        }

        loggingHelper::writeLog('diandi_tea', 'OrderService/createOrder', '余额充值订单', $orderbase); //记录订单日志

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $RechargeOrder = new TeaRechargeList();
            loggingHelper::writeLog('diandi_tea', 'OrderService/createOrder', '开始写入');
            $order_id = 0;
            if ($RechargeOrder->load($orderbase, '') && $RechargeOrder->save()) {
                $order_id = $RechargeOrder->id;
            } else {
                $msg = ErrorsHelper::getModelError($RechargeOrder);
                loggingHelper::writeLog('diandi_tea', 'OrderService/createOrder', '写入订单错误', $msg);
            }

            $orderbase['real_pay'] = $price;
            self::payLog($orderbase, $order_id);

            $transaction->commit();
        } catch (\Exception $e) {
            loggingHelper::writeLog('diandi_tea', 'OrderService/createOrder', 'Exception错误', $e);

            $transaction->rollBack();
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        } catch (\Throwable $e) {
            loggingHelper::writeLog('diandi_tea', 'OrderService/createOrder', 'Throwable错误', $e);

            $transaction->rollBack();
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        }

        $orderbase['name'] = '余额充值' . $price . '元';

        return $orderbase;
    }

    //生成卡券购买订单
    public static function createBuyCouponOrder($member_id, $coupon_id, $coupon_name, $price, $coupon_type): array
    {
        //$balance = DdMemberAccount::find()->where(['member_id' => $member_id])->select('user_money')->asArray()->one()['user_money'];
        $parent_order_no = 'K' . self::CreateOrderno();
        $orderbase = [
            'member_id' => $member_id,
            'coupon_id' => $coupon_id,
            'coupon_name' => $coupon_name,
            'price' => $price,
            //'price' => 0.01,
            'status' => 1,
            'order_number' => $parent_order_no,
            'coupon_type' => $coupon_type,
        ];
        if (self::isTest($member_id)) {
            $orderbase['price'] = 1;
        }

        loggingHelper::writeLog('diandi_tea', 'OrderService/createOrder', '卡券购买订单', $orderbase); //记录订单日志

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $BuyCouponOrder = new TeaCouponBuyList();
            loggingHelper::writeLog('diandi_tea', 'OrderService/createOrder', '开始写入');
            $order_id = 0;
            if ($BuyCouponOrder->load($orderbase, '') && $BuyCouponOrder->save()) {
                $order_id = $BuyCouponOrder->id;
            } else {
                $msg = ErrorsHelper::getModelError($BuyCouponOrder);
                loggingHelper::writeLog('diandi_tea', 'OrderService/createOrder', '写入订单错误', $msg);
            }

            $orderbase['real_pay'] = $price;
            self::payLog($orderbase, $order_id);

            $transaction->commit();
        } catch (\Exception $e) {
            loggingHelper::writeLog('diandi_tea', 'OrderService/createOrder', 'Exception错误', $e);

            $transaction->rollBack();
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        } catch (\Throwable $e) {
            loggingHelper::writeLog('diandi_tea', 'OrderService/createOrder', 'Throwable错误', $e);

            $transaction->rollBack();
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        }

        return $orderbase;
    }

    // 生成订单编号
    public static function CreateOrderno(): string
    {
        return date('Ymd') . substr(implode('', array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }

    // 写入订单支付日志
    public static function payLog($order, $order_id): bool
    {
        $user_id = $order['member_id'];
        $fans = DdWxappFans::getFansByUid($user_id);
        $openid = $fans['openid'];
        $data = [
            'type' => 'wechat',
            'openid' => $openid,
            'member_id' => $user_id,
            'uniontid' => $order['order_number'],
            'fee' => $order['real_pay'],
            'status' => 0,
            'module' => 'diandi_tea',
            'tag' => '小程序下单',
        ];

        $DdCorePaylog = new DdCorePaylog();
        $DdCorePaylog->load($data, '');
        return $DdCorePaylog->save();
    }

    public static function disableTime($info, $hourse_id, $minn, $minn_nomal, $type): array
    {
        $start = $info['start'];
        $end = $info['end'];
        //根据两天内时间计算不可选时间
        $disableTime = TeaOrderList::find()
            ->select(['start_time', 'end_time'])
            ->where(['hourse_id' => $hourse_id, 'status' => [2, 3]])
            ->andWhere(['>', 'end_time', $start])//结束时间大于今天开始时间
            ->andWhere(['<', 'start_time', $end])//开始时间小于明天结束时间
            ->asArray()
            ->all();
        $disable_hour_today = [];
        $disable_hour_tomorrow = [];
        $section_today = [];
        $section_tomorrow = [];
        foreach ($disableTime as $key => $value) {
            $int_start_time = strtotime($value['start_time']);
            $int_end_time = strtotime($value['end_time']);
            $s_hour = date('H', $int_start_time);
            $e_hour = date('H', $int_end_time);

            $s_minute = date('i', $int_start_time);
            $e_minute = date('i', $int_end_time);

            $s_day = date('Y-m-d', $int_start_time);
            $e_day = date('Y-m-d', $int_end_time);

            $diff_h = $e_hour - $s_hour;

            if ($s_minute == 0) {
                $i_hour = $s_hour;
            } else {
                $i_hour = $s_hour + 1;
            }

            //开始时间在今天
            if ($s_day == date('Y-m-d')) {
                //不在同一天
                if ($s_day != $e_day) {
                    //不可选时间段
                    $start_m = $s_minute - $s_minute % 5;

                    // echo $s_day,$e_day;die;
                    //第一天
                    for ($h = $s_hour; $h < 24; ++$h) {
                        if ($h > $s_hour) {
                            $for_m = 0;
                        } else {
                            $for_m = $start_m;
                        }
                        for ($m = $for_m; $m < 60; $m = $m + 5) {
                            if (strlen($h) < 2) {
                                if (strlen($m) < 2) {
                                    $section_today[] = '0' . "$h" . ':' . '0' . "$m" . ':00';
                                } else {
                                    $section_today[] = '0' . "$h" . ':' . "$m" . ':00';
                                }
                            } else {
                                if (strlen($m) < 2) {
                                    $section_today[] = "$h" . ':' . '0' . "$m" . ':00';
                                } else {
                                    $section_today[] = "$h" . ':' . "$m" . ':00';
                                }
                            }
                        }
                    }
                    //--------------------------------------------------------------------------
                    $end_m = $e_minute - $e_minute % 5;
                    //第二天
                    for ($h = 0; $h < $e_hour + 1; ++$h) {
                        if ($h == $e_hour) {
                            $for_m = $end_m;
                        } else {
                            $for_m = 60;
                        }

                        for ($m = 0; $m < $for_m; $m = $m + 5) {
                            if (strlen($h) < 2) {
                                if (strlen($m) < 2) {
                                    $section_tomorrow[] = '0' . "$h" . ':' . '0' . "$m" . ':00';
                                } else {
                                    $section_tomorrow[] = '0' . "$h" . ':' . "$m" . ':00';
                                }
                            } else {
                                if (strlen($m) < 2) {
                                    $section_tomorrow[] = "$h" . ':' . '0' . "$m" . ':00';
                                } else {
                                    $section_tomorrow[] = "$h" . ':' . "$m" . ':00';
                                }
                            }
                        }
                    }

                    //不可选小时-------------------------------------------------------------------------------
                    //echo 24-$s_hour+$e_hour;die;
                    if (24 - $s_hour + $e_hour >= 2) {
                        //第一天不可选时间
                        for ($i = $i_hour; $i < 24; ++$i) {
                            $disable_hour_today[] = $i + 0;
                        }
                        if ($e_hour != 0) {
                            $disable_hour_tomorrow[] = 0;
                        }
                        //第二天不可选时间
                        for ($i = 1; $i < $e_hour; ++$i) {
                            $disable_hour_tomorrow[] = $i + 0;
                        }
                    }
                } else {
                    //在同一天
                    //不可选小时-----------------------------------------------------------------------
                    if ($diff_h >= 1) {
                        for ($i = $i_hour; $i < $e_hour; ++$i) {
                            $disable_hour_today[] = $i + 0;
                        }
                    }
                    //不可选时间----------------------------------
                    $start_m = $s_minute - $s_minute % 5;
                    $end_m = $e_minute - $e_minute % 5;

                    for ($h = $s_hour; $h < $e_hour + 1; ++$h) {
                        if ($h > $s_hour) {
                            $for_m = 0;
                        } else {
                            $for_m = $start_m;
                        }
                        if ($h == $e_hour) {
                            $for_m2 = $end_m;
                        } else {
                            $for_m2 = 60;
                        }

                        for ($m = $for_m; $m < $for_m2; $m = $m + 5) {
                            if (strlen($h) < 2) {
                                if (strlen($m) < 2) {
                                    $section_today[] = '0' . "$h" . ':' . '0' . "$m" . ':00';
                                } else {
                                    $section_today[] = '0' . "$h" . ':' . "$m" . ':00';
                                }
                            } else {
                                if (strlen($m) < 2) {
                                    $section_today[] = "$h" . ':' . '0' . "$m" . ':00';
                                } else {
                                    $section_today[] = "$h" . ':' . "$m" . ':00';
                                }
                            }
                        }
                    }
                }
            } else {
                if ($diff_h > 1) {
                    for ($i = $i_hour; $i < $e_hour; ++$i) {
                        $disable_hour_tomorrow[] = $i + 0;
                    }
                }
                //不可选时间----------------------------------
                $start_m = $s_minute - $s_minute % 5;
                $end_m = $e_minute + 5 - $e_minute % 5;

                for ($h = $s_hour; $h < $e_hour + 1; ++$h) {
                    if ($h > $s_hour) {
                        $for_m = 0;
                    } else {
                        $for_m = $start_m;
                    }
                    if ($h == $e_hour) {
                        $for_m2 = $end_m;
                    } else {
                        $for_m2 = 60;
                    }

                    for ($m = $for_m; $m < $for_m2; $m = $m + 5) {
                        if (strlen($h) < 2) {
                            if (strlen($m) < 2) {
                                $section_tomorrow[] = '0' . "$h" . ':' . '0' . "$m" . ':00';
                            } else {
                                $section_tomorrow[] = '0' . "$h" . ':' . "$m" . ':00';
                            }
                        } else {
                            if (strlen($m) < 2) {
                                $section_tomorrow[] = "$h" . ':' . '0' . "$m" . ':00';
                            } else {
                                $section_tomorrow[] = "$h" . ':' . "$m" . ':00';
                            }
                        }
                    }
                }
            }
        }
        //第一天不可选时间段
        if ($type == 1) {
            //从当前时间的五分钟节点开始
            $today_intersect = array_intersect($minn, $section_today);
            $today_min = array_diff($minn, $today_intersect);
        } else {
            //从 00：00：00开始
            $today_min = array_diff($minn_nomal, $section_today);
        }
        //第二天不可选时间段
        $tomorrow_min = array_diff($minn_nomal, $section_tomorrow);
        $disable['disable_hour_today'] = array_values($disable_hour_today);

        $disable['disable_hour_tomorrow'] = array_values($disable_hour_tomorrow);
        $disable['today_min'] = array_values($today_min);
        $disable['tomorrow_min'] = array_values($tomorrow_min);

        // 如果当前房间使用中，那么今天所有时间段占用disable_hour_today ，且可选时间内容为空 today_min
        $status = TeaHourse::find()->where(['id' => $hourse_id])->select('status')->scalar();
        if ((int)$status != 1) {
            for ($i = 0; $i < 24; ++$i) {
                $disable['disable_hour_today'][] = $i;
            }
            $disable['today_min'] = [];
        }

        return $disable;
    }

    public static function fiveMin($now_hour = 0, $start_m = 0)
    {
        for ($h = $now_hour; $h < 24; ++$h) {
            if ($h > $now_hour) {
                $for_m = 0;
            } else {
                $for_m = $start_m;
            }
            for ($m = $for_m; $m < 60; $m = $m + 5) {
                if (strlen($h) < 2) {
                    if (strlen($m) < 2) {
                        $minn[] = '0' . "$h" . ':' . '0' . "$m" . ':00';
                    } else {
                        $minn[] = '0' . "$h" . ':' . "$m" . ':00';
                    }
                } else {
                    if (strlen($m) < 2) {
                        $minn[] = "$h" . ':' . '0' . "$m" . ':00';
                    } else {
                        $minn[] = "$h" . ':' . "$m" . ':00';
                    }
                }
            }
        }

        return $minn;
    }

    public static function charging($set_meal_id, $coupon_id = '', $start_time = '', $end_time = '')
    {
        $set_meal = TeaSetMeal::find()->where(['id' => $set_meal_id])->asArray()->one();
        $info = [];

        $Ymd = date('Y-m-d', strtotime($start_time));
        $His = date('H:i:s', strtotime($start_time));

        if (strtotime($His) > strtotime($end_time)) {
            $end_time = date('Y-m-d', strtotime("$Ymd +1 day")) . ' ' . $end_time;
        } else {
            $end_time = $Ymd . ' ' . $end_time;
        }

        $end_time_int = strtotime($end_time);
        $start_time_int = strtotime($start_time);
        $diff = $end_time_int - $start_time_int;

        //计算应付金额 初始化为套餐金额
        $amount_payable = $set_meal['price'];
        // 优惠金额
        $discount = 0;
        if ($set_meal['type'] == 1) {
            $amount_payable = $set_meal['price'];
        } else {
            $s = $set_meal['duration'] * 3600;
            // if ($coupon_id) {
            //     //去掉卡券赠送时间计算真实金额
            //     $coupon = TeaCoupon::find()->where(['id' => $coupon_id])->asArray()->one();
            //     $diff = $diff - $coupon['max_time'] * 3600;
            // }

            //计算单位个数
            $num = ceil($diff / $s);
            $amount_payable = $num * $set_meal['price'];
        }

        //计算优惠金额
        if (!empty($coupon_id)) {
            $coupon = TeaCoupon::find()->where(['id' => $coupon_id])->asArray()->one();
            //体验券类型 卡券类型  1：代金券 2：时长卡  3：次卡 4：折扣券 5：体验券
            $coupon_type = $coupon['type'];
            // 计时套餐 考虑时间长度
            // if ($set_meal['type'] == 1) {
            //     if ($coupon_type === 5) {
            //         if ($coupon['max_time'] * 3600 < $diff) {
            //             return ResultHelper::json(401, '套餐时长超出体验卡时间');
            //         } else {
            //             $discount = $amount_payable;
            //         }
            //     }
            // }

            switch ($coupon_type) {
                case 1:
                    //代金券
                    if ($coupon['cash'] > $amount_payable) {
                        return ResultHelper::json(401, '优惠券金额超出套餐，不能使用');
                    }
                    $discount = $coupon['cash'];
                    break;
                case 2:
                    //时长卡 增加时长，不减持金额
                    // if ($coupon['max_time'] * 3600 < $diff) {
                    //     return ResultHelper::json(401, '套餐时长超出时长卡时间');
                    // } else {
                    //     $discount = 0;
                    // }
                    $discount = 0;

                    break;
                case 3:
                    //次卡
                    if ($coupon['max_time'] * 3600 < $diff) {
                        return ResultHelper::json(401, '套餐时长超出次卡时间');
                    } else {
                        // 全免
                        $discount = $amount_payable;
                    }
                    break;
                case 4:
                    //折扣券
                    $discount = round($amount_payable * (1 - $coupon['discount'] / 100));
                    break;
                case 5:
                    //体验券
                    if ($coupon['max_time'] * 3600 < $diff && $set_meal['type'] == 1) {
                        return ResultHelper::json(401, '套餐时长超出体验时间');
                    } else {
                        $discount = $amount_payable;
                    }
                    break;
            }
        } else {
            $discount = 0;
        }

        $real_pay = $amount_payable - $discount;
        //实付金额
        $info['amount_payable'] = number_format($amount_payable, 2);
        $info['discount'] = number_format($discount, 2);
        //$info['real_pay'] = number_format($info['amount_payable'] - $info['discount'], 2);
        $info['real_pay'] = number_format($real_pay, 2);

        return $info;
    }

    public static function orderDetail($order_id)
    {
        $info = TeaOrderList::find()
            ->alias('order')
            ->join('LEFT JOIN', 'dd_member member', 'order.member_id = member.member_id')
            ->join('LEFT JOIN', 'dd_diandi_tea_coupon coupon', 'order.coupon_id = coupon.id')
            ->join('LEFT JOIN', 'dd_diandi_tea_hourse hourse', 'order.hourse_id = hourse.id')
            ->where(['order.id' => $order_id])
            ->select(['order.*', 'member.nickName', 'coupon.name AS coupon_name', 'hourse.name AS hourse_name'])
            ->asArray()
            ->one();

        $info['start_time'] = date('Y-m-d H:i', strtotime($info['start_time']));
        $info['end_time'] = date('Y-m-d H:i', strtotime($info['end_time']));
        $info['end_time_open'] = date('Y-m-d H:i', strtotime($info['end_time']) + 30 * 60);
        //余额
        if ($info['status'] == 1) {
            $info['balance'] = DdMemberAccount::find()->select(['user_money'])->where(['member_id' => $info['member_id']])->asArray()->one()['user_money'];
        }

        $start_int = strtotime($info['start_time']);
        $time = time();
        //倒计时
        if ($start_int > $time) {
            $diff = $start_int - $time;
            // $day = $diff / (24 * 3600);
            // $H = $diff % (24 * 3600) / 3600;
            // $i = $diff % 3600 / 60;
            // $s = $diff % 60;

            // $info['diff'] = [
            //     'day' => floor($day),
            //     'H' => floor($H),
            //     'i' => floor($i),
            //     's' => $s,
            // ];
            $info['diff'] = $diff;
        } else {
            $info['diff'] = 0;
        }

        $renew_order = TeaOrderList::find()->where(['renew_order_id' => $order_id, 'order_type' => 2, 'status' => [2, 3]])->asArray()->all();
        foreach ($renew_order as &$val) {
            $val['start_time'] = date('Y-m-d H:i', strtotime($val['start_time']));
            $val['end_time'] = date('Y-m-d H:i', strtotime($val['end_time']));
        }
        $info['renew_order'] = $renew_order;
        $real_start = $info['start_time'];
        if ($renew_order) {
            $real_end = array_pop($renew_order)['end_time'];
        } else {
            $real_end = $info['end_time'];
        }
        $time = date('Y-m-d H:i');
        loggingHelper::writeLog('diandi_tea', 'OrderService/orderDetail', '订单状态获取', [
            '当前时间' => $time,
            '订单开始时间' => $real_start,
            '订单数据' => $info,
        ]);

        if ($time < $real_start) {
            //待使用
            $info['is_open'] = 1;
        } elseif ($time >= $real_start && $time <= $info['end_time_open']) {
            //使用中
            $info['is_open'] = 2;
        } else {
            //已过期
            $info['is_open'] = 3;
        }

        loggingHelper::writeLog('diandi_tea', 'OrderService/orderDetail', '订单状态', [
            'is_open' => $info['is_open'],
        ]);

        $info['status_str'] = OrderStatus::getLabel($info['status']);

        return $info;
    }

    public static function invoice($order_id, $phone, $company, $email, $member_id, $type, $bank, $bank_address, $company_address, $taxpayer_no)
    {
        $info = [
            'order_id' => $order_id,
            'phone' => $phone,
            'company' => $company,
            'email' => $email,
            'status' => 2,
            'member_id' => $member_id,
            'type' => $type,
            'bank' => $bank,
            'bank_address' => $bank_address,
            'company_address' => $company_address,
            'taxpayer_no' => $taxpayer_no,
        ];
        if ($type == 1) {
            $is_over = TeaOrderList::find()->select(['status'])->where(['id' => $order_id])->asArray()->one()['status'];
            if ($is_over != 3) {
                return ResultHelper::json(400, '订单未完成');
            }
        }

        $is_have = TeaInvoice::find()->where(['order_id' => $order_id, 'type' => $type])->asArray()->one();
        if ($is_have) {
            return ResultHelper::json(400, '已申请过发票');
        } else {
            $invoiceModel = new TeaInvoice();

            $invoiceModel->load($info, '');

            if ($invoiceModel->save()) {
                return ResultHelper::json(200, '申请开票成功！');
            } else {
                return ResultHelper::json(400, '申请开票失败，请稍后重试！');
            }
        }
    }

    /**
     * 退款处理.
     *
     * @param [type] $order_id
     *
     * @return array
     * @date 2022-06-15
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public static function Refund($order_id): array
    {
        // 是否存在
        $orderDetail = self::orderDetail($order_id);
        $member_id = $orderDetail['member_id'];

        if (empty($orderDetail)) {
            return ResultHelper::serverJson(1, '订单不存在');
        }
        // 是否付款
        if ((int)$orderDetail['status'] != OrderStatus::status2) {
            return ResultHelper::serverJson(1, '未支付不能退款');
        }
        // 是否时间满足
        $time = time();
        $start_time = DateHelper::dateToInt($orderDetail['start_time']);
        if ($start_time - $time < 0) {
            return ResultHelper::serverJson(1, '预订时间已到，不能退款');
        }

        if ($start_time - $time <= 30 * 60) {
            return ResultHelper::serverJson(1, '距离预订时间不足30分钟');
        }
        // 看支付方式退钱
        $pay_type = $orderDetail['pay_type'];
        // 支付方式：1.现金支付 2.余额支付
        if ($pay_type === 1) {
            $transactionId = $orderDetail['transaction_id'];
            $totalFee = $orderDetail['real_pay'];
            $refundFee = $orderDetail['real_pay'];
            self::RefundIntegral($member_id, $order_id);
            $ref = self::refundMoney($order_id, $transactionId, $totalFee, $refundFee);
            if (!$ref) {
                return ResultHelper::serverJson(1, '退款到账失败');
            }
        } else {
            $real_pay = $orderDetail['real_pay'];
            DdMemberAccount::updateAllCounters(['user_money' => $real_pay], ['member_id' => $member_id]);
            TeaOrderList::updateAll([
                'status' => OrderStatus::status5,
            ], ['id' => $order_id]);
            $balance = DdMemberAccount::find()->where(['member_id' => $member_id])->select('user_money')->scalar();

            $accountLoginfo = [
                'member_id' => $member_id,
                'account_type' => 'tea_member_money_balance',
                'old_money' => $balance,
                'money' => $real_pay,
                'is_add' => 0,
                'money_id' => $order_id,
                'remark' => '退款余额增加',
            ];
            loggingHelper::writeLog('diandi_tea', 'Refund', '退款余额增加', $accountLoginfo);
            $AccountLog = new AccountLog();
            $AccountLog->load($accountLoginfo, '');
            $AccountLog->save();
        }

        // 奖励积分退还
        // 看优惠券消耗退优惠券
        $coupon_id = $orderDetail['coupon_id'];

        if (!empty($coupon_id)) {
            // 查找用户是否有卡券，没有就添加，有就增加
            $id = TeaMemberCoupon::find()->select(['id'])->where(['member_id' => $member_id, 'coupon_id' => $coupon_id])->scalar();
            TeaMemberCoupon::updateAllCounters(['surplus_num' => 1, 'use_num' => -1], 'id=' . $id);
            loggingHelper::writeLog('diandi_tea', 'cancelOrder', '过期订单卡券返还', $id);
        }

        return ResultHelper::serverJson(0, '退款成功');
    }

    public static function RefundIntegral($member_id, $order_id)
    {
        $AccountLog = new AccountLog();
        $old_accountLoginfoIntegral = $AccountLog->find()->where(['money_id' => $order_id, 'member_id' => $member_id])->asArray()->one();
        $memberIntegral = DdMemberAccount::find()->select('user_integral')
            ->where(['member_id' => $member_id])->asArray()->one()['user_integral'];
        $integral = -$old_accountLoginfoIntegral['money'];

        //更改积分
        DdMemberAccount::updateAllCounters([
            'user_integral' => $integral,
            'accumulate_integral' => $integral,
            'give_integral' => $integral,
        ], ['member_id' => $member_id]);
        //记录系统赠送积分记录
        $accountLoginfoIntegral = [
            'member_id' => $member_id,
            'account_type' => 'tea_member_give_integral',
            'money' => $integral,
            'is_add' => 0,
            'old_money' => $memberIntegral,
            'money_id' => $order_id,
            'remark' => '退单减积分',
        ];
        loggingHelper::writeLog('diandi_tea', 'Notify', '更新系统用户下单赠送积分记录', $accountLoginfoIntegral);

        $AccountLog->load($accountLoginfoIntegral, '');
        $AccountLog->save();
    }

    /**
     * 微信退款.
     *
     * @param float $refundFee
     * @param array $config
     *
     * @return void
     */
    public static function refundMoney($order_id, $transactionId, $totalFee, $refundFee, $config = [])
    {
        $wechat = Yii::$app->wechat->payment;
        $refundNumber = 'R' . self::CreateOrderno();
        loggingHelper::writeLog('diandi_distribution', 'AftersaleService/refundMoney', '退款开始', [
            'transactionId' => $transactionId,
            'refundNumber' => $refundNumber,
            'totalFee' => $totalFee,
            'refundFee' => $refundFee,
            'config' => $config,
        ]);

        // 参数分别为：微信订单号、商户退款单号、订单金额、退款金额、其他参数
        $totalFeeNum = intval(strval($totalFee * 100));
        $refundFeeNum = intval(strval($refundFee * 100));
        loggingHelper::writeLog('diandi_tea', 'OrderService/refundMoney', '退款参数', [
            'transactionId' => $transactionId,
            'refundNumber' => $refundNumber,
            'totalFeeNum' => $totalFeeNum,
            'refundFeeNum' => $refundFeeNum,
        ]);

        $result = $wechat->refund->byTransactionId($transactionId, $refundNumber, $totalFeeNum, $refundFeeNum, $config);
        loggingHelper::writeLog('diandi_tea', 'OrderService/refundMoney', '退款结果', $result);
        if ($result['return_code'] == 'FAIL') {
            // 退款申请失败
            return false;
        } else {
            TeaOrderList::updateAll([
                'refund_order_number' => $refundNumber,
                'status' => OrderStatus::status5,
            ], ['id' => $order_id]);
        }

        return $result;
    }

    public static function MeiTuanOrder($hourse_id, $coupon_id): array
    {
        return ResultHelper::json(200, '获取成功');
    }
}
