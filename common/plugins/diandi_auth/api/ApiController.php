<?php

namespace common\plugins\diandi_auth\api;

use api\controllers\AController;
use common\helpers\ResultHelper;
use Yii;


class ApiController extends AController
{
    public $modelClass = '';

    protected array $authOptional = ['index'];

    public function actionIndex(): array
    {

        $data = Yii::$app->request->input();
        $access_token = $data['access_token'];
        if (!empty(Yii::$app->user->identity->id)) {
            $data['user_id'] = Yii::$app->user->identity->id;
        }
        $res = [];

        return ResultHelper::json(200, '请求成功', $res);
    }

}
