<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 01:01:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-21 01:16:05
 */

namespace common\plugins\diandi_hub\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class StorePayStatus extends BaseEnum
{
    // 创建
    const CREATE = 0;
    
    // 付款
    const PAY = 1;
    
    // 确认
    const CONFIRM = 2;
    
    
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
        self::CREATE    => '创建',
        self::PAY       => '支付',
        self::CONFIRM   => '确认',
    ];
}
