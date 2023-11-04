<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-04 01:06:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-06-16 16:49:49
 */

namespace addons\diandi_integral\api;

use addons\diandi_integral\services\AddressService;
use api\controllers\AController;
use common\helpers\ResultHelper;
use common\models\DdMemberAccount;
use Yii;

class MemberController extends AController
{
    public $modelClass = '\common\models\Member';

    public function actionAdd(): array
    {
        $data = Yii::$app->request->post();
        $access_token = $data['access_token'];
        $data['user_id'] = Yii::$app->user->identity->member_id??0;
        $res = AddressService::add($data);

        return ResultHelper::json(200, '添加成功', $res);
    }

    public function actionInfo(): array
    {
        $member_id = Yii::$app->user->identity->member_id??0;

        $user_integral = DdMemberAccount::find()
        ->select(['user_integral'])
        ->where(['member_id' => $member_id])
        ->asArray()
        ->one()['user_integral'];

        return ResultHelper::json(200, '添加成功', [
            'user_integral' => $user_integral,
        ]);
    }
}
