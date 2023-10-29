<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-04 01:06:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 17:04:08
 */

namespace common\plugins\diandi_hub\admin\api;

use common\plugins\diandi_hub\models\pickup\HubShopAreas;
use common\plugins\diandi_hub\services\AddressService;
use admin\controllers\AController;
use common\helpers\ResultHelper;
use common\models\DdMember;
use common\models\DdUser;
use Yii;

/**
 * Class AddressController.
 */
class AddressController extends AController
{
    public $modelClass = '\common\models\DdAddress';

    public int $searchLevel = 0;

    public function actionSearch()
    {
        return [
            'error_code' => 20,
            'res_msg' => 'ok',
        ];
    }

    /**
     * @SWG\Post(path="/diandi_hub/address/add",
     *    tags={"收货地址"},
     *    summary="收货地址添加",
     *     @SWG\Response(
     *         response = 200,
     *         description = "收货地址添加",
     *     ),
     *     @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *     ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="name",
     *     type="string",
     *     description="收货人",
     *     required=true,
     *   ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="phone",
     *     type="integer",
     *     description="手机号",
     *     required=true,
     *   ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="province_id",
     *     type="integer",
     *     description="省份",
     *     required=true,
     *   ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="city_id",
     *     type="integer",
     *     description="城市",
     *     required=true,
     *   ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="region_id",
     *     type="integer",
     *     description="区县",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="detail",
     *     type="integer",
     *     description="具体地址",
     *     required=true,
     *   )
     * )
     */
    public function actionAdd()
    {
        $data = Yii::$app->request->post();

        $data['user_id'] = Yii::$app->user->identity->user_id;
        $res = AddressService::add($data);

        return ResultHelper::json(200, '添加成功', $res);
    }

    /**
     * @SWG\Post(path="/diandi_hub/address/lists",
     *     tags={"收货地址"},
     *     summary="获取地址列表",
     *     @SWG\Response(
     *         response = 200,
     *         description = "获取用户所以的收货地址",
     *     ),
     *     @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *     ),
     * )
     */
    public function actionLists()
    {
        $user_id = Yii::$app->user->identity->user_id;
        $Res = AddressService::getList($user_id);

        return ResultHelper::json(200, '获取成功', $Res);
    }

    /**
     * @SWG\Post(path="/diandi_hub/address/detail",
     *     tags={"收货地址"},
     *     summary="Retrieves the collection of Goods resources.",
     *     @SWG\Response(
     *         response = 200,
     *         description = "Goods collection response",
     *     ),
     *     @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *     ),
     *     @SWG\Parameter(
     *      name="address_id",
     *      type="string",
     *      in="formData",
     *      required=true
     *     ),
     * )
     */
    public function actionDetail()
    {
        $data = Yii::$app->request->post();
        $access_token = $data['access_token'];
        $user_id = Yii::$app->user->identity->user_id;
        $address_id = $data['address_id'];
        $res = AddressService::detail($user_id, $address_id);

        return ResultHelper::json(200, '获取成功', $res);
    }

    /**
     * @SWG\Post(path="/diandi_hub/address/edit",
     *     tags={"收货地址"},
     *     summary="收货地址添加01",
     *     @SWG\Response(
     *         response = 200,
     *         description = "收货地址添加",
     *     ),
     *     @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *     ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="name",
     *     type="string",
     *     description="收货人",
     *     required=true,
     *   ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="phone",
     *     type="integer",
     *     description="手机号",
     *     required=true,
     *   ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="province_id",
     *     type="integer",
     *     description="省份",
     *     required=true,
     *   ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="city_id",
     *     type="integer",
     *     description="城市",
     *     required=true,
     *   ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="region_id",
     *     type="integer",
     *     description="区县",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="detail",
     *     type="integer",
     *     description="具体地址",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="address_id",
     *     type="integer",
     *     description="地址ID",
     *     required=true,
     *   )
     * )
     */
    public function actionEdit()
    {
        $data = Yii::$app->request->post();
        $access_token = $data['access_token'];
        $user_id = Yii::$app->user->identity->user_id;
        $res = AddressService::edit($data, $user_id);

        return ResultHelper::json(200, '添加成功', $res);
    }

    /**
     * @SWG\Post(path="/diandi_hub/address/deletes",
     *     tags={"收货地址"},
     *     summary="删除地址",
     *     @SWG\Response(
     *         response = 200,
     *         description = "删除地址",
     *     ),
     *     @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *     ),
     *     @SWG\Parameter(
     *      name="address_id",
     *      type="integer",
     *      in="formData",
     *      required=true
     *     ),
     * )
     */
    public function actionDeletes()
    {
        $data = Yii::$app->request->post();
        $access_token = $data['access_token'];
        $user_id = Yii::$app->user->identity->user_id;
        $address_id = $data['address_id'];
        $res = AddressService::delete($user_id, $address_id);

        return ResultHelper::json(200, '删除成功', $res);
    }

    /**
     * @SWG\Post(path="/diandi_hub/address/setdefault",
     *     tags={"收货地址"},
     *     summary="设置默认的收货地址",
     *     @SWG\Response(
     *         response = 200,
     *         description = "设置用户默认的收货地址",
     *     ),
     *    @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *     ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="address_id",
     *     type="integer",
     *     description="地址id",
     *     required=true,
     *   ),
     * )
     */
    public function actionSetdefault()
    {
        $user_id = Yii::$app->user->identity->user_id;
        $address_id = Yii::$app->request->post('address_id');
        $res = AddressService::setDefault($user_id, $address_id);

        if ($res == true) {
            return ResultHelper::json(200, '设置成功', $res);
        } else {
            return ResultHelper::json(040, '设置失败', $res);
        }
    }

    /**
     * @SWG\Post(path="/diandi_hub/address/getdefault",
     *     tags={"收货地址"},
     *     summary="获取默认的收货地址",
     *     @SWG\Response(
     *         response = 200,
     *         description = "获取用户默认的收货地址",
     *     ),
     *     @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *     ),
     * )
     */
    public function actionGetdefault()
    {
        $access_token = Yii::$app->request->post('access-token');
        $user_id = Yii::$app->user->identity->user_id;
        $res = AddressService::getDefault($user_id);
        // 讲用户信息一并返回
        // $res['member'] = DdMember::findOne(['member_id' => $user_id]);
        $res['member'] = DdUser::findOne(['id' => $user_id]);
        $res['areas'] = HubShopAreas::findOne([
            'is_default' => 1,
            'store_id' => Yii::$app->params['store_id'],
            'bloc_id' => Yii::$app->params['bloc_id'],
        ]);

        return ResultHelper::json(200, '获取成功', $res);
    }
}
