<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 01:01:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-16 17:48:48
 */

namespace common\plugins\diandi_hub\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class locationPage extends BaseEnum
{
 
    const index = 0;
 
    const  cart = 1;
    
    const  member = 2;

    const  giftlist = 3;
    
    const  addstore = 4;
    
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
        self::index => '首页',
        self::cart => '购物车',
        self::member => '个人中心',
        self::giftlist => '尊享权益',
        self::addstore => '申请开店',
    ];
}
