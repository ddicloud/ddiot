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
use Throwable;
use Yii;
use yii\web\BadRequestHttpException;

class ManageController extends AController
{
    public $modelClass = '';

    public int $searchLevel = 0;

    /**
     * 安装.
     *
     * @return array
     */
    public function actionInstall(): array
    {
        $addon = Yii::$app->request->get('addon', '');
        $addonsXml = addonsService::unAddon($addon);
        try {
            $res = addonsService::install($addonsXml);
            if ($res) {
                return ResultHelper::json(200, '安装成功');
            }else{

                return ResultHelper::json(500, '安装失败');
            }
        } catch (BadRequestHttpException $e) {
            return ResultHelper::json(400, $e->getMessage(),(array)$e);

        } catch (Throwable $e) {
            return ResultHelper::json(400, $e->getMessage(),(array)$e);

        }


    }

    /**
     * 卸载.
     *
     * @return array
     * @throws Throwable
     */
    public function actionUninstall(): array
    {
        $addon = Yii::$app->request->get('addon', '');
        $res = addonsService::unInstall($addon);
        if ($res) {
            return ResultHelper::json(200, '卸载成功');
        }else{
            return ResultHelper::json(401, '卸载失败');
        }
    }

    public function actionAuth(): array
    {
        $Route = new Route();
        $routes = $Route->getAppRoutes('diandi_dingzuo');
        $model = new Route();
        if ($model->addNew($routes)) {
            return ResultHelper::json(200, '卸载成功');
        }else{
            return ResultHelper::json(401, '卸载失败');
        }
    }
}
