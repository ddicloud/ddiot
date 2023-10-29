<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-29 01:20:11
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-09 21:46:57
 */

 
namespace common\plugins\diandi_hub\services\account;

use common\plugins\diandi_hub\models\enums\OrderTypeStatus;
use common\services\BaseService;

class GoodsAccount extends OrderAccount
{
    // 记录商品奖励规则
    public function addGoodsRule($goods_id,$goods_spec_id)
    {
        
    }
    
    
    /**
     * 查询等级奖励规则 function
     * @param [type] $goods_id
     * @param [type] $goods_spec_id
     * @param [type] $level         分销等级
     * @param [type] $team_level    团队等级
     * @return void
     */
    public static function getMoneyLevel($goods_id,$goods_spec_id,$level,$team_level)
    {
        
        
        
    }

    /**
     * 分销奖励总和 function
     * @param [type] $goods_id
     * @param [type] $goods_spec_id
     * @return [level1_total,level2_total,level3_total]
     */
    public static function disLevelCount($goods_id,$goods_spec_id,$order_type)
    {
        // 一级奖励 +二级奖励+ 三级奖励
        
        switch ($order_type) {
            case OrderTypeStatus::getValueByName('到店订单'):
                // 优先获取店铺的分销参数，其次获取商品的分销参数
                
            break;
            case OrderTypeStatus::getValueByName('在线订单'):
                
            break;
            case OrderTypeStatus::getValueByName('自营订单'):
                // 自营根据商品分销参数计算
                
            break;
            case OrderTypeStatus::getValueByName('尊享订单'):
                // 计算礼包分销奖励
                $count = GiftAccount::disLevelCount($goods_id);
            break;
            default:
                # code...
                break;
        }
        
        return $count;
        
    }

    // 计算自营商品分销奖励总和
    public static function getGoodsLevelMoney($goods_id,$goods_spec_id)
    {
        
        
    }
    

    
}