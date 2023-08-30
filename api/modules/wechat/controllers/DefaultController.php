<?php

namespace api\modules\wechat\controllers;

use api\controllers\AController;
use common\helpers\ResultHelper;

/**
* Default controller for the `wechat` module
*/
class DefaultController extends AController
{
    /**
     * Renders the index view for the module
     * @return array
     */
public function actionIndex(): array
{
    return ResultHelper::json(200,'获取成功');
}
}