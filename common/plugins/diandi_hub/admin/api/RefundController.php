<?php

/**
 * @Author: Wang chunsheng
 * @Date:   2020-04-29 11:18:15
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 17:05:10
 */

namespace common\plugins\diandi_hub\admin\api;

use common\plugins\diandi_hub\models\enums\RefundType;
use common\plugins\diandi_hub\services\AftersaleService;
use admin\controllers\AController;
use common\helpers\ResultHelper;
use Yii;

class RefundController extends AController
{
    public $modelClass = 'common\addons\diandi_hub\models\order\HubRefundOrder';

    public int $searchLevel = 0;

    public function actionInfo():array
    {
        global $_GPC;

        $list = AftersaleService::getRefundInfo();

        return ResultHelper::json(200, '获取成功', $list);
    }

    public function actionAdd():array
    {
        global $_GPC;

        $order_id =\Yii::$app->request->input('order_id');

        if (empty($order_id)) {
            return ResultHelper::json(400, '订单id不能为空', []);
        }

        $reason_id =\Yii::$app->request->input('reason_id');

        if (empty($reason_id)) {
            return ResultHelper::json(400, '退款原因不能为空', []);
        }

        $type = intval(Yii::$app->request->input('type'));
        $goods_id = intval(Yii::$app->request->input('goods_id'));
        $money = floatval(Yii::$app->request->input('money'));
        if ($type != RefundType::getValueByName('换货')) {
            if (empty($money)) {
                return ResultHelper::json(400, '必须输入退款金额', []);
            }
        } else {
            if (empty($goods_id)) {
                return ResultHelper::json(400, '换货必须选择商品', []);
            }
        }

        $thumbs =\Yii::$app->request->input('thumbs');

        if (empty($thumbs)) {
            return ResultHelper::json(400, '至少拍照一张图片', []);
        }

        $remark = trim(Yii::$app->request->input('remark'));

        if (empty($remark)) {
            return ResultHelper::json(400, '请输入售后说明', []);
        }

        $linkman =\Yii::$app->request->input('linkman');
        if (empty($linkman)) {
            return ResultHelper::json(400, '请输入联系人', []);
        }

        $mobile =\Yii::$app->request->input('mobile');
        if (empty($remark)) {
            return ResultHelper::json(400, '请输入联系电话', []);
        }

        $member_id = Yii::$app->user->identity->user_id;

        $Res = AftersaleService::addAfterService($order_id, $reason_id, $money, $type, $remark, $member_id, $thumbs, $linkman, $mobile, $goods_id);

        if ($Res['status'] == 1) {
            return ResultHelper::json(200, '申请售后成功', []);
        } else {
            return ResultHelper::json(400, $Res['msg']);
        }
    }

    public function actionList():array
    {
        $user_id = Yii::$app->user->identity->user_id;
        $pageSize = Yii::$app->request->post('pageSize');
        $order_status = Yii::$app->request->post('order_status');
        $order_status = $order_status == -1 ? '' : $order_status;
        $list = AftersaleService::list($user_id, $order_status, $pageSize);

        return ResultHelper::json(200, '获取成功', $list);
    }

    public function actionDetail():array
    {
        global $_GPC;
        $user_id = Yii::$app->user->identity->user_id;
        $order_id =\Yii::$app->request->input('order_id');
        $detail = AftersaleService::detail($order_id);

        return ResultHelper::json(200, '获取成功', $detail);
    }

    /**
     * @SWG\Post(path="/diandi_hub/refund/cancel",
     *    tags={"订单售后"},
     *    summary="取消订单售后 - 只能取消：申请中 与 驳回",
     *    @SWG\Response(response = 200, description = "房屋列表"),
     *    @SWG\Parameter(ref="#/parameters/access-token"),
     *    @SWG\Parameter(ref="#/parameters/bloc-id"),
     *    @SWG\Parameter(ref="#/parameters/store-id"),
     *    @SWG\Parameter(in="path", name="refund_id", type="integer", description="售后ID", required=false),
     * )
     */
    public function actionCancel():array
    {
        global $_GPC;
        $userId = Yii::$app->user->identity->user_id;
        $refundId =\Yii::$app->request->input('refund_id');
        $detail = AftersaleService::cancelRefund($userId, $refundId);
        if ($detail === true) {
            return ResultHelper::json(200, '取消成功', $detail);
        } else {
            return ResultHelper::json(400, $detail);
        }
    }
}
