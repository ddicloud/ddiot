<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 01:01:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-09-23 09:25:16
 */

namespace common\plugins\diandi_website\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class NavTypeStatus extends BaseEnum
{

    const          TOP = 1;
    const          NAV = 2;
    const          FOOT1 = 3;
    const          FOOT2 = 4;
    const          FOOT3 = 5;
    const          FOOT4 = 6;

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
        self::TOP => "顶部导航",
        self::NAV => "网站导航",
        self::FOOT1 => "底部区域1",
        self::FOOT2 => "底部区域2",
        self::FOOT3 => "底部区域3",
        self::FOOT4 => "底部区域4",
    ];
}
