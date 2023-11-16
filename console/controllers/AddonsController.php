<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-07-02 12:49:11
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-27 14:45:05
 */

namespace console\controllers;

use common\helpers\FileHelper;
use common\services\admin\NavService;
use console\services\ApiServer;
use Yii;

// 使用示例： ./yii addons -addons=diandi_lottery -bloc_id=1 -store_id=3   job ninini

class AddonsController extends BaseController
{
    public function actionCreatemenu(): void
    {
        NavService::addonsMens($this->addons);
    }

    public function actionCreateapi(): void
    {
        ApiServer::createApiJs($this->addons);
    }


    public function actionConsole($controller, $action, $param): void
    {
        print_r([$controller, $action, $param]);
        Yii::$app->getModule($this->addons)->$action($param);
    }
}
