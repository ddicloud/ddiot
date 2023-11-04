<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 01:01:58
 * @Last Modified by:   Wang Chunsheng 2192138785@qq.com
 * @Last Modified time: 2020-03-13 03:29:00
 */

namespace addons\diandi_integral\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class PayStatus extends BaseEnum
{
    // 未付款
    const NONPAYMENT = 0;
    // 已付款
    const ACCOUNTPAID = 1;
    // 已退款
    const CANCEL = 2;
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
        self::NONPAYMENT => '未付款',
        self::ACCOUNTPAID => '已付款',
        self::CANCEL => '已退款',
    ];
}
