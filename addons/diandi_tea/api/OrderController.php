<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-14 10:56:16
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-07-01 19:12:23
 */

namespace addons\diandi_tea\api;

use addons\diandi_tea\models\config\TeaGlobalConfig;
use addons\diandi_tea\models\config\TeaHourse;
use addons\diandi_tea\models\marketing\TeaCoupon;
use addons\diandi_tea\models\marketing\TeaMemberCoupon;
use addons\diandi_tea\models\marketing\TeaRecharge;
use addons\diandi_tea\models\marketing\TeaSetMeal;
use addons\diandi_tea\models\order\TeaInvoice;
use addons\diandi_tea\models\order\TeaOrderList;
use addons\diandi_tea\services\diandiLockSdk;
use addons\diandi_tea\services\OrderService as ServicesOrderService;
use api\controllers\AController;
use common\helpers\ArrayHelper;
use common\helpers\loggingHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\db\Exception;

class OrderController extends AController
{
    public $modelClass = '';

    protected array $authOptional = ['recharge-activity'];

    /**
     * @SWG\Post(path="/diandi_tea/order/setmeallist",
     *    tags={"订单"},
     *    summary="包间套餐列表",
     *     @SWG\Response(
     *         response = 200,
     *         description = "包间套餐列表",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *    @SWG\Parameter(
     *     in="query",
     *     name="hourse_id",
     *     type="integer",
     *     description="包间id",
     *     required=false,
     *   ),
     * )
     */
    public function actionSetMealList(): array
   {
        $data = Yii::$app->request->post();
        $hourse_id = $data['hourse_id'];
        $setMealList = ServicesOrderService::setMealList($hourse_id);

        return ResultHelper::json(200, '请求成功', $setMealList);
    }

    /**
     * @SWG\Post(path="/diandi_tea/order/couponlist",
     *    tags={"订单"},
     *    summary="所有卡券列表",
     *     @SWG\Response(
     *         response = 200,
     *         description = "卡券列表",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *    @SWG\Parameter(
     *     in="query",
     *     name="type",
     *     type="integer",
     *     description="卡券类型  1：代金券 2：时常卡  3：次卡 4：折扣券 5：体验券",
     *     required=false,
     *   ),
     * )
     */
    public function actionCouponList(): array
   {

        $data = Yii::$app->request->post();
        $type = $data['type'] ? $data['type'] : '';
        $couponList = ServicesOrderService::couponList($type);
        $member_id = Yii::$app->user->identity->member_id ?? 0;
        if (in_array($member_id, [11254])) {
            return ResultHelper::json(200, '请求成功', $couponList);
        }
        // 暂时返回空，客户没想明白
        return ResultHelper::json(200, '请求成功', []);
    }

    /**
     * @SWG\Post(path="/diandi_tea/order/mycoupon",
     *    tags={"订单"},
     *    summary="我的卡券列表",
     *     @SWG\Response(
     *         response = 200,
     *         description = "我的卡券列表",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *    @SWG\Parameter(
     *     in="query",
     *     name="type",
     *     type="integer",
     *     description="卡券类型  1：代金券 2：时常卡  3：次卡 4：折扣券 5：体验券",
     *     required=false,
     *   ),
     * )
     */
    public function actionMyCoupon(): array
    {
        $data = Yii::$app->request->post();
        $member_id = Yii::$app->user->identity->member_id ?? 0;
        $type = $data['type'] ? $data['type'] : '';
        $couponList = ServicesOrderService::myCoupon($type, $member_id);

        return ResultHelper::json(200, '请求成功', $couponList);
    }

    public function actionNowOrder(): array
    {
        $member_id = Yii::$app->user->identity->member_id ?? 0;
        $time = date('Y-m-d H:i:s');
        $where1 = ['<', 'start_time', $time];
        $where2 = ['>', 'end_time', $time];
        $order_id = TeaOrderList::find()->where($where1)->andWhere($where2)->andWhere(['status' => 2])->andWhere(['member_id' => $member_id])->select('id')->scalar();
        if ($order_id) {
            return ResultHelper::json(200, '请求成功', [
                'order_id' => $order_id,
            ]);
        } else {
            return ResultHelper::json(401, '您还没有订单，请预订');
        }
    }

    public function actionChooseCoupon(): array
    {
        $data = Yii::$app->request->post();
        $member_id = Yii::$app->user->identity->member_id ?? 0;
        $hourse_id = $data['hourse_id'];
        if (empty($hourse_id)) {
            return ResultHelper::json(400, '缺少包间id');
        }
        $couponList = ServicesOrderService::chooseCoupon($hourse_id, $member_id);

        return ResultHelper::json(200, '请求成功', $couponList);
    }

    /**
     * @SWG\Post(path="/diandi_tea/order/rechargeactivity",
     *    tags={"订单"},
     *    summary="充值活动列表",
     *     @SWG\Response(
     *         response = 200,
     *         description = "充值活动列表",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *    @SWG\Parameter(
     *     in="query",
     *     name="type",
     *     type="integer",
     *     description="卡券类型",
     *     required=false,
     *   ),
     * )
     */
    public function actionRechargeActivity(): array
   {

        $list = TeaRecharge::find()->select(['id', 'price', 'type', 'give_money', 'give_coupon_ids'])->asArray()->all();

        foreach ($list as $key => &$value) {
            $ids = explode(',', $value['give_coupon_ids']);
            if ($value['give_coupon_ids']) {
                $give_coupon = TeaCoupon::find()->select(['name', 'explain', 'type', 'price', 'use_start', 'use_end', 'enable_start', 'enable_end', 'background', 'enable_store', 'enable_week', 'max_time'])->where(['id' => $ids])->asArray()->all();
                $value['give_coupon_name'] = implode(',', array_column($give_coupon, 'name'));
                $value['give_time'] = TeaCoupon::find()->where(['id' => $ids])->sum('max_time');
            }
        }

        // 获取充值订阅模板ID
        $msg_template = TeaGlobalConfig::find()->where(['store_id' =>\Yii::$app->request->input('store_id',0)])->select(['recharge_template'])->asArray()->one();
        $msg_templates = array_values($msg_template);

        return ResultHelper::json(200, '请求成功', [
            'list' => ArrayHelper::arraySort($list, 'price'),
            'msg_template' => $msg_templates,
        ]);
    }

    /**
     * @SWG\Post(path="/diandi_tea/order/renewprice",
     *    tags={"订单"},
     *    summary="订单续费单价",
     *     @SWG\Response(
     *         response = 200,
     *         description = "订单续费单价",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *   @SWG\Parameter(
     *     in="query",
     *     name="order_id",
     *     type="integer",
     *     description="订单id",
     *     required=false,
     *   ),
     * )
     */
    public function actionRenewPrice(): array
   {
        $order_id =\Yii::$app->request->input('order_id');
        $set_meal_id = TeaOrderList::find()->where(['id' => $order_id])->select('set_meal_id')->one();
        $price = TeaSetMeal::find()->where(['id' => $set_meal_id['set_meal_id']])->select('renew_price')->one();

        return ResultHelper::json(200, '请求成功', $price);
    }

    /**
     * @SWG\Post(path="/diandi_tea/order/createorder",
     *     tags={"订单"},
     *     summary="创建(包间/续费)订单",
     *     @SWG\Response(
     *         response = 200,
     *         description = "创建订单",
     *     ),
     *     @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *     ),
     *     @SWG\Parameter(
     *          in="formData",
     *          name="start_time",
     *          type="string",
     *          description="开始时间",
     *          required=true,
     *   ),
     *     @SWG\Parameter(
     *          in="formData",
     *          name="end_time",
     *          type="string",
     *          description="结束时间",
     *          required=true,
     *   ),
     *     @SWG\Parameter(
     *          in="formData",
     *          name="coupon_id",
     *          type="integer",
     *          description="使用卡券id",
     *          required=true,
     *   ),
     *     @SWG\Parameter(
     *          in="formData",
     *          name="amount_payable",
     *          type="number",
     *          description="应付金额",
     *          required=false,
     *   ),
     *   @SWG\Parameter(
     *          in="formData",
     *          name="discount",
     *          type="number",
     *          description="优惠金额",
     *          required=true,
     *   ),
     *   @SWG\Parameter(
     *          in="formData",
     *          name="real_pay",
     *          type="number",
     *          description="实付金额",
     *          required=true,
     *   ),
     *   @SWG\Parameter(
     *          in="formData",
     *          name="renew_order_id",
     *          type="integer",
     *          description="所续费订单id",
     *          required=true,
     *   ),
     *   @SWG\Parameter(
     *          in="formData",
     *          name="renew_price",
     *          type="integer",
     *          description="所续费订单id",
     *          required=true,
     *   ),
     *   @SWG\Parameter(
     *          in="formData",
     *          name="order_type",
     *          type="integer",
     *          description="订单类型 1.包间订单  2.续费订单",
     *          required=true,
     *   ),
     *   @SWG\Parameter(
     *          in="formData",
     *          name="pay_type",
     *          type="integer",
     *          description="支付方式：1.现金支付 2.余额支付",
     *          required=true,
     *   ),
     *   @SWG\Parameter(
     *          in="formData",
     *          name="renew_num",
     *          type="integer",
     *          description="续费单位个数",
     *          required=true,
     *   ),
     * )
     */
    public function actionCreateOrder(): array
    {
        $member_id = Yii::$app->user->identity->member_id ?? 0;

        $coupon_id = Yii::$app->request->post('coupon_id', 0);
        $discount = Yii::$app->request->post('discount', 0);
        $set_meal_id = Yii::$app->request->post('set_meal_id');
        $set_meal_name = Yii::$app->request->post('set_meal_name');
        $renew_order_id = Yii::$app->request->post('renew_order_id');
        $renew_num = Yii::$app->request->post('renew_num');
        $order_type = Yii::$app->request->post('order_type');
        $hourse_id = Yii::$app->request->post('hourse_id');
        $start_time = Yii::$app->request->post('start_time');
        $end_time = Yii::$app->request->post('end_time');
        $amount_payable = Yii::$app->request->post('amount_payable');
        $real_pay = Yii::$app->request->post('real_pay');
        if (empty($order_type)) {
            return ResultHelper::json(401, '缺少订单类型');
        }

        if ($order_type == 1) {
            if ($set_meal_id) {
                $set_meal_model = TeaSetMeal::find()->select(['title', 'renew_price'])->where(['id' => $set_meal_id])->asArray()->one();
                $set_meal_name = $set_meal_model['title'];
                $renew_price = $set_meal_model['renew_price'];
            } else {
                return ResultHelper::json(401, '缺少套餐id');
            }

            if (empty($hourse_id)) {
                return ResultHelper::json(401, '缺少包间id');
            }

            if (empty($start_time)) {
                return ResultHelper::json(401, '缺少开始时间');
            }

            if (empty($end_time)) {
                return ResultHelper::json(401, '缺少结束时间');
            }

            if (!empty($coupon_id)) {
                $coupon_model = TeaCoupon::find()->where(['id' => $coupon_id])->asArray()->one();
                if ($coupon_model['enable_end'] < date('Y-m-d H:i:s') || $coupon_model['enable_start'] > date('Y-m-d H:i:s')) {
                    return ResultHelper::json(401, '该卡券不在有效期内！');
                }
                // if ($coupon_model['use_end'] < date('H:i:s') || $coupon_model['use_start'] > date('H:i:s')) {
                //     return ResultHelper::json(401, '该卡券不在使用时间段！');
                // }
            }

            $Ymd = date('Y-m-d', strtotime($start_time));
            $His = date('H:i:s', strtotime($start_time));

            if (strtotime($His) >= strtotime($end_time)) {
                $end_time = date('Y-m-d', strtotime("$Ymd +1 day")) . ' ' . $end_time;
            } else {
                $end_time = $Ymd . ' ' . $end_time;
            }
        } else {
            if ($renew_order_id) {
                $order_model = TeaOrderList::find()->where(['id' => $renew_order_id])->asArray()->one();
                $set_meal_model = TeaSetMeal::find()->select(['title', 'renew_price'])->where(['id' => $order_model['set_meal_id']])->asArray()->one();
                $hourse_id = $order_model['hourse_id'];
                $renew_price = $set_meal_model['renew_price'];
                if (empty($hourse_id)) {
                    return ResultHelper::json(401, '包间不存在');
                }
                if ($order_model['status'] != 2) {
                    return ResultHelper::json(401, '当前订单不允许续费！');
                }
            } else {
                return ResultHelper::json(401, '缺少续费订单id');
            }
            if (empty($renew_num)) {
                return ResultHelper::json(401, '缺少续费单位个数');
            }

            //上一次订单结束时间
            $order_end_time = TeaOrderList::find()->where(['renew_order_id' => $renew_order_id, 'status' => 2])->orderBy('create_time DESC')->asArray()->one();

            //return ResultHelper::json(401, '缺少续费单位个数'.$order_end_time['id']);
            if ($order_end_time['end_time']) {
                $order_end_time = $order_end_time['end_time'];
            } else {
                $order_end_time = TeaOrderList::find()->select(['end_time'])->where(['id' => $renew_order_id])->asArray()->one()['end_time'];
            }

            // 延迟半个小时的续费时长
            if ($order_end_time < date('Y-m-d H:i:s', time() + 30 * 60)) {
                return ResultHelper::json(401, '该订单已结束，请重新下单！');
            }
            //开始时间
            $start_time = $order_end_time;
            //结束时间
            $end_time = date('Y-m-d H:i:s', strtotime($start_time) + $renew_num * 1800);
        }

        if (empty($amount_payable)) {
            return ResultHelper::json(401, '缺少应付金额');
        }
        if (empty($real_pay)) {
            return ResultHelper::json(401, '缺少实付金额');
        }

        try {
            $orderInfo = ServicesOrderService::createOrder($member_id, $coupon_id, $amount_payable, $discount, $real_pay, $hourse_id, $order_type, $set_meal_id, $set_meal_name, $renew_order_id, $start_time, $end_time, $renew_price, $renew_num);
            return ResultHelper::json(200, '创建订单成功', $orderInfo);
        } catch (Exception $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        } catch (\Throwable $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);

        }
    }

    /**
     * @SWG\Post(path="/diandi_tea/order/createrechargeorder",
     *     tags={"订单"},
     *     summary="创建充值订单",
     *     @SWG\Response(
     *         response = 200,
     *         description = "创建充值订单",
     *     ),
     *     @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *     ),
     *   @SWG\Parameter(
     *          in="formData",
     *          name="recharge_id",
     *          type="integer",
     *          description="充值套餐id",
     *          required=true,
     *   ),
     *   @SWG\Parameter(
     *          in="formData",
     *          name="price",
     *          type="number",
     *          description="充值金额",
     *          required=true,
     *   ),
     * )
     */
    public function actionCreateRechargeOrder(): array
   {

        $data = \Yii::$app->request->input();
        $member_id = Yii::$app->user->identity->member_id ?? 0;

        if ($data['recharge_id'] && $data['price']) {
            $recharge_id = $data['recharge_id'];
            $price = $data['price'];
        } else {
            return ResultHelper::json(401, '缺少参数');
        }

        $orderInfo = ServicesOrderService::createRechargeOrder($member_id, $recharge_id, $price);

        return ResultHelper::json(200, '创建订单成功', $orderInfo);
    }

    /**
     * @SWG\Post(path="/diandi_tea/order/createbuycouponorder",
     *     tags={"订单"},
     *     summary="创建卡券购买订单",
     *     @SWG\Response(
     *         response = 200,
     *         description = "创建卡券购买订单",
     *     ),
     *     @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *     ),
     *   @SWG\Parameter(
     *          in="formData",
     *          name="coupon_id",
     *          type="integer",
     *          description="卡券id",
     *          required=true,
     *   ),
     *   @SWG\Parameter(
     *          in="formData",
     *          name="coupon_type",
     *          type="integer",
     *          description="卡券类型",
     *          required=true,
     *   ),
     *   @SWG\Parameter(
     *          in="formData",
     *          name="coupon_name",
     *          type="string",
     *          description="卡券名",
     *          required=true,
     *   ),
     *   @SWG\Parameter(
     *          in="formData",
     *          name="price",
     *          type="number",
     *          description="购买金额",
     *          required=true,
     *   ),
     * )
     */
    public function actionCreateBuyCouponOrder(): array
   {

        $data = \Yii::$app->request->input();
        $member_id = Yii::$app->user->identity->member_id ?? 0;
        if ($data['coupon_id'] && $data['price'] && $data['coupon_name'] && $data['coupon_type']) {
            $coupon_id = $data['coupon_id'];
            $price = $data['price'];
            $coupon_name = $data['coupon_name'];
            $coupon_type = $data['coupon_type'];
        } else {
            return ResultHelper::json(400, '缺少参数');
        }

        $member_coupon_model = TeaMemberCoupon::find()->where(['member_id' => $member_id, 'coupon_id' => $coupon_id])->asArray()->one();
        if ($member_coupon_model) {
            $max_num = TeaCoupon::find()->where(['id' => $coupon_id])->select('max_num')->scalar();
            if (($member_coupon_model['surplus_num'] + $member_coupon_model['use_num'] + 1) > $max_num) {
                return ResultHelper::json(401, '购买该卡券已达上限');
            }
        }

        $orderInfo = ServicesOrderService::createBuyCouponOrder($member_id, $coupon_id, $coupon_name, $price, $coupon_type);

        return ResultHelper::json(200, '创建订单成功', $orderInfo);
    }

    /**
     * @SWG\Post(path="/diandi_tea/order/hoursedetail",
     *    tags={"订单"},
     *    summary="包间详情",
     *     @SWG\Response(
     *         response = 200,
     *         description = "包间详情",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *    @SWG\Parameter(
     *     in="query",
     *     name="hourse_id",
     *     type="integer",
     *     description="包间id",
     *     required=false,
     *   ),
     * )
     */
    public function actionHourseDetail(): array
   {
        $bloc_id =\Yii::$app->request->input('bloc_id',0);
        $store_id =\Yii::$app->request->input('store_id',0);

        $data = Yii::$app->request->post();

        $hourse_id = $data['hourse_id'];
        //$setMealList = ServicesOrderService::setMealList($hourse_id);
        $data = ServicesOrderService::hourseInfo($hourse_id, $store_id, $bloc_id);

        return ResultHelper::json(200, '请求成功', $data);
    }

    /**
     * @SWG\Post(path="/diandi_tea/order/cancelorder",
     *    tags={"订单"},
     *    summary="取消订单",
     *     @SWG\Response(
     *         response = 200,
     *         description = "取消订单",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *    @SWG\Parameter(
     *     in="query",
     *     name="order_id",
     *     type="integer",
     *     description="订单id",
     *     required=false,
     *   ),
     * )
     */
    public function actionCancelOrder(): array
    {
        $data = Yii::$app->request->post();
        $order_id = $data['order_id'];
        if (empty($order_id)) {
            return ResultHelper::json(400, '缺少订单id');
        }
        ServicesOrderService::cancelOrder($order_id);

        return ResultHelper::json(200, '取消成功');
    }

    /**
     * @SWG\Post(path="/diandi_tea/order/charging",
     *    tags={"订单"},
     *    summary="套餐计费",
     *     @SWG\Response(
     *         response = 200,
     *         description = "套餐计费",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="set_meal_id",
     *     type="integer",
     *     description="套餐id",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="coupon_id",
     *     type="integer",
     *     description="卡券id",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="start_time",
     *     type="string",
     *     description="开始时间",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="end_time",
     *     type="string",
     *     description="结束时间",
     *     required=true,
     *   ),
     * )
     */
    public function actionCharging(): array
    {
        $set_meal_id = Yii::$app->request->post('set_meal_id');
        $coupon_id = Yii::$app->request->post('coupon_id');
        $start_time = Yii::$app->request->post('start_time');
        $end_time = Yii::$app->request->post('end_time');

        if (empty($set_meal_id)) {
            return ResultHelper::json(401, '缺少套餐id');
        }

        if (empty($start_time)) {
            return ResultHelper::json(401, '缺少开始时间');
        }
        if (empty($end_time)) {
            return ResultHelper::json(401, '缺少结束时间');
        }

        $info = ServicesOrderService::charging($set_meal_id, $coupon_id, $start_time, $end_time);

        return ResultHelper::json(200, '获取成功', $info);
    }

    /**
     * @SWG\Get(path="/diandi_tea/order/orderdetail",
     *    tags={"订单"},
     *    summary="订单详情",
     *     @SWG\Response(
     *         response = 200,
     *         description = "订单详情",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *    @SWG\Parameter(
     *     in="query",
     *     name="order_id",
     *     type="integer",
     *     description="订单id",
     *     required=true,
     *   ),
     * )
     */
    public function actionOrderDetail(): array
   {
        $data = Yii::$app->request->get();
        $order_id = $data['order_id'];

        $info = ServicesOrderService::orderDetail($order_id);
        // 模板消息订阅列表
        $msg_template = TeaGlobalConfig::find()->where(['store_id' =>\Yii::$app->request->input('store_id',0)])->select(['order_create_template', 'order_end_template'])->asArray()->one();
        $info['msg_template'] = array_values($msg_template);

        return ResultHelper::json(200, '获取成功', $info);
    }

    /**
     * @SWG\Get(path="/diandi_tea/order/invoice",
     *    tags={"订单"},
     *    summary="申请开票",
     *     @SWG\Response(
     *         response = 200,
     *         description = "申请成功",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *    @SWG\Parameter(
     *     in="query",
     *     name="order_id",
     *     type="integer",
     *     description="订单id",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="invoice_url",
     *     type="integer",
     *     description="发票地址",
     *     required=true,
     *   ),
     * )
     */
    public function actionInvoice()
   {
        $order_id =\Yii::$app->request->input('order_id');
        if (empty($order_id)) {
            return ResultHelper::json(400, '缺少订单id');
        }
        $phone =\Yii::$app->request->input('phone');
        if (empty($phone)) {
            return ResultHelper::json(400, '缺少公司电话');
        }

        $company =\Yii::$app->request->input('company');
        if (empty($company)) {
            return ResultHelper::json(400, '缺少公司名称');
        }
        $email =\Yii::$app->request->input('email');
        if (empty($email)) {
            return ResultHelper::json(400, '缺少邮箱地址');
        }
        $type =\Yii::$app->request->input('type');
        if (empty($type)) {
            $type = 1;
        }

        $bank =\Yii::$app->request->input('bank');
        if (empty($bank)) {
            return ResultHelper::json(400, '缺少银行卡号');
        }
        $bank_address =\Yii::$app->request->input('bank_address');
        if (empty($bank_address)) {
            return ResultHelper::json(400, '缺少银行开户地址');
        }
        $company_address =\Yii::$app->request->input('company_address');
        if (empty($company_address)) {
            return ResultHelper::json(400, '缺少公司地址');
        }
        $taxpayer_no =\Yii::$app->request->input('taxpayer_no');
        if (empty($taxpayer_no)) {
            return ResultHelper::json(400, '纳税人识别号');
        }
        $member_id = Yii::$app->user->identity->member_id ?? 0;

        return ServicesOrderService::invoice($order_id, $phone, $company, $email, $member_id, $type, $bank, $bank_address, $company_address, $taxpayer_no);
    }

    public function actionInvoiceList(): array
    {
        $member_id = Yii::$app->user->identity->member_id ?? 0;
        $info = TeaInvoice::find()->where(['member_id' => $member_id])->asArray()->all();
        foreach ($info as &$value) {
            $value['invoice_url'] = unserialize($value['invoice_url']);
        }

        return ResultHelper::json(200, '获取成功！', $info);
    }

    public function actionOpenDoor(): array
   {
        $order_id =\Yii::$app->request->input('order_id');
        if (empty($order_id)) {
            return ResultHelper::json(400, '缺少订单id');
        }

        $order = TeaOrderList::find()->where(['id' => $order_id])->asArray()->one();
        if (empty($order['id'])) {
            return ResultHelper::json(401, '订单不存在');
        }

        $time = date('Y-m-d H:i:s');
        $where_time = [
            'and',
            ['<', 'start_time', $time],
            ['>', 'end_time', $time],
        ];
        $is_use = TeaOrderList::find()->where(['hourse_id' => $order['hourse_id'], 'status' => 2])->andWhere($where_time)->one();
        if ($is_use) {
            if ($is_use['id'] != $order_id) {
                return ResultHelper::json(401, '房间待客中，请稍后开启！');
            }
        }

        // 派遣器
        // $dispatcher = new DdDispatcher();
        // // 监听器
        // $listener = new DdListener();

        // $subscriber = new LockopenServer();
        // $dispatcher->addSubscriber($subscriber);
        $ext_room_id = $order['hourse_id'];
        $password = $order['pwd'];
        $member_id = $order['member_id'];
        $phoneNo = '1111';
        $keyName = '姓名';
        $ext_order_id = $order['id'];
        $lock_type = (int)Yii::$app->request->input('lock_type');
        // $event = new LockopenEvent($ext_order_id, $member_id, $ext_room_id, $password, $phoneNo, $keyName, $lock_type);

        $diandiLockSdk = new diandiLockSdk();
        $Res = $diandiLockSdk->LockOpen($ext_room_id, $password, $phoneNo, $keyName, $lock_type, $member_id, $ext_order_id);
        loggingHelper::writeLog('diandi_tea', 'OpenDoor', '房间开锁', [$ext_room_id, $password, $member_id, $phoneNo, $keyName]);

        // $Res = $dispatcher->dispatch(LockopenEvent::EVENT_LOCK_NAME, $event);
        if ($Res['is_auth']) {
            return ResultHelper::json(200, '开锁成功！', $Res);
        } else {
            return ResultHelper::json(400, '开锁失败！', $Res);
        }
    }

    public function actionGetHourse(): array
   {
        $coupon_id =\Yii::$app->request->input('coupon_id');
        $use_hourse = TeaCoupon::find()->where(['id' => $coupon_id])->select('use_hourse')->scalar();
        if ($use_hourse) {
            $use_hourse = explode(',', $use_hourse);
            foreach ($use_hourse as &$v) {
                $v = (int)$v;
            }
        } else {
            $use_hourse = [];
        }

        return ResultHelper::json(200, '获取成功', ['use_hourse' => $use_hourse]);
    }

    public function actionRefund(): array
   {
        $order_id =\Yii::$app->request->input('order_id');
        $Res = ServicesOrderService::Refund($order_id);
        if ($Res['status']) {
            return ResultHelper::json(400, $Res['message']);
        }

        return ResultHelper::json(200, '退款成功', $Res);
    }

    public function actionMeituan(): array
   {

        $hourse_id =\Yii::$app->request->input('hourse_id');

        $coupon_id =\Yii::$app->request->input('coupon_id');

        $Res = ServicesOrderService::MeiTuanOrder($hourse_id, $coupon_id);

        return ResultHelper::json(200, '获取成功', $Res);
    }

    public function actionInfo(): array
    {
        $list = TeaHourse::find()->with(['order'])->asArray()->all();
        foreach ($list as $key => &$value) {
            $value['disabled'] = !($key === 0);
        }

        return ResultHelper::json(200, '获取成功', $list);
    }
}
