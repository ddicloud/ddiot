<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-27 14:06:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-13 11:55:58
 */

namespace common\helpers;

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

        $basepath = Yii::getAlias("@{$app}/runtime/".$moduleName.'/'.date('Y/m/d/').$path.'.log');
        self::mkdirs(dirname($basepath));
        @chmod($path, 0777);
        $time = date('m/d H:i:s');
        if (is_array($content) || !is_string($content)) {
            $contentTxt = json_encode($content);
        } elseif (is_string($content)) {
            $contentTxt = $content;
        }

        return file_put_contents($basepath, "\r\n".$time.'-'.$mark.':'.$contentTxt, FILE_APPEND);
    }
}
