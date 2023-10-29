<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-11-25 00:24:56
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-11-25 07:42:55
 */

namespace common\plugins\diandi_cloud\services;

use common\services\BaseService;

class BoxServIce extends BaseService
{
    //PHP stdClass Object转array
    public static function objectToarray($array)
    {
        if(is_object($array))
        {
         $array = (array)$array;
        }
        if(is_array($array))
        {
         foreach($array as $key=>$value)
         {
          $array[$key] = self::objectToarray($value);
         }
        }
        return $array;
    }
}
