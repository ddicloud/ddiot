<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-04 01:06:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-14 18:28:43
 */

namespace addons\diandi_integral\api;

use Yii;
use api\controllers\AController;
use api\models\DdMember;
use addons\diandi_integral\services\AddressService;
use common\helpers\ResultHelper;
use yii\web\NotFoundHttpException;

/**
 * Class AddressController
 */
class AddressController extends AController
{
    public $modelClass = '\common\models\diandi_integralAddress';


    public function actionAdd(): array
    {
        $data = Yii::$app->request->post();
        
        $data['user_id'] = Yii::$app->user->identity->member_id??0;
        $res = AddressService::add($data);
        return ResultHelper::json(200, '添加成功', $res);
    }


    public function actionLists(): array
    {
        $user_id = Yii::$app->user->identity->member_id??0;
        $Res =  AddressService::getList($user_id);
        return ResultHelper::json(200, '获取成功', $Res);
    }


    public function actionDetail(): array
    {
        $data = Yii::$app->request->post();
        $access_token = $data['access_token'];
        $user_id = Yii::$app->user->identity->member_id??0;
        $address_id = $data['address_id'];
        $res = AddressService::detail($user_id, $address_id);

        return ResultHelper::json(200, '获取成功', $res);
    }


    public function actionEdit(): array
    {
        $data = Yii::$app->request->post();
        $access_token = $data['access_token'];
        $user_id = Yii::$app->user->identity->member_id??0;
        $res = AddressService::edit($data, $user_id);
        return ResultHelper::json(200, '添加成功', (array)$res);
    }


    public function actionDeletes(): array
    {
        $data = Yii::$app->request->post();
        $access_token = $data['access_token'];
        $user_id = Yii::$app->user->identity->member_id??0;
        $address_id = $data['address_id'];
        $res = AddressService::delete($user_id, $address_id);
        return ResultHelper::json(200, '删除成功', $res);
    }





    public function actionSetdefault(): array
    {
        $user_id = Yii::$app->user->identity->member_id??0;
        $address_id = Yii::$app->request->post('address_id');
        try {
            $res = AddressService::setDefault($user_id, $address_id);
            if ($res) {
                return ResultHelper::json(200, '设置成功', $res);
            } else {
                return ResultHelper::json(040, '设置失败', $res);
            }
        } catch (NotFoundHttpException $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        }


    }


    public function actionGetdefault(): array
    {
        $access_token = Yii::$app->request->post('access-token');
        $user_id = Yii::$app->user->identity->member_id??0;
        $res = AddressService::getDefault($user_id);
        // 讲用户信息一并返回
        $res['member'] = DdMember::findOne(['member_id' => $user_id]);
      
        return ResultHelper::json(200, '获取成功', $res);
    }
}
