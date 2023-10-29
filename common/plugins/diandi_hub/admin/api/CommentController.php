<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-11 04:08:14
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 17:04:36
 */

namespace common\plugins\diandi_hub\admin\api;

use common\plugins\diandi_hub\models\comment\HubShopComment;
use common\plugins\diandi_hub\models\enums\CommentType;
use common\plugins\diandi_hub\models\enums\OrderStatus;
use common\plugins\diandi_hub\models\order\HubOrder;
use common\plugins\diandi_hub\services\CommentService;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use Yii;

/**
 * Comment controller for the `DiandiShop` module.
 */
class CommentController extends AController
{
    public $modelClass = '\common\models\DdGoods';
    protected array $authOptional = ['info', 'list'];

    public int $searchLevel = 0;

    /**
     * @SWG\Post(path="/diandi_hub/comment/comment",
     *     tags={"商家"},
     *     summary="商家评论",
     *     @SWG\Response(
     *         response = 200,
     *         description = "提交商家评论",
     *     ),
     *     @SWG\Parameter(
     *          in="query",
     *          name="access-token",
     *          type="string",
     *          description="用户秘钥",
     *          required=true,
     *   ),
     *   @SWG\Parameter(
     *          in="formData",
     *          name="comment",
     *          type="string",
     *          description="评论内容",
     *          required=true,
     *   ),
     *   @SWG\Parameter(
     *          in="query",
     *          name="order_id",
     *          type="integer",
     *          description="订单id",
     *          required=true,
     *   ),
     *   @SWG\Parameter(
     *          in="formData",
     *          name="star_level",
     *          type="integer",
     *          description="评论星级",
     *          required=false,
     *   ),
     *   @SWG\Parameter(
     *          in="formData",
     *          name="images",
     *          type="string",
     *          description="评论图片，多图用逗号隔开",
     *          required=false,
     *   )
     * )
     */
    public function actionComment()
    {
        global $_GPC;

        $data = [];

        $data['type'] = $_GPC['type'];

        $DdShopComment = new  HubShopComment();

        $data['comment_id'] = $_GPC['comment_id'];

        if ($data['type'] == CommentType::getValueByName('订单评价')) {
            $order_id = $data['comment_id'];
            $orders = HubOrder::findOne(['order_id' => $order_id]);
            if (!$orders) {
                return ResultHelper::json(401, '订单不存在', []);
            }
            $ordersCom = HubOrder::findOne(['order_id' => $order_id, 'receipt_status' => 1]);
            if (empty($ordersCom)) {
                return ResultHelper::json(401, '请先确认收货', []);
            }
        }

        $data['star_level'] = $_GPC['star_level'];
        $data['comment'] = $_GPC['comment'];

        $data['user_id'] = Yii::$app->user->identity->user_id;

        $data['images'] = serialize(explode(',', $_GPC['images']));

        if ($DdShopComment->load($data, '') && $DdShopComment->save()) {
            $id = Yii::$app->db->getLastInsertID();
            HubOrder::updateAll(['order_status' => OrderStatus::getValueByName('已完成')], ['order_id' => $order_id]);

            return ResultHelper::json(200, '评论成功', ['comment_id' => $id]);
        } else {
            $error = ErrorsHelper::getModelError($DdShopComment);

            return ResultHelper::json(200, $error, []);
        }
    }

    /**
     * @SWG\Get(path="/diandi_hub/comment/list",
     *     tags={"商家"},
     *     summary="获取商家评论",
     *     @SWG\Response(
     *         response = 200,
     *         description = "获取商家评论",
     *     ),
     *   @SWG\Parameter(
     *          in="query",
     *          name="page",
     *          type="string",
     *          description="页码",
     *          required=true,
     *   ),
     *   @SWG\Parameter(
     *          in="query",
     *          name="pageSize",
     *          type="integer",
     *          description="每页显示数量",
     *          required=false,
     *   )
     * )
     */
    public function actionList()
    {
        $pageSize = Yii::$app->request->get('pageSize');
        $list = CommentService::list($pageSize);

        return ResultHelper::json(200, '获取成功', $list);
    }
}
