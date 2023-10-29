<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 01:01:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-10 21:32:21
 */

namespace common\plugins\diandi_hub\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class RefundType extends BaseEnum
{
    const ALL   = 0;
    
    const MONEY = 1;
   
    const GOODS = 2;
    
    
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
        self::ALL => '退款退货',
        self::MONEY    => '退款',
        self::GOODS    => '换货',
    ];
}
