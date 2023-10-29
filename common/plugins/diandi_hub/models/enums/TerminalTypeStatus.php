<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 01:01:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-10 12:39:26
 */

namespace common\plugins\diandi_hub\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class TerminalTypeStatus extends BaseEnum
{
    
    const MOBILE = 0;
    
    const IPAD = 1;
   
    const PC = 2;
     
    
    /**
     * @var string message category
     * You can set your own message category for translate the values in the $list property
     * Values in the $list property will be automatically translated in the function `listData()`
     */
    public static $messageCategory = 'App';

    /**
     * @var array
     */
    public static $list = [
        self::MOBILE    => '手机端',
        self::IPAD      => 'pad端',
        self::PC        => '电脑端'
    ];
}
