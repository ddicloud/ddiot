<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 01:01:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-06-04 09:00:52
 */

namespace admin\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class LevelStatus extends BaseEnum
{
    const          LEVEL1     = 1;   
    const          LEVEL2     = 2;   
    const          LEVEL3    = 3;   
    const          LEVEL4    = 4;   
    const          LEVEL5    = 5;   
    const          LEVEL6    = 6;   
    const          LEVEL7    = 7;   
    const          LEVEL8    = 8;   
    const          LEVEL9    = 9;   
    const          LEVEL10    = 10;   
    
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
        self::LEVEL1=>"等级一",
        self::LEVEL2=>"等级二",
        self::LEVEL3=>"等级三",
        self::LEVEL4=>"等级四",
        self::LEVEL5=>"等级五",
        self::LEVEL6=>"等级六",
        self::LEVEL7=>"等级七",
        self::LEVEL8=>"等级八",
        self::LEVEL9=>"等级九",
        self::LEVEL10=>"等级十"
    ];
    
}       