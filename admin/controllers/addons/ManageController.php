<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-27 12:09:47
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 17:00:29
 */

namespace admin\controllers\addons;

use admin\controllers\AController;
use common\helpers\ResultHelper;
use diandi\addons\services\addonsService;
use diandi\admin\models\Route;
use Yii;

class ManageController extends AController
{
    public $modelClass = '';

    public $searchLevel = 0;

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
            return ResultHelper::json(200, '安装成功');
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
            return ResultHelper::json(200, '卸载成功');
        }
    }

    public function actionAuth()
    {
        $Route = new Route();
        $routes = $Route->getAppRoutes('diandi_dingzuo');
        $model = new Route();
        if ($model->addNew($routes)) {
            return ResultHelper::json(200, '卸载成功');
        }
    }
}
