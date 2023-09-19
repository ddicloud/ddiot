<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 01:01:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-06-11 09:55:41
 */

namespace admin\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class StoreStatus extends BaseEnum
{
    const          AUDIT     = 0;
    const          APPROVE  = 1;
    const          DENY    = 2;

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
        self::AUDIT => "待审核",
        self::APPROVE => "审核通过",
        self::DENY => "审核不通过"
    ];
}
