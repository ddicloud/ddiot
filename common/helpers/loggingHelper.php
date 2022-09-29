<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-27 14:06:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-09-29 10:32:30
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
        $basepath = Yii::getAlias("@{$alia}/runtime/".$moduleName.'/'.date('Y/m/d/').$path.'.log');
        self::mkdirs(dirname($basepath));
        @chmod($path, 0777);
        $time = date('m/d H:i:s');
        // 加入内存使用情况
        $memoryInit = memory_get_usage() / 1024 / 1024;

        $memory = StringHelper::currency_format($memoryInit, 2).'mb';

        if (is_array($content)) {
            $content['memory'] = $memory;
            $contentTxt = json_encode($content);
        } elseif (is_string($content)) {
            $contentTxt = $content.'//memory:'.$memory;
        }

        return file_put_contents($basepath, "\r\n".$time.'-'.$mark.':'.$contentTxt, FILE_APPEND);
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
