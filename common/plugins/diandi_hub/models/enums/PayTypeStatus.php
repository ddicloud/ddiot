<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 01:01:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-25 01:43:46
 */

namespace common\plugins\diandi_hub\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class PayTypeStatus extends BaseEnum
{
    
    const WECHAT = 1;
    
    const APPLY = 2;
    
    const CREDIT = 3;
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
        self::WECHAT => '微信支付',
        self::APPLY => '支付宝支付',
        self::CREDIT => '余额支付',
    ];
}
