<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 01:01:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-04-16 02:08:31
 */

namespace common\plugins\diandi_hub\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class AccountChangeStatus extends BaseEnum
{
    
    const          ACCOUNT1 =1;      //平台冻结;
    const          ACCOUNT2 =2;      //平台解冻;
    const          ACCOUNT3 =3;      //平台打款;
    const          ACCOUNT4 =4;      //线上退款;
    const          ACCOUNT5=5;      //补贴养老;
    const          ACCOUNT6 =6;      //补贴消费;
    const          ACCOUNT7 =7;      //补贴团豆;
    const          ACCOUNT8=8;      //团豆兑换;
    const          ACCOUNT9 =9;      //线下付款;
    const          ACCOUNT10 =10;      //店铺收款;
    const          ACCOUNT11=11;      //区县代理收益;
    const          ACCOUNT12 =12;      //省代理收益;
    const          ACCOUNT13=13;      //城市代理收益;
    const          ACCOUNT14=14;      //店铺退款;
    const          ACCOUNT15 =15;      //余额消费;
    const          ACCOUNT16=16;      //养老金支出;
    const          ACCOUNT17=17;      //申请提现;
    const          ACCOUNT18=18;      //提现驳回;
    const          ACCOUNT19=19;      //提现打款;
    const          ACCOUNT20=20;      //提现打款;
    const          ACCOUNT21=21;      //提现打款;
    const          ACCOUNT22=22;      //提现打款;
    const          ACCOUNT23=23;      //提现打款;
    const          ACCOUNT24=24;      //提现打款;
    
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
        self::ACCOUNT1=>"冻结",
        self::ACCOUNT2=>"解冻",
        self::ACCOUNT3=>"打款",
        self::ACCOUNT4=>"退款",
        self::ACCOUNT5=>"补贴养老",
        self::ACCOUNT6=>"补贴消费",
        self::ACCOUNT7=>"补贴团豆",
        self::ACCOUNT8=>"兑换",
        self::ACCOUNT9=>"线下付款",
        self::ACCOUNT10=>"店铺收款",
        self::ACCOUNT11=>"区县代理收益",
        self::ACCOUNT12=>"省代理收益",
        self::ACCOUNT13=>"城市代理收益",
        self::ACCOUNT14=>"店铺退款",
        self::ACCOUNT15=>"余额消费",
        self::ACCOUNT16=>"养老金支出",
        self::ACCOUNT17=>"申请提现",
        self::ACCOUNT18=>"提现驳回",
        self::ACCOUNT19=>"提现打款",
        self::ACCOUNT20=>"未中奖奖励",
        self::ACCOUNT21=>"已中奖补贴",
        self::ACCOUNT22=>"未中奖余额退款",
        self::ACCOUNT23=>"未成团余额退款",
        self::ACCOUNT24=>"未成团微信退款",
        
    ];
}


   
    

        