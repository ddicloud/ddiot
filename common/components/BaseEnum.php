<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-09-15 20:35:50
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-09-15 20:40:15
 */

namespace common\components;

use yii2mod\enum\helpers\BaseEnum as HelpersBaseEnum;

class BaseEnum extends HelpersBaseEnum
{
    public static function getLabelByName($name)
    {
        $value = self::getValueByName($name);

        return  self::getLabel($value);
    }
}
