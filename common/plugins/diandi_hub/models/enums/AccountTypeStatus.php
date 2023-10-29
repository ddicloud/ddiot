<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 01:01:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-04 22:46:48
 */

namespace common\plugins\diandi_hub\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class AccountTypeStatus extends BaseEnum
{
    
    const          ACCOUNTTP1=1;   //    //团豆
    const          ACCOUNTTP2=2;   //    //可用余额
    const          ACCOUNTTP3=3;   //    //养老金
    const          ACCOUNTTP4=4;   //    //分销可提现
    const          ACCOUNTTP5=5;   //    //分销冻结
    const          ACCOUNTTP6=6;   //    //分销已提现
    const          ACCOUNTTP7=7;   //    //团队可提现
    const          ACCOUNTTP8=8;   //    //团队冻结
    const          ACCOUNTTP9=9;   //    //团队已提现
    const          ACCOUNTTP10=10;   //    //店铺可提现
    const          ACCOUNTTP11=11;   //    //店铺冻结
    const          ACCOUNTTP12=12;   //    //店铺已提现
    const          ACCOUNTTP13=13;   //    //代理可提现
    const          ACCOUNTTP14=14;   //    //代理已提现
    const          ACCOUNTTP15=15;   //    //代理冻结
    const          ACCOUNTTP16=16;   //    //流水奖金已提现
    const          ACCOUNTTP17=17;   //    //流水奖金待发放
    const          ACCOUNTTP18=18;   //    //流水奖金可提现
    
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
            self::ACCOUNTTP1  =>"团豆",
            self::ACCOUNTTP2  =>"余额",//补贴金额
            self::ACCOUNTTP3  =>"金库",//养老金
            self::ACCOUNTTP4  =>"分享可提现",
            self::ACCOUNTTP5  =>"分享待发放",
            self::ACCOUNTTP6  =>"分享已提现",
            self::ACCOUNTTP7  =>"团队可提现",
            self::ACCOUNTTP8  =>"团队待发放",
            self::ACCOUNTTP9  =>"团队已提现",
            self::ACCOUNTTP10  =>"店铺可提现",
            self::ACCOUNTTP11  =>"店铺待发放",
            self::ACCOUNTTP12  =>"店铺已提现",
            self::ACCOUNTTP13  =>"代理可提现",
            self::ACCOUNTTP14  =>"代理已提现",
            self::ACCOUNTTP15  =>"代理待发放",
            self::ACCOUNTTP16  =>"流水奖金已提现",
            self::ACCOUNTTP17  =>"流水奖金待发放",
            self::ACCOUNTTP18  =>"流水奖金可提现",
        ];
}



