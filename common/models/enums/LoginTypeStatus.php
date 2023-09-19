<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-30 02:21:32
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-09-09 12:04:15
 */


namespace common\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class LoginTypeStatus extends BaseEnum
{
    const SYS = 0;

    const STORE = 1;

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
        self::SYS => '总后台登录',
        self::STORE => '商户登录'
    ];
}
