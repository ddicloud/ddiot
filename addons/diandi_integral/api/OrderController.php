<?php

/**
 * @Author: Wang chunsheng
 * @Date:   2020-04-29 11:18:15
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-06-16 17:44:58
 */

namespace addons\diandi_integral\api;

use addons\diandi_integral\services\GoodsService;
use addons\diandi_integral\services\OrderService;
use api\controllers\AController;
use common\helpers\ResultHelper;
use Throwable;
use Yii;

class OrderController extends AController
{
    public $modelClass = '\common\models\IntegralGoods';


    /**
     * 直接购买
     * @return array|object[]|string[]
     * @throws Throwable
     */
    public function actionCreategoodsorder(): array
   {
        $total_price = Yii::$app->request->input('total_price') ?? null;
        $express_price = Yii::$app->request->input('express_price') ?? null;
        $express_type = Yii::$app->request->input('express_type') ?? null;
        $order_type = Yii::$app->request->input('order_type') ?? null;
        $remark = Yii::$app->request->input('remark') ?? null;
        $isMoney = Yii::$app->request->input('is_money',0);
        $delivery_time = Yii::$app->request->input('delivery_time') ?? null;
        $name = Yii::$app->request->input('name') ?? null;
        $phone = Yii::$app->request->input('phone') ?? null;
        $address_id = Yii::$app->request->input('address_id') ?? 0;
        $goods_id = Yii::$app->request->input('goods_id') ?? 0;
        $goods_num = Yii::$app->request->input('goods_num') ?? 0;
        $spec_id = Yii::$app->request->input('spec_id') ?? 0;

        if (Yii::$app->request->input('express_type') == 1) {
            if (empty(Yii::$app->request->input('address_id')) || Yii::$app->request->input('address_id') == 'undefined') {
                return ResultHelper::json(401, '请选择自提点', []);
            }
            if (empty(Yii::$app->request->input('name'))) {
                return ResultHelper::json(401, '请输入收货人姓名', []);
            }
            if (empty(Yii::$app->request->input('phone'))) {
                return ResultHelper::json(401, '请输入收货人手机号', []);
            }

            // if (empty($data['detail'])) {
            //   return ResultHelper::json(401, '请输入收货详细地址具体到楼层房间号', []);
            // }
        } else {
            if (empty(Yii::$app->request->input('address_id')) || Yii::$app->request->input('address_id') == 'undefined') {
                return ResultHelper::json(401, '请选择收货地址', []);
            }
        }

        if (empty(Yii::$app->request->input('goods_id'))) {
            return ResultHelper::json(401, '请选择商品下单', []);
        }
        $user_id = Yii::$app->user->identity->member_id ?? 0;

//        $user_integral = DdMemberAccount::find()->where(['member_id' => $user_id])->select(['user_integral'])->asArray()->one();
//
//
//        $goods = json_decode(Yii::$app->request->input('goods'), true);

        $orderInfo = OrderService::creategoodsorder($user_id, $goods_id, $goods_num, $total_price, $express_price, $express_type, $address_id, $remark, $name, $phone, $delivery_time, $spec_id, $order_type, $isMoney);

        return ResultHelper::json(200, '创建订单成功', $orderInfo);
    }


    public function actionConfirm(): array
    {
        $order_id = Yii::$app->request->post('order_id');
        $ctype = Yii::$app->request->post('ctype');

        return OrderService::confirmOrder($order_id, $ctype);
    }


    public function actionList(): array
    {
        $user_id = Yii::$app->user->identity->member_id ?? 0;
        $pageSize = Yii::$app->request->post('pageSize');
        $order_status = Yii::$app->request->post('order_status');
        $order_status = $order_status == -1 ? '' : $order_status;
        $list = OrderService::list($user_id, $order_status, $pageSize);

        return ResultHelper::json(200, '获取成功', [
            'list' => $list,
        ]);
    }


    public function actionDetail(): array
    {
        $order_id = Yii::$app->request->post('order_id');
        $user_id = Yii::$app->user->identity->member_id ?? 0;
        $res = OrderService::detail($order_id);

        return ResultHelper::json(200, '获取成功', $res);
    }


    public function actionOrderdetail(): array
   {
        $num = Yii::$app->request->input('goods_number');
        $spec_id = Yii::$app->request->input('spec_id');
        $goods_type = Yii::$app->request->input('goods_type');
        $order_type = Yii::$app->request->input('order_type');
        $region_id = Yii::$app->request->input('region_id');
        $goods_id = Yii::$app->request->get('goods_id');
        $express_type = Yii::$app->request->input('express_type');
        $member_id = Yii::$app->user->identity->member_id ?? 0;

        $goods = GoodsService::getOrderDetail($goods_id, $num, $spec_id, $express_type, $region_id);

        return ResultHelper::json(200, '获取成功', $goods);
    }

    public function actionExchange(): array
   {
        $order_id = Yii::$app->request->input('order_id');
        $total_fee = Yii::$app->request->input('total_fee');

        $Res = OrderService::exchangeCredit($order_id, $total_fee);

        return ResultHelper::json(200, '兑换成功', $Res);
    }

    /**
     * @SWG\Get(path="/diandi_integral/order/exchangelist",
     *     tags={"积分兑换"},
     *     summary="兑换明细",
     *     @SWG\Response(
     *          response = 200,
     *          description = "兑换明细",
     *     ),
     * )
     */
    public function actionExchangelist()
    {
        $member_id = Yii::$app->user->identity->member_id ?? 0;
        $info = OrderService::exchangelist($member_id);

        return ResultHelper::json(200, '获取成功', $info);
    }

    /**
     * @SWG\Post(path="/diandi_integral/order/delivery",
     *     tags={"订单"},
     *     summary="确认收货.",
     *     @SWG\Response(
     *         response = 200,
     *         description = "首页",
     *     ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="access-token",
     *     type="string",
     *     description="用户秘钥",
     *     required=true,
     *   ),
     * )
     */
    public function actionDelivery()
    {
    }

    /**
     * @SWG\Post(path="/diandi_integral/order/logistics",
     *     tags={"订单"},
     *     summary="物流跟踪.",
     *     @SWG\Response(
     *         response = 200,
     *         description = "首页",
     *     ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="access-token",
     *     type="string",
     *     description="用户秘钥",
     *     required=true,
     *   ),
     * )
     */
    public function actionLogistics()
    {
    }

    /**
     * @SWG\Post(path="/diandi_integral/order/comment",
     *     tags={"订单"},
     *     summary="评价商品.",
     *     @SWG\Response(
     *         response = 200,
     *         description = "首页",
     *     ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="access-token",
     *     type="string",
     *     description="用户秘钥",
     *     required=true,
     *   ),
     * )
     */
    public function actionComment()
    {
    }
}
