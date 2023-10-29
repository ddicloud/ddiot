<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 01:01:58
 * @Last Modified by:   Radish <minradish@163.com>
 * @Last Modified time: 2022-10-14 16:34:37
 */

namespace common\plugins\diandi_hub\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class GoodsTypeStatus extends BaseEnum
{

    const GIFT   = 0;

    const DIRECT = 1;

    const STORE = 2;

    const STOREPAY = 3;

    const INTEGRAL = 4;

    const OTHER = 5;

    const APPLICATION = 6;
    const COMBO = 7;
    const HARDWARE = 8;


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
        self::GIFT   => '礼包商品',
        self::DIRECT => '自营商品',
        self::STORE  => '店铺商品',
        self::STOREPAY  => '店铺支付商品',
        self::INTEGRAL  => '兑换商品',
        self::OTHER  => '其他商品',
        self::APPLICATION  => '应用商品',
        self::COMBO  => '套餐商品',
        self::HARDWARE  => '硬件商品',
    ];
}
