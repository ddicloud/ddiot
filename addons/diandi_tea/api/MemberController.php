<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-14 10:56:16
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-27 10:16:25
 */

namespace addons\diandi_tea\api;

use addons\diandi_tea\services\MemberService;
use api\controllers\AController;
use common\helpers\ResultHelper;
use Yii;

class MemberController extends AController
{
    public $modelClass = '';

    // protected $signOptional = ['Integral'];

    /**
     * @SWG\Post(path="/diandi_tea/member/info",
     *    tags={"个人中心"},
     *    summary="个人信息",
     *     @SWG\Response(
     *         response = 200,
     *         description = "个人信息",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     * )
     */
    public function actionInfo(): array
   {
        $member_id = Yii::$app->user->identity->member_id??0;
        $pageSize = Yii::$app->request->input('pageSize',10);
        $page = Yii::$app->request->input('page',1);
        $info = MemberService::info($member_id, $pageSize, $page);

        return ResultHelper::json(200, '请求成功', $info);
    }

    /**
     * @SWG\Post(path="/diandi_tea/member/integral",
     *    tags={"个人中心"},
     *    summary="我的积分（积分明细,兑换记录）",
     *     @SWG\Response(
     *         response = 200,
     *         description = "我的积分",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     * )
     */
    public function actionIntegral(): array
    {
        $member_id = Yii::$app->user->identity->member_id??0;
        $info = MemberService::integral($member_id);

        return ResultHelper::json(200, '请求成功', $info);
    }

    /**
     * @SWG\Post(path="/diandi_tea/member/balance",
     *    tags={"个人中心"},
     *    summary="我的余额（充值记录，消费记录）",
     *     @SWG\Response(
     *         response = 200,
     *         description = "我的余额",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     * )
     */
    public function actionBalance(): array
    {
        $member_id = Yii::$app->user->identity->member_id??0;

        $info = MemberService::balance($member_id);

        return ResultHelper::json(200, '请求成功', $info);
    }

    /**
     * @SWG\Post(path="/diandi_tea/member/order",
     *    tags={"个人中心"},
     *    summary="我的订单",
     *     @SWG\Response(
     *         response = 200,
     *         description = "我的订单/预定",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="type",
     *     type="integer",
     *     description="传1为我的预定不传为我的订单",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="status",
     *     type="integer",
     *     description="订单状态：1.待付款 2.支付成功 3.已完成 4.已取消",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="order_type",
     *     type="integer",
     *     description="订单类型：1.包间订单 2.续费订单",
     *     required=false,
     *   ),

     * )
     */
    public function actionOrder(): array
   {

        $member_id = Yii::$app->user->identity->member_id??0;

        $data = Yii::$app->request->post();
        $pageSize = $data['pageSize']??10;
        $page = $data['page']??1;
        $info = MemberService::order($member_id, $pageSize, $page, $data);

        return ResultHelper::json(200, '请求成功', $info);
    }

    /**
     * @SWG\Post(path="/diandi_tea/member/editmember",
     *    tags={"个人中心"},
     *    summary="修改个人信息",
     *     @SWG\Response(
     *         response = 200,
     *         description = "修改个人信息",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="username",
     *     type="string",
     *     description="会员名称",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="nickName",
     *     type="string",
     *     description="会员昵称",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="mobile",
     *     type="string",
     *     description="用户手机号",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="avatarUrl",
     *     type="string",
     *     description="会员头像",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="gender",
     *     type="string",
     *     description="性别：0男1女",
     *     required=false,
     *   ),
     * )
     */
    public function actionEditMember(): array
   {

        $member_id = Yii::$app->user->identity->member_id??0;
        $data = Yii::$app->request->post();

        // if($data['gender'] == '男'){
        //     $data['gender'] = 0;
        // }elseif($data['gender'] == '女'){
        //     $data['gender'] = 1;
        // }

        MemberService::editMember($member_id, $data);

        return ResultHelper::json(200, '修改成功');
    }
}
