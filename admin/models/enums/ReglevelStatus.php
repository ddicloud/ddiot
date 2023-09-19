<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 01:01:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-06-03 10:38:10
 */

namespace admin\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class ReglevelStatus extends BaseEnum
{
    
    const          GLOBALBLOC =0;   
    const          BLOC =1;   
    const          STORE =2;   
    
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
        self::GLOBALBLOC=>"集团",
        self::BLOC=>"公司",
        self::STORE=>"商户"
    ];
    
}       