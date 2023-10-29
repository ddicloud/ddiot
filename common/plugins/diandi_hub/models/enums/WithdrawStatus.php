<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 01:01:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-20 22:45:06
 */

namespace common\plugins\diandi_hub\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class WithdrawStatus extends BaseEnum
{
    // 申请提现
    const APPLY = 0;
    
    // 驳回提现
    const REJECT = 1;
    
    const AUDIT = 2;
    
    
    // 提现中
    const INHAND = 3;
    
    // 已提现
    const END = 4;
    
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
        self::APPLY     => '申请提现',
        self::REJECT    => '驳回提现',
        self::AUDIT     => '待审核',
        self::INHAND    => '提现中',
        self::END       => '已提现',
    ];
}
