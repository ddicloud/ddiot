<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-20 19:55:30
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-20 20:08:40
 */
 

namespace common\plugins\diandi_hub\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class WithdrawTypeStatus extends BaseEnum
{

    const USER  = 0;

    const TEAM  = 1;

    const STORE = 2;

    const AGENT = 3;
    
    
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
        self::USER    => '用户',
        self::TEAM    => '团队',
        self::STORE   => '店铺',
        self::AGENT   => '代理',
    ];
}
