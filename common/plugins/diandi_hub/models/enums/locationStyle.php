<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 01:01:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-11-12 18:14:27
 */

namespace common\plugins\diandi_hub\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class locationStyle extends BaseEnum
{
    
    const style1 = 1;
    
    const style2 = 2;
    
    const style3 = 3;
    
    const style4 = 4;
    
    const style5 = 5;
    
    const style6 = 6;
    
    
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
        self::style1 => '一行一个',
        self::style2 => '一行两个大气版',
        self::style3 => '一行两个迷你版',
        self::style4 => '一行单图显示',
        self::style5 => '一行两图显示',
        self::style6 => '一行三个显示',
    ];
}
