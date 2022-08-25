<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-19 20:34:19
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-25 11:17:10
 */

namespace swooleService\controllers;

use common\helpers\loggingHelper;
use diandi\addons\models\Bloc;
use swooleService\tasks\DemoTask;
use Yii;
use yii\db\Exception;
use yii\web\Controller;


class SiteController extends Controller
{
    public $modelClass = '';

    public function actionIndex()
    {
        Yii::$app->redis->hset('self::PREFIX_KEY', '$room_id', 4568);
        // print_r(Yii::$app->wechat);
        return [
            'name' => Yii::$app->name,
            'version' => Yii::$app->version,
            'wechat' => Yii::$app->wechat
        ];
    }

    public function actionDump()
    {
        return [
            '$_GET' => Yii::$app->request->get(),
            '$_POST' => Yii::$app->request->post()
        ];
    }

    public function actionCache()
    {
        return [
            'data' => Yii::$app->cache->getOrSet('test', function () {
                return time();
            }, 10)
        ];
    }

    /**
     * @return array|false
     * @throws Exception
     */
    public function actionDb()
    {
        $list = Bloc::find()->asArray()->all();
        return $list;
        return Yii::$app->db->createCommand('SELECT VERSION() as version')->queryOne();
    }

    public function actionTask()
    {
        return Yii::$app->webServer->task([[DemoTask::class, 'demo'], ['a', '1']]);
    }

    public function actionFinish($res)
    {
        loggingHelper::writeLog('swoole', 'swoole/actionFinish', '任务处理完成', $res);

        return $res;
    }
}