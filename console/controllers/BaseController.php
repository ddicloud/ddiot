<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-25 12:30:32
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-09-27 14:23:53
 */

namespace console\controllers;

use common\helpers\FileHelper;
use diandi\addons\models\DdAddons;
use Yii;
use yii\web\NotFoundHttpException;

class BaseController extends \yii\console\Controller
{

    public $addons;

    public $store_id;

    public $bloc_id;

    public $app;

    public function actions()
    {
        Yii::$app->service->commonGlobalsService->initId((int) $this->bloc_id,(int) $this->store_id);
        Yii::$app->service->commonGlobalsService->getConf($this->bloc_id);
        $module = $this->addons;
        if (empty($module)) {
            throw new NotFoundHttpException("缺少参数addons,示例 --addons=diandi_website");
        }
        $mid = DdAddons::find()->where(['identifie' => $module])->select('mid')->scalar();
        if (!$mid) {
            throw new NotFoundHttpException("当前插件{$module}没有安装.");
        }
        $runtimePath = Yii::getAlias('@ddswoole/runtime/' . $module);
        define('SWOOLE_RUNTIME', $runtimePath);
        FileHelper::mkdirs($runtimePath);
        if (is_dir($runtimePath)) {
            @chmod($runtimePath, 0777);
        }
        $files = ['baseserver.log', 'baseserver.pid', 'swoole.log', 'swoole.log'];
        foreach ($files as $key => $value) {
            if (!file_exists($runtimePath . '/' . $value)) {
                file_put_contents($runtimePath . '/' . $value, '');
                @chmod($runtimePath . '/' . $value, 0777);
            }
        }
    }

    public function options($actionID)
    {
        return ['addons', 'bloc_id', 'store_id', 'App'];
    }

    public function optionAliases()
    {
        return [
            'addons' => 'addons',
            'bloc_id' => 'bloc_id',
            'store_id' => 'store_id',
            'App' => 'App',
        ];
    }

    public function actionIndex($action, $param)
    {
        Yii::$app->getModule($this->addons)->$action($param);
    }
}
