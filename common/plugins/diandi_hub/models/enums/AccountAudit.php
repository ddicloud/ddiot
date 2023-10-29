<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 01:01:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-11-30 23:10:23
 */

namespace common\plugins\diandi_hub\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class AccountAudit extends BaseEnum
{
    
    const          status1 =1;   
    const          status2 =2;   
    const          status3 =3;   
    const          status4 =4;   
    const          status5 =5;   
    const          status6 =6;   
    
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
        self::status1=>"冻结",
        self::status2=>"无效",
        self::status3=>"已审核",
        self::status4=>"已申请",
        self::status5=>"待打款",
        self::status6=>"已打款",
    ];
    
}


   
    

        