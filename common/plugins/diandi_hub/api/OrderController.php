<?php

/**
 * @Author: Wang chunsheng
 * @Date:   2020-04-29 11:18:15
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-07-21 15:41:20
 */

namespace common\plugins\diandi_hub\api;

use common\plugins\diandi_hub\services\events\DdOrderEvent;
use common\plugins\diandi_hub\models\config\HubConfig;
use common\plugins\diandi_hub\models\enums\ExpressTypeStatus;
use common\plugins\diandi_hub\models\member\HubMemberLevel;
use common\plugins\diandi_hub\services\GoodsService;
use common\plugins\diandi_hub\services\KdApiService;
use common\plugins\diandi_hub\services\OrderService;
use common\plugins\diandi_hub\services\OrderService as ServicesOrderService;
use common\components\events\DdDispatcher;
use api\controllers\AController;
use common\helpers\ResultHelper;
use Yii;

class OrderController extends AController
{
    public $modelClass = '\common\models\DdGoods';

    public function actionSearch()
    {
        return [
            'error_code' => 20,
            'res_msg' => 'ok',
        ];
    }

    /**
     * @SWG\Post(path="/diandi_hub/order/createorder",
     *     tags={"订单"},
     *     summary="购物车购买.",
     *     @SWG\Response(
     *         response = 200,
     *         description = "首页",
     *     ),
     *     @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *     ),
     *     @SWG\Parameter(
     *          in="formData",
     *          name="goods",
     *          type="string",
     *          description="商品数据",
     *          required=true,
     *   ),
     *     @SWG\Parameter(
     *          in="formData",
     *          name="total_price",
     *          type="integer",
     *          description="订单总额",
     *          required=true,
     *   ),
     *     @SWG\Parameter(
     *          in="formData",
     *          name="express_price",
     *          type="integer",
     *          description="运费",
     *          required=true,
     *   ),
     *     @SWG\Parameter(
     *          in="formData",
     *          name="express_type",
     *          type="integer",
     *          enum={0,1},
     *          description="收货方式0配送点配送1收货地址收货",
     *          required=true,
     *   ),
     *     @SWG\Parameter(
     *          in="formData",
     *          name="address_id",
     *          type="integer",
     *          description="配送区域id",
     *          required=true,
     *   ),

     *     @SWG\Parameter(
     *          in="formData",
     *          name="name",
     *          type="string",
     *          description="收货人",
     *          required=false,
     *   ),
     *   @SWG\Parameter(
     *          in="formData",
     *          name="phone",
     *          type="integer",
     *          description="手机号",
     *          required=true,
     *   ),
     *   @SWG\Parameter(
     *          in="formData",
     *          name="detail",
     *          type="string",
     *          description="详细的收货地址",
     *          required=true,
     *   ),
     *   @SWG\Parameter(
     *          in="formData",
     *          name="remark",
     *          type="string",
     *          description="订单备注",
     *          required=true,
     *   ),
     *   @SWG\Parameter(
     *          in="formData",
     *          name="delivery_time",
     *          type="string",
     *          description="配送时间",
     *          required=true,
     *   ),
     * )
     */
    public function actionCreateorder()
   {
        $data = Yii::$app->request->post();
        $total_price =\Yii::$app->request->input('total_price');
        $express_price =\Yii::$app->request->input('express_price');
        $express_type =\Yii::$app->request->input('express_type');
        $remark =\Yii::$app->request->input('remark');

        $name = '';
        $phone = 0;
        $detail = '';
        $delivery_time =\Yii::$app->request->input('delivery_time');

        $name =\Yii::$app->request->input('name');
        $phone =\Yii::$app->request->input('phone');

        if (Yii::$app->request->input('express_type') == ExpressTypeStatus::getValueByName('到店自提')) {
            // if (empty($data['address_id']) || $data['address_id'] == 'undefined') {
            //     return ResultHelper::json(401, '请选择自提点', []);
            // }
            // if (empty($data['name'])) {
            //     return ResultHelper::json(401, '请输入收货人姓名', []);
            // }
            // if (empty($data['phone'])) {
            //     return ResultHelper::json(401, '请输入收货人手机号', []);
            // }

            // if (empty($data['detail'])) {
            //   return ResultHelper::json(401, '请输入收货详细地址具体到楼层房间号', []);
            // }
        } else {
            $address_id = intval($data['address_id']);

            if (empty($address_id)) {
                return ResultHelper::json(401, '请选择收货地址', []);
            }
        }

        $address_id = $data['address_id'];

        $user_id = Yii::$app->user->identity->member_id??0;
        $cartIds = json_decode(Yii::$app->request->input('cart_ids'), true);

        $extend = [];
        // $dispatcher = new DdDispatcher();
        // $subscriber = new OrderService();
        // $dispatcher->addSubscriber($subscriber);
        $event = new DdOrderEvent($user_id, $cartIds,\Yii::$app->request->input('total_price'),\Yii::$app->request->input('express_price'),\Yii::$app->request->input('express_type'),\Yii::$app->request->input('address_id'),\Yii::$app->request->input('remark'),\Yii::$app->request->input('name'),\Yii::$app->request->input('phone'),\Yii::$app->request->input('delivery_time'), $extend);
        // $Res = $dispatcher->dispatch(DdOrderEvent::EVENT_ORDER_CREATE, $event);
        // $orderInfo = ServicesOrderService::createOrder($user_id, $cartIds, $total_price, $express_price, $express_type, $address_id, $remark, $name, $phone, $delivery_time);
        $orderInfo = ServicesOrderService::createOrder($event);

        return ResultHelper::json(200, '创建订单成功', $orderInfo);
    }

    // 直接购买

    /**
     * @SWG\Post(path="/diandi_hub/order/creategoodsorder",
     *     tags={"订单"},
     *     summary="立即购买.",
     *     @SWG\Response(
     *         response = 200,
     *         description = "首页",
     *     ),
     *     @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *     ),
     *     @SWG\Parameter(
     *          in="formData",
     *          name="goods_id",
     *          type="string",
     *          description="商品数据",
     *          required=true,
     *   ),
     *     @SWG\Parameter(
     *          in="formData",
     *          name="total_price",
     *          type="integer",
     *          description="订单总额",
     *          required=true,
     *   ),
     *     @SWG\Parameter(
     *          in="formData",
     *          name="express_price",
     *          type="integer",
     *          description="运费",
     *          required=true,
     *   ),
     *     @SWG\Parameter(
     *          in="formData",
     *          name="express_type",
     *          type="integer",
     *          enum={0,1},
     *          description="收货方式0配送点配送1收货地址收货",
     *          required=true,
     *   ),
     *     @SWG\Parameter(
     *          in="formData",
     *          name="address_id",
     *          type="integer",
     *          description="配送区域id",
     *          required=true,
     *   ),

     *     @SWG\Parameter(
     *          in="formData",
     *          name="name",
     *          type="string",
     *          description="收货人",
     *          required=false,
     *   ),
     *   @SWG\Parameter(
     *          in="formData",
     *          name="phone",
     *          type="integer",
     *          description="手机号",
     *          required=true,
     *   ),
     *   @SWG\Parameter(
     *          in="formData",
     *          name="detail",
     *          type="string",
     *          description="详细的收货地址",
     *          required=true,
     *   ),
     *   @SWG\Parameter(
     *          in="formData",
     *          name="remark",
     *          type="string",
     *          description="订单备注",
     *          required=true,
     *   ),
     *   @SWG\Parameter(
     *          in="formData",
     *          name="delivery_time",
     *          type="string",
     *          description="配送时间",
     *          required=true,
     *   ),
     *   @SWG\Parameter(
     *          in="formData",
     *          name="spec_id",
     *          type="integer",
     *          description="规格id",
     *          required=true,
     *   ),
     *   @SWG\Parameter(
     *          in="formData",
     *          name="goods_number",
     *          type="integer",
     *          description="商品数量",
     *          required=true,
     *   ),
     * )
     */
    public function actionCreategoodsorder()
   {
        $total_price =\Yii::$app->request->input('total_price');
        $express_price =\Yii::$app->request->input('express_price');
        $express_type = intval(Yii::$app->request->input('express_type'));
        $remark = trim(Yii::$app->request->input('remark'));
        $goods_type = intval(Yii::$app->request->input('goods_type'));

        $name = '';
        $phone = 0;
        $detail = '';
        $delivery_time =\Yii::$app->request->input('delivery_time');

        $name =\Yii::$app->request->input('name');
        $phone =\Yii::$app->request->input('phone');

        if (Yii::$app->request->input('express_type') == ExpressTypeStatus::getValueByName('到店自提')) {
            // if (empty(Yii::$app->request->input('address_id')) ||\Yii::$app->request->input('address_id') == 'undefined') {
            //     return ResultHelper::json(401, '请选择自提点', []);
            // }
            // if (empty(Yii::$app->request->input('name'))) {
            //     return ResultHelper::json(401, '请输入收货人姓名', []);
            // }
            // if (empty(Yii::$app->request->input('phone'))) {
            //     return ResultHelper::json(401, '请输入收货人手机号', []);
            // }

            // if (empty($data['detail'])) {
            //   return ResultHelper::json(401, '请输入收货详细地址具体到楼层房间号', []);
            // }
        } else {
            $address_id = intval(Yii::$app->request->input('address_id'));

            if (empty($address_id)) {
                return ResultHelper::json(401, '请选择收货地址', []);
            }
        }

        $address_id =\Yii::$app->request->input('address_id');
        $goods_id =\Yii::$app->request->input('goods_id');
        $goods_num =\Yii::$app->request->input('goods_num');
        $spec_id =\Yii::$app->request->input('spec_id');

        $user_id = Yii::$app->user->identity->member_id??0;
        $goods = json_decode(Yii::$app->request->input('goods'), true);

        $orderInfo = ServicesOrderService::creategoodsorder($user_id, $goods_id, $goods_num, $total_price, $express_price, $express_type, $address_id, $remark, $name, $phone, $delivery_time, $spec_id, $goods_type);

        return ResultHelper::json(200, '创建订单成功', $orderInfo);
    }

    /**
     * @SWG\Post(path="/diandi_hub/order/confirm",
     *     tags={"订单"},
     *     summary="订单操作",
     *     @SWG\Response(
     *         response = 200,
     *         description = "订单操作",
     *     ),
     *     @SWG\Parameter(
     *        in="formData",
     *        name="order_id",
     *        type="integer",
     *        description="订单id",
     *        required=true,
     *   ),
     *     @SWG\Parameter(
     *        in="formData",
     *        name="ctype",
     *        type="string",
     *        description="操作类型",
     *        enum={"qxdd","qrfh","qrsh","scdd"},
     *        required=true,
     *   ),
     *     @SWG\Parameter(
     *        in="query",
     *        name="access-token",
     *        type="string",
     *        description="用户秘钥",
     *        required=true,
     *   ),
     * )
     */
    public function actionConfirm()
    {
        $order_id = Yii::$app->request->post('order_id');
        $ctype = Yii::$app->request->post('ctype');

        return OrderService::confirmOrder($order_id, $ctype);
    }

    /**
     * @SWG\Post(path="/diandi_hub/order/list",
     *     tags={"订单"},
     *     summary="订单列表.",
     *     @SWG\Response(
     *         response = 200,
     *         description = "首页",
     *     ),
     *     @SWG\Parameter(
     *        in="query",
     *        name="access-token",
     *        type="string",
     *        description="用户秘钥",
     *        required=true,
     *   ),
     *     @SWG\Parameter(
     *        in="formData",
     *        name="order_status",
     *        type="integer",
     *        description="订单状态,全部不传递参数，具体的传递参数",
     *        required=false,
     *   ),
     *     @SWG\Parameter(
     *        in="query",
     *        name="page",
     *        type="integer",
     *        description="页码",
     *        required=true,
     *   ),
     *   @SWG\Parameter(
     *        in="formData",
     *        name="pageSize",
     *        type="integer",
     *        description="显示数量",
     *        required=true,
     *   ),

     * )
     */
    public function actionList()
    {
        $user_id = Yii::$app->user->identity->member_id??0;
        $pageSize = Yii::$app->request->post('pageSize');
        $order_status = Yii::$app->request->post('order_status');
        $order_status = $order_status == -1 ? '' : $order_status;
        $list = OrderService::list($user_id, $order_status, $pageSize);

        return ResultHelper::json(200, '获取成功', $list);
    }

    /**
     * @SWG\Post(path="/diandi_hub/order/detail",
     *     tags={"订单"},
     *     summary="订单详情.",
     *     @SWG\Response(
     *         response = 200,
     *         description = "订单详情",
     *     ),
     *     @SWG\Parameter(
     *        in="query",
     *        name="access-token",
     *        type="string",
     *        description="用户秘钥",
     *        required=true,
     *   ),
     *     @SWG\Parameter(
     *        in="formData",
     *        name="order_id",
     *        type="integer",
     *        description="订单ID",
     *        required=true,
     *   ),
     * )
     */
    public function actionDetail()
    {
        $order_id = Yii::$app->request->post('order_id');
        $user_id = Yii::$app->user->identity->member_id??0;
        $res = OrderService::detail($order_id);

        return ResultHelper::json(200, '获取成功', $res);
    }

    /**
     * @SWG\Post(path="/diandi_hub/order/delivery",
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
     * @SWG\Post(path="/diandi_hub/order/logistics",
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
     * @SWG\Get(path="/diandi_hub/goods/orderdetail",
     *     tags={"商品"},
     *     summary="商品详情",
     *     @SWG\Response(
     *         response = 200,
     *         description = "商品详情",
     *     ),
     *     @SWG\Parameter(
     *        in="query",
     *        name="access-token",
     *        type="string",
     *        description="用户秘钥",
     *        required=true,
     *   ),
     *     @SWG\Parameter(
     *            in="query",
     *            name="goods_id",
     *            type="integer",
     *            description="商品id",
     *            required=true,
     *   ),
     *   @SWG\Parameter(
     *            in="query",
     *            name="goods_number",
     *            type="integer",
     *            description="商品数量",
     *            required=true,
     *   ),
     *   @SWG\Parameter(
     *            in="query",
     *            name="spec_id",
     *            type="integer",
     *            description="商品属性id组合",
     *            required=true,
     *   ),
     * )
     */
    public function actionOrderdetail()
   {
        $num =\Yii::$app->request->input('goods_number');
        $spec_id =\Yii::$app->request->input('spec_id');
        $goods_type =\Yii::$app->request->input('goods_type');
        $order_type =\Yii::$app->request->input('order_type');
        $region_id =\Yii::$app->request->input('region_id');
        $goods_id =\Yii::$app->request->input('goods_id');
        $express_type =\Yii::$app->request->input('express_type');
        $express_id =\Yii::$app->request->input('express_id');
        $member_id = Yii::$app->user->identity->member_id??0;
        $ishave = HubMemberLevel::findOne(['member_id' => $member_id]);

        $goods = GoodsService::getOrderDetail($goods_id, $num, $spec_id, $goods_type, $order_type, $region_id, $express_type, $express_id);

        return ResultHelper::json(200, '获取成功', $goods);
    }

    public function actionIntegralpay()
   {
        $order_id =\Yii::$app->request->input('order_id');
        $Res = OrderService::integralPay($order_id);
        if ($Res['status'] == 0) {
            return ResultHelper::json(200, $Res['msg'], $Res);
        } else {
            return ResultHelper::json(400, $Res['msg'], $Res);
        }
    }

    /**
     * @SWG\Post(path="/diandi_hub/order/comment",
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

    public function actionGetexpress()
   {

        $order_no = trim(Yii::$app->request->input('order_no'));

        $member_id = Yii::$app->user->identity->member_id??0;

        $Res = KdApiService::list($member_id, $order_no);
        if ($Res['status'] == 0) {
            return ResultHelper::json(200, '查询成功', $Res);
        } else {
            return ResultHelper::json(400, $Res['msg']);
        }
    }

    // 物流信息推送
    public function actionKdinform()
   {

        $RequestDatas =\Yii::$app->request->input('RequestData');

        $RequestData = json_decode($RequestDatas, true);

        KdApiService::saveKdninfo($RequestData);

        $conf = HubConfig::findOne(1);

        $Res = [
            'EBusinessID' => $conf['kd_id'],
            'UpdateTime' => date('YYYY-MM-DD HH24:MM:SS', time()),
            'Success' => true,
            'Reason' => '',
        ];

        return $Res;
    }

    public function actionDeletebytime()
   {

        OrderService::DeleteByTime();
        OrderService::autoReceive();

        return ResultHelper::json(200, '删除成功');
    }
}
