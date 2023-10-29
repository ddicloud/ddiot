<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 01:01:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-03-29 10:41:48
 */

namespace common\plugins\diandi_hub\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class OrderTypeStatus extends BaseEnum
{
    
    const STORE = 0;
    
    const ONLINE = 1;

    const SELFSALE = 2;
    
    const GIFT = 3;
    
    const WITHDRAW = 4;
    
    const SPAN = 5;
    
    const INTEGRAL = 6;
    
    const TUAN = 7;
    
    
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
        self::STORE => '到店订单',
        self::ONLINE => '在线订单',
        self::SELFSALE => '自营订单',
        self::GIFT => '尊享订单',
        self::WITHDRAW => '提现订单',
        self::SPAN => '合并订单',
        self::INTEGRAL => '积分订单',
        self::TUAN => '团购订单',
    ];
}
