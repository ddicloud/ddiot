<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-09 01:32:28
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-30 03:11:26
 */

namespace admin\modules\officialaccount\controllers;

use Yii;
use admin\controllers\AController;
use common\helpers\ArrayHelper;
use common\helpers\FileHelper;
use common\helpers\ResultHelper;
use common\models\DdCorePaylog;
use yii\helpers\Json;

/**
 * 文本管理
 */
class TextController extends AController
{
    public function actionAdd()
    {
        return ResultHelper::json(200, '获取成功');

    }

    public function actionList(): array
    {

        return ResultHelper::json(200, '获取成功');
    }


    public function actionUpdate($id): array
    {

        return ResultHelper::json(200, '获取成功');
    }

    public function actionDelete($id): array
    {

        return ResultHelper::json(200, '获取成功');
    }


    public function actionListAll(): array
    {
        global $_GPC;
        return ResultHelper::json(200, '获取成功');
    }
}