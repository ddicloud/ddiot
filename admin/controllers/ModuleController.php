<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-03 16:37:30
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-08 16:20:09
 */

namespace admin\controllers;

use common\helpers\ResultHelper;
use common\models\DdAiApplications;
use diandi\addons\models\searchs\DdAddons;
use Yii;

/**
 * DdAiApplicationsController implements the CRUD actions for DdAiApplications model.
 */
class ModuleController extends AController
{
    public $modelClass = '';

    public $layout = '@backend/views/layouts/main-base';

    /**
     * Lists all DdAiApplications models.
     *
     * @return array
     */
    public function actionIndex(): array
    {
        $module = Yii::$app->params['addons'];


        $moduleName = DdAddons::findOne(['identifie' => $module]);

        return ResultHelper::json(200, '获取成功', [
            'title' => $moduleName['title'],
        ]);
    }
}
