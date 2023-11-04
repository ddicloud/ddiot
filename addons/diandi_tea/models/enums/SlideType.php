<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 01:01:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-25 15:45:33
 */

namespace addons\diandi_tea\models\enums;

use yii2mod\enum\helpers\BaseEnum;

/**
 * 幻灯片分类.
 */
class SlideType extends BaseEnum
{
    const          status1 = 1;
    const          status2 = 2;


    /**
     * @var string message category
     *             You can set your own message category for translate the values in the $list property
     *             Values in the $list property will be automatically translated in the function `listData()`
     */
    public static $messageCategory = 'App';

    /**
     * @var array
     */
    public static $list = [
        self::status1 => '商铺图片',
        self::status2 => '广告图片',
    ];
}
