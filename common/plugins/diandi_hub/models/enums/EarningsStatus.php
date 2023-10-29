<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 01:01:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-18 23:14:43
 */

namespace common\plugins\diandi_hub\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class EarningsStatus extends BaseEnum
{
    
    const PERSONAGE = 0;//个人收益

    const TEAM      = 1;
    
    const AGENT     = 2;
    
    const LEVEL     = 3;
    
    const STORE     = 4;
    
    const SUBSIDY     = 5;
    
    
    
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
        self::PERSONAGE => '分销收益',
        self::TEAM => '团队收益',
        self::AGENT => '代理收益',
        self::LEVEL => '等级收益',
        self::STORE => '店铺流水收益',
        self::SUBSIDY => '补贴收益',
    ];
}