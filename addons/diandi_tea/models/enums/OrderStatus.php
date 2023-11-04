<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 01:01:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-15 18:13:22
 */

namespace addons\diandi_tea\models\enums;

use yii2mod\enum\helpers\BaseEnum;

/**
 * 组合奖分类.
 */
class OrderStatus extends BaseEnum
{
    const          status1 = 1;
    const          status2 = 2;
    const          status3 = 3;
    const          status4 = 4;
    const          status5 = 5;

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
        self::status1 => '待付款',
        self::status2 => '已支付',
        self::status3 => '已完成',
        self::status4 => '已取消',
        self::status5 => '已退款',
    ];
}
