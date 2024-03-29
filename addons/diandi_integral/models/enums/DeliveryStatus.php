<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 01:01:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-29 19:08:48
 */

namespace addons\diandi_integral\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class DeliveryStatus extends BaseEnum
{

    // 未发货
    const NONPAYMENT = 0;
    // 已发货
    const ACCOUNTPAID = 1;
 
    
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
        self::NONPAYMENT => '未发货',
        self::ACCOUNTPAID => '已发货',
    ];
}
