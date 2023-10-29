<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-29 01:20:11
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-03 09:50:20
 */

 
namespace common\plugins\diandi_hub\services\account;

use common\plugins\diandi_hub\models\account\HubAccountLevel;
use common\plugins\diandi_hub\models\account\HubAccountOrder;
use common\plugins\diandi_hub\models\enums\GoodsTypeStatus;
use common\plugins\diandi_hub\models\enums\OrderTypeStatus;
use common\plugins\diandi_hub\models\order\HubOrderGoods;
use common\plugins\diandi_hub\services\levelService;
use common\plugins\diandi_hub\services\OrderService;
use common\helpers\ErrorsHelper;
use common\helpers\loggingHelper;
use common\services\BaseService;

class LevelAccount extends OrderAccount
{
    // 订单与等级关系快照
    /**
     * Undocumented function
     * @param [type] $order_id
     * @param [type] $member_id
     * @param array $money  level1  level2  level3
     * @return void
     */
    public static function addOrderToLevel($order_id,$member_id,$money=[])
    {
        // dd_diandi_hub_account_level

        $level_mid  =   $member_id;
        $selflevel_num =  parent::$my_level_num;//下单人等级

        
        // 分销人等级
        $Parent_member_levels  =   parent::$Parent_member_levels;
        
        // 分销佣金获取人
        $Parent_member_ids  =   parent::$Parent_member_ids;

        // 分销参数
        $MoneyConfig  =   parent::$MoneyConfig;


        $level1_radio       = $MoneyConfig[parent::$dis_level_num1]['level1'];
        $level2_radio       = $MoneyConfig[parent::$dis_level_num2]['level2'];
        $level3_radio       = $MoneyConfig[parent::$dis_level_num3]['level3'];
        
        $level_radios   = [
            'level1'=>$level1_radio,
            'level2'=>$level2_radio,
            'level3'=>$level3_radio
        ];
        
        $orderDetail = OrderService::detail($order_id);

        // dis_level_num1
        // dis_level_num2
        // dis_level_num3
        $level_dis  =   0;
        

        $HubAccountLevel = new HubAccountLevel();


        $self_levelnum = levelService::getChildCount($member_id);//当前分销团队人数


        $saleCont = parent::getSaleCountBymid($member_id);
        

        
        //下单人当前团队销售总额
        $self_teamsale =   $saleCont['self_teamsale'];
        $self_selfsale =   $saleCont['self_selfsale'];
        
        foreach ($$Parent_member_levels as $key => $level_num) {
            $self_teamnum  = levelService::getLevelChildCount($member_id,$level_num);//当前团队人数

            $_HubAccountLevel = clone $HubAccountLevel;
            $levelnum   =   0;
            $level_dis++;
            $data = [
                'order_goods_id'=>$order_goods_id,
                'order_id'      =>$order_id,
                'member_id'     =>$orderDetail['user_id'],
                'selflevel_num' =>$selflevel_num,

                'level_mid'     =>$Parent_member_ids[$key],
                'level_num'     =>$level_num,//分佣获取人的团队等级
                'level_dis'     =>$level_dis,// 分销等级
                'level_radio'   =>$level_radios[$key],//奖励比例
                'money'         =>$money[$key],//奖励金额
                
                // 下单人快照数据
                'levelnum'      =>$self_levelnum,//当前分销团队人数
                'teamnum'       =>$self_teamnum,//当前团队人数
                'teamsale'      =>$teamsale,//当前团队销售总额
                'selfsale'      =>$selfsale,//当前累计消费
            ];
            $_HubAccountLevel->setAttributes($data);
            
            if(!$_HubAccountLevel->save()){
                $msg = ErrorsHelper::getModelError($_HubAccountLevel);
                loggingHelper::writeLog('diandi_hub', 'LevelAccount', '分销等级订单写入错误',$msg);

            }
            
        }
        
        
      

        
    }

    // 我的消费总额
    public static function getSelfMoney($member_id)
    {
        // 我的团队购买的所有礼包对应的业绩和
        $order_type = OrderTypeStatus::getValueByName('尊享订单');
        $goods_type = GoodsTypeStatus::getValueByName('礼包商品');

        $total = HubOrderGoods::find()->where(['user_id'=>$member_id])->sum('performance');
        loggingHelper::writeLog('diandi_hub', 'LevelAccount', '我的消费总额计算'.$member_id,$total);
        
        return floatval($total);
    }
    
    // 我团队的消费总额
    public static function getSelfTeamMoney()
    {
        
    }
    
    // 我发展的等级人数
    public static function getSelfLevelNum()
    {
        
    }
    
    // 我的已提现总额
    public static function self_withdraw()
    {
        
    }
    
    // 我的冻结总额
    public static function self_freeze()
    {
        
    }
    
    // 我的可提现总额
    public static function self_money()
    {
        
    }

    // 查询订单对应的分销等级关系
    public static function getOrderToLevel()
    {
        
    }

    public static function getLevelCount($goods_id,$goods_spec_id,$team_level1,$team_level2,$team_level3)
    {
        
    }

    
}
