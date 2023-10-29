<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 01:01:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-11 22:10:03
 */

namespace common\plugins\diandi_hub\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class LevelStatus extends BaseEnum
{
    
    const LEVEL1   = 1;
    const LEVEL2   = 2;
    const LEVEL3   = 3;
    const LEVEL4   = 4;
    const LEVEL5   = 5;
    const LEVEL6   = 6;
    const LEVEL7   = 7;
    const LEVEL8   = 8;
    const LEVEL9   = 9;
    const LEVEL10  = 10;
   
    
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
        self::LEVEL1   => '一级',
        self::LEVEL2   => '二级',
        self::LEVEL3   => '三级',
        self::LEVEL4   => '四级',
        self::LEVEL5   => '五级',
        self::LEVEL6   => '六级',
        self::LEVEL7   => '七级',
        self::LEVEL8   => '八级',
        self::LEVEL9   => '九级',
        self::LEVEL10  => '十级'
    ];
}
