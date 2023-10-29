<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 01:01:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-11 05:36:50
 */

namespace common\plugins\diandi_hub\models\enums;

use yii2mod\enum\helpers\BaseEnum;

// 售后状态:0申请1拒绝售后2处理中3已处理4已完结
class AftersaleStatus extends BaseEnum
{
    // 申请
    const APPLY = 0;
    
    // 驳回
    const REFUSE = 1;
    
    // 处理中
    const   INHAND = 2;
    
    // 客服已处理
    const  PROCESSED = 3;
    
    // 用户确认已完结
    const   ENDSERVICE = 4;
    
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
        self::APPLY         => '已申请',
        self::REFUSE        => '被驳回',
        self::INHAND        => '处理中',
        self::PROCESSED     => '已处理',
        self::ENDSERVICE    => '已完结',
    ];
}
