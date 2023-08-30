<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-04-21 23:05:19
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 16:54:40
 */

namespace admin\controllers\system;

use admin\controllers\AController;
use common\helpers\ResultHelper;
use Yii;

class WelcomeController extends AController
{
    public $modelClass = '';

    public int $searchLevel = 0;

    public $layout = '@backend/views/layouts/main-base';

    public function actionIndex(): array
    {
        $this->layout = '@backend/views/layouts/main';

        Yii::$app->params['plugins'] = 'shop';

        return ResultHelper::json(200, '获取成功');
    }

    public function actionSysai(): array
    {
        Yii::$app->params['plugins'] = 'sysai';

        return ResultHelper::json(200, '获取成功', ['plugins' => 'sysai']);
    }

    public function actionMember(): array
    {
        Yii::$app->params['plugins'] = 'member';

        return ResultHelper::json(200, '获取成功', ['plugins' => 'member']);
    }

    public function actionAimember(): array
    {
        Yii::$app->params['plugins'] = 'aimember';

        return ResultHelper::json(200, '获取成功', ['plugins' => 'aimember']);
    }

    public function actionGoods(): array
    {
        Yii::$app->params['plugins'] = 'goods';

        return ResultHelper::json(200, '获取成功', ['plugins' => 'goods']);
    }

    public function actionMarketing(): array
    {
        Yii::$app->params['plugins'] = 'marketing';

        return ResultHelper::json(200, '获取成功', ['plugins' => 'marketing']);
    }

    public function actionOrder(): array
    {
        yii::$app->params['plugins'] = 'order';

        return ResultHelper::json(200, '获取成功', ['plugins' => 'order']);
    }

    public function actionWxapp(): array
    {
        yii::$app->params['plugins'] = 'wxapp';

        return ResultHelper::json(200, '获取成功', ['plugins' => 'wxapp']);
    }

    public function actionPlugins(): array
    {
        yii::$app->params['plugins'] = 'plugins';

        return ResultHelper::json(200, '获取成功', ['plugins' => 'plugins']);
    }

    public function actionSystem(): array
    {
        $this->layout = '@backend/views/layouts/main';
        $plugins = yii::$app->request->get('plugins');
        return ResultHelper::json(200, '获取成功', ['plugins' => 'plugins']);
    }
}
