<?php

namespace api\modules\officialaccount\controllers;

use admin\controllers\AController;
use common\helpers\ResultHelper;

/**
* Default controller for the `wechat` module
*/
class DefaultController extends AController
{
/**
* Renders the index view for the module
* @return string
*/
public function actionIndex(): array
{
    return ResultHelper::json(200,'获取成功');

}
}