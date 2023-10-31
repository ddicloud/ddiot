<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-16 01:39:33
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-09 15:44:16
 */
namespace common\plugins\diandi_cloud\api;

use Yii;
use api\controllers\AController;
use common\helpers\ResultHelper;


class UserController extends AController
{
    public $modelClass = '';
  
    public function actionIndex(): array
    {
        global $_GPC;

        $data = Yii::$app->request->post();
        $access_token = $data['access_token'];
        $data['user_id'] = Yii::$app->user->identity->member_id??0;
        $res = [];

        return ResultHelper::json(200, '请求成功', $res);
    }

}
