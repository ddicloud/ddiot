<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-14 10:56:16
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-09 17:01:06
 */

namespace addons\diandi_tea\api;

use addons\diandi_tea\services\BalanceService;
use api\controllers\AController;
use common\helpers\ResultHelper;
use Yii;

class BalanceController extends AController
{
    public $modelClass = '';

    /**
     * @SWG\Post(path="/diandi_tea/balance/orderbalancepay",
     *    tags={"余额支付"},
     *    summary="包间下单",
     *     @SWG\Response(
     *         response = 200,
     *         description = "包间套餐列表",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="order_number",
     *     type="string",
     *     description="订单编号",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="real_pay",
     *     type="string",
     *     description="实际支付金额",
     *     required=false,
     *   ),
     * )
     */
    public function actionOrderBalancePay()
   {

        $data = \Yii::$app->request->input();
        $member_id = Yii::$app->user->identity->member_id??0;
        $order_number = $data['order_number'];
        if (empty($order_number)) {
            return ResultHelper::json(401, '缺少订单编号');
        }
        $real_pay = $data['real_pay'];
        if (empty($real_pay)) {
            return ResultHelper::json(401, '缺少支付金额');
        }

        try {
            return BalanceService::orderBalancePay($member_id, $order_number, $real_pay);

        } catch (\Throwable $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        }

    }

    /**
     * @SWG\Post(path="/diandi_tea/balance/couponbalancepay",
     *    tags={"余额支付"},
     *    summary="卡券购买",
     *     @SWG\Response(
     *         response = 200,
     *         description = "卡券购买",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="order_number",
     *     type="string",
     *     description="订单编号",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="price",
     *     type="string",
     *     description="支付金额",
     *     required=false,
     *   ),
     * )
     */
    public static function actionCouponBalancePay()
   {

        $data = \Yii::$app->request->input();
        $member_id = Yii::$app->user->identity->member_id??0;

        if ($data['order_number'] && $data['price']) {
            $order_number = $data['order_number'];
            $price = $data['price'];
        } else {
            return ResultHelper::json(401, '缺少参数');
        }

        try {
            return BalanceService::couponBalancePay($member_id, $price, $order_number);
        } catch (\Throwable $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        }
    }
}
