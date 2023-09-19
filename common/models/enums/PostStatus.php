<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-02-21 10:06:15
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-23 18:15:21
 */


namespace common\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class PostStatus extends BaseEnum
{
    const PENDING = 0;
    const APPROVED = 1;
    const REJECTED = 2;
    const POSTPONED = 3;
    
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
        self::PENDING => 'Pending',
        self::APPROVED => 'Approved',
        self::REJECTED => 'Rejected',
        self::POSTPONED => 'Postponed',
    ];
}