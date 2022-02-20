<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-27 12:09:47
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-08 16:17:04
 */

namespace admin\controllers\addons;

use admin\controllers\AController;
use diandi\addons\services\addonsService;
use diandi\admin\models\Route;
use Yii;

class ManageController extends AController
{
    public $modelClass = '';

    /**
     * 安装.
     *
     * @return void
     */
    public function actionInstall()
    {
        $addon = Yii::$app->request->get('addon', '');
        $addonsXml = addonsService::unAddon($addon);
        $res = addonsService::install($addonsXml);
        if ($res) {
            return $this->redirect(['addons/index']);
        }
    }

    /**
     * 卸载.
     *
     * @return void
     */
    public function actionUninstall()
    {
        $addon = Yii::$app->request->get('addon', '');
        $res = addonsService::unInstall($addon);
        if ($res) {
            return $this->redirect(['addons/index']);
        }
    }

    public function actionAuth()
    {
        $Route = new Route();
        $routes = $Route->getAppRoutes('diandi_dingzuo');
        $model = new Route();
        $model->addNew($routes);
        die;
    }
}
