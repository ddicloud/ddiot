<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-09-15 20:35:50
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-09-15 20:55:09
 */

namespace common\components;

use yii2mod\enum\helpers\BaseEnum as HelpersBaseEnum;

class BaseEnum extends HelpersBaseEnum
{
    public static function getLabelByName($name)
    {
        $list = self::getConstantsByName();
        if ($list[$name]) {
            return  self::getLabel($list[$name]);
        }

        return false;
    }
}
