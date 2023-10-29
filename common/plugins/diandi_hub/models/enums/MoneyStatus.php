<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 01:01:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-11-05 13:59:54
 */

namespace common\plugins\diandi_hub\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class MoneyStatus extends BaseEnum
{
    // 冻结
    const FREEZE   = 1;
    // 结算中
    const ONROUTE  = 2;
    // 已结算
    const ENDROUTE = 3;
    
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
        self::FREEZE => '冻结',
        self::ONROUTE => '结算中',
        self::ENDROUTE => '已结算',
    ];
}
