<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-03 09:53:09
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-07-11 17:39:16
 */

namespace common\helpers;

use Yii;
use yii\helpers\BaseUrl;

/**
 * Class ArrayHelper.
 *
 * @author chunchun <2192138785@qq.com>
 */
class UrlHelper extends BaseUrl
{
    public static function addonsUrl($addons, $controller, $action, $options = [])
   {
        $urlArr = ['/'.$addons.'/'.$controller.'/'.$action];
        foreach ($options as $key => $value) {
            $urlArr = array_merge($urlArr, [$key => $value]);
        }

        return Yii::$app->request->hostInfo.self::to($urlArr);
    }

    public static function adminUrl($controller, $action, $options = [])
   {
        $urlArr = ['/admin/\\'.$controller.'/'.$action];
        foreach ($options as $key => $value) {
            $urlArr = array_merge($urlArr, [$key => $value]);
        }

        return Yii::$app->request->hostInfo.self::to($urlArr);
    }

    public static function apiUrl($controller, $action, $options = [])
   {
        $urlArr = ['/api/\\'.$controller.'/'.$action];
        foreach ($options as $key => $value) {
            $urlArr = array_merge($urlArr, [$key => $value]);
        }

        return Yii::$app->request->hostInfo.self::to($urlArr);
    }
}
