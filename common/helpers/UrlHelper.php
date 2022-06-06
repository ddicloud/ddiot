<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-03 09:53:09
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-06 11:29:01
 */

namespace common\helpers;

use yii\helpers\BaseUrl;
use yii\helpers\Json;

/**
 * Class ArrayHelper.
 *
 * @author chunchun <2192138785@qq.com>
 */
class UrlHelper extends BaseUrl
{
   public static function addonsApiUrl($addons,$controller,$action,$options=[])
   {
       return self::toRoute('//api/'.$addons.'/'.$controller.'/'.$action);
   }
}
