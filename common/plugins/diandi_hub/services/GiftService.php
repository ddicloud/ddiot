<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-04 01:06:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-03-05 22:09:58
 */

namespace common\plugins\diandi_hub\services;

use common\plugins\diandi_hub\models\enums\GiftCate;
use common\plugins\diandi_hub\models\enums\GoodsTypeStatus;
use common\plugins\diandi_hub\models\goods\HubGift;
use common\helpers\loggingHelper;
use common\services\BaseService;
use Yii;

/**
 * Class AddressController.
 */
class GiftService extends BaseService
{
    public $modelClass = '\common\models\Member';

    public static function getGiftInfo($goods_id,$type='all')
    {
        $goodsType = GoodsTypeStatus::getValueByName('不分销商品');
        $list = [];
        $gift= [];
        switch ($type) {
            case 'all':
                $list = GoodsService::getDetail($goods_id);
        
                $gift = HubGift::find()->where(['goods_id'=>$goods_id])->one();
                break;
            case 'goods':
                $list = GoodsService::getDetail($goods_id);
                
                break;
            case 'gift':
                $gift = HubGift::find()->where(['goods_id'=>$goods_id])->one();
                break;
            default:
                $list = GoodsService::getDetail($goods_id);
            
                $gift = HubGift::find()->where(['goods_id'=>$goods_id])->one();
                break;
        }
        
        return [
            'list'=>$list,
            'gift'=>$gift
        ];         
    }

    public static function getGiftTimeRights($goods_id)
    {
        $info = self::getGiftInfo($goods_id);
        $YearRights = GiftCate::YEAR;
        $LongRights = GiftCate::LONG;
        $time = time();
        loggingHelper::writeLog('diandi_hub','GiftService','计算权益',$info);
        loggingHelper::writeLog('diandi_hub','GiftService','永久权益类型',$LongRights);
        loggingHelper::writeLog('diandi_hub','GiftService','年度权益类型',$YearRights);
        if($info['gift']['cate'] == $YearRights){
            
            return $time+365*24*60*60;
            
        }elseif($info['gift']['cate'] == $LongRights){
            
            return 1;
            
        }  

            return 0;
        
    }

    public static function UpdateUserLevelByGoods($goods_id,$user_id)
    {
        $timeRights = self::getGiftTimeRights($goods_id);
        $giftInfo   = self::getGiftInfo($goods_id,'gift');
        $levelnum   = $giftInfo['gift']['level_num']; 
        loggingHelper::writeLog('diandi_hub','GiftService','更新用户权益等级',[
            $user_id,$levelnum,$timeRights
        ]);

        // 获取用户等级信息，只有当礼包的等级比用户的等级高才进行等级更新
        $userInfo = MemberService::getByUid($user_id);

        loggingHelper::writeLog('diandi_hub','GiftService','我的等级信息',$userInfo);
        
        if($userInfo['level_num']<$levelnum){
            
            levelService::upgradeLevelByUid($user_id,$levelnum,$timeRights);
            
        }    
    }
}