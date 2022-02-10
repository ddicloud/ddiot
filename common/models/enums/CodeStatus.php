<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-30 02:21:32
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-12 20:01:34
 */
 

namespace common\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class CodeStatus extends BaseEnum
{
    const TOKENERROR = 402;
    
    /**
     * @var string message category
     * You can set your own message category for translate the values in the $list property
     * Values in the $list property will be automatically translated in the function `listData()`
     */
    public static $messageCategory = 'app';
    
    /**
     * @var array
     */
    public static $list = [
        self::TOKENERROR => 'token失效'
    ];
}