<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 01:01:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-29 18:46:00
 */

namespace addons\diandi_integral\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class OrderStatus extends BaseEnum
{

    // 未兑换
    const NONPAYMENT = 0;
    // 已兑换
    const ACCOUNTPAID = 1;
    // 已发货
    const DELIVERY = 2;
    // 已收货
    const RECEIPT = 3;
    //已完成
    const FINISHED = 4;
    //已取消
    const CANCEL    = 10;
    
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
        self::NONPAYMENT => '未兑换',
        self::ACCOUNTPAID => '已兑换',
        self::DELIVERY => '已发货',
        self::RECEIPT => '已收货',
        self::FINISHED => '已完成',
        self::CANCEL => '已取消'

    ];
}
