<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-27 14:06:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-27 16:04:59
 */

namespace common\helpers;

use common\models\ActionLog;
use Yii;

class loggingHelper
{
    /**
     * 检测目录并循环创建目录.
     *
     * @param $catalogue
     */
    public static function mkdirs($catalogue)
    {
        if (!file_exists($catalogue)) {
            self::mkdirs(dirname($catalogue));
            mkdir($catalogue, 0777);
        }

        return true;
    }

    /**
     * 写入日志.
     *
     * @param $path
     * @param $content
     *
     * @return bool|int
     */
    public static function writeLog($moduleName, $path, $mark, $content = [])
    {
        $appId = Yii::$app->id;
        list($app, $alia) = explode('-', $appId);
        $basepath = Yii::getAlias("@{$app}/runtime/" . $moduleName . '/' . date('Y/m/d/') . $path . '.log');

        self::mkdirs(dirname($basepath));
        @chmod($path, 0777);
        $time = date('m/d H:i:s');
        if (is_array($content) || !is_string($content)) {
            $contentTxt = json_encode($content);
        } elseif (is_string($content)) {
            $contentTxt = $content;
        }

        if(!in_array($appId,['app-swoole'])){
            Yii::$app->log->targets[0]->logFile = $basepath;
            Yii::$app->log->targets[0]->maxFileSize = 2000;
            Yii::$app->log->targets[0]->maxLogFiles = 10;
            //在需要记录日志的地方先赋值log文件地址：
            return Yii::info($contentTxt,'ddicms');
        }else{
            return file_put_contents($basepath, "\r\n".$time.'-'.$mark.':'.$contentTxt, FILE_APPEND);
        }
    }

    public static function actionLog($user_id, $operation, $logip)
    {
        $ActionLog = new ActionLog();
        $ActionLog->load([
            'user_id' => $user_id,
            'operation' => $operation,
            'logtime' => date('Y-m-d H:i:s', time()),
            'logip' => $logip,
        ], '');

        return $ActionLog->save();
    }
}
