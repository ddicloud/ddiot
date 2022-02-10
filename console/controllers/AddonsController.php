<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-07-02 12:49:11
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-09-03 13:06:12
 */

namespace console\controllers;

use common\services\backend\NavService;
use Yii;
use yii\console\Controller;

// 使用示例： ./yii addons -addons=diandi_lottery -bloc_id=1 -store_id=3   job ninini

class AddonsController extends BaseController
{
    public function actionCreatemenu()
    {
        NavService::addonsMens($this->addons);
    }

    public function actionConsole($controller, $action, $param)
    {
        print_r([$controller, $action, $param]);
        Yii::$app->getModule($this->addons)->$action($param);
    }
}
