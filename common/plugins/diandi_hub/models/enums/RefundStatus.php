<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 01:01:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-13 19:35:30
 */

namespace common\plugins\diandi_hub\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class RefundStatus extends BaseEnum
{
    // 申请退款
    const STARTREFUND = 0;
    
    // 退款驳回
    const NOREFUND = 1;
    
    // 退款中
    const ONREFUND = 2;
    
    // 已退款
    const ENDREFUND = 3;
    
    const END = 4;
    
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
        self::STARTREFUND => '申请',
        self::NOREFUND    => '驳回',
        self::ONREFUND    => '退款中',
        self::ENDREFUND   => '已退款',
        self::END   => '已完结',
    ];
}
