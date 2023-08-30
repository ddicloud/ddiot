<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-04-27 03:17:30
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 16:45:44
 */

namespace admin\controllers\system;

use admin\controllers\AController;
use admin\services\UserService;
use common\helpers\loggingHelper;
use common\helpers\ResultHelper;
use common\models\DdRegion;
use Yii;
use yii\web\Response;

class IndexController extends AController
{
    public $modelClass = ' ';

    public $enableCsrfValidation = false;

    public int $searchLevel = 0;

    // public $layout = false;

    public function actionIndex(): array
    {
        $csrfToken = Yii::$app->request->csrfToken;

        return ResultHelper::json(200, '获取成功', ['csrfToken' => $csrfToken]);
    }

    /**
     * @return DdRegion[]|string
     */
    public function actionChildcate(): array|string
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $pid = Yii::$app->request->post('parent_id');
        return DdRegion::findAll(['pid' => $pid]);
    }

    public function actionMenus(): array
    {

        $list = UserService::getUserMenus();

        return ResultHelper::json(200, '获取成功', $list);
    }


    /**
     * 写入日志.
     *
     * @param $path
     * @param $content
     *
     * @return bool|int
     */
    public static function writeLog($path, $content): bool|int
    {

        $basepath = Yii::getAlias('@admin/vue/'.$path.'.vue');
        loggingHelper::mkdirs(dirname($basepath));
        @chmod($path, 0777);

        return file_put_contents($basepath, $content, FILE_APPEND);
    }
}
