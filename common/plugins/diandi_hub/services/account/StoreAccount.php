<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-29 01:20:11
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-04 01:11:55
 */

 
namespace common\plugins\diandi_hub\services\account;

use common\plugins\diandi_hub\models\account\HubAccountOrder;
use common\plugins\diandi_hub\models\account\HubAccountStorePay;
use common\plugins\diandi_hub\models\enums\AccountAudit;
use common\plugins\diandi_hub\models\enums\AccountChangeStatus;
use common\plugins\diandi_hub\models\enums\AccountTypeStatus;
use common\plugins\diandi_hub\models\enums\EarningsStatus;
use common\plugins\diandi_hub\models\enums\GoodsTypeStatus;
use common\plugins\diandi_hub\models\enums\OrderTypeStatus;
use common\plugins\diandi_hub\services\levelService;
use common\plugins\diandi_hub\services\MemberService;
use common\helpers\ErrorsHelper;
use common\helpers\loggingHelper;

class StoreAccount extends OrderAccount
{
    
    // 店铺订单资金汇总日志
    public static function storeOrderLog($order_id,$member_store_id,$member_id,$money)
    {
        loggingHelper::writeLog('diandi_hub', 'OrderAccount', '店主冻结资金',[
            'member_store_id'=>$member_store_id,
            'member_id'=>$member_id,
            'order_id'=>$order_id,
            'money'=>$money
        ]);
        
        
        $is_self = false;
        
        $storeDis = levelService::checkStoreDis($member_store_id,$member_id,$money,$is_self);
        loggingHelper::writeLog('diandi_hub', 'OrderAccount', '流水奖励结果',$storeDis);
        $moneyBase = 0;
        $data = [];
           
        $EarningsType = EarningsStatus::getValueByName('店铺流水收益');

        foreach ($storeDis as $mid => $selfMoney) {
            
            MemberService::updateAccountBymid($mid,'team_freeze',$selfMoney);
            $moneyBase += $selfMoney;
             // 资金变化类型
            $change_type = AccountChangeStatus::getValueByName('冻结');
            // 资金类型
            $account_ype = AccountTypeStatus::getValueByName('流水奖金待发放');
        
            $performance = 0;
            
            $order_type = OrderTypeStatus::getValueByName('到店订单');
            $goods_type = GoodsTypeStatus::getValueByName('店铺支付商品');
            $goods_id   = 0;
            $goods_price = $money;
            $order_goods_id = 0;
             
            // 团队奖励资金日志写入
            logAccount::addorderMoneyLog($mid,$order_id,$selfMoney,$order_goods_id,$change_type,$account_ype,$order_type,$goods_type,$money,$goods_id,$goods_price,$performance);   
            
            // 等级明细
            $data[] = [
                'is_count'=>0,
                'status'    => AccountAudit::getValueByName('冻结'),
                'member_id' => $member_id,
                'memberc_id' => $mid,
                'type' => $EarningsType,
                'order_goods_id'=>$order_goods_id,
                'order_type' => $order_type,
                'goods_type' => $goods_type,
                'order_id' => 0,
                'store_order_id'=> $order_id,
                'order_price' => $money,
                'goods_id' => $goods_id,
                'goods_price' =>  $goods_price,
                'money'=>$selfMoney,
                "performance"=>$performance

            ];
            
        }
    
        // 总团队汇总收益
        $data[] = [
            'is_count'=>1,
            'status'    => AccountAudit::getValueByName('冻结'),
            'member_id' => $member_id,
            'memberc_id' => $mid,
            'type' => $EarningsType,
            'order_goods_id'=>$order_goods_id,
            'order_type' => $order_type,
            'goods_type' => $goods_type,
            'order_id' => 0,
            'store_order_id'=> $order_id,
            'order_price' => $money,
            'goods_id' => $goods_id,
            'goods_price' =>  $goods_price,
            'money'=>$moneyBase,
            "performance"=>$performance
        ];
         
        $HubAccountOrder = new HubAccountOrder();
        foreach ($data as $acorder => $list) {
                $_HubAccountOrder = clone $HubAccountOrder;

                $_HubAccountOrder->setAttributes($list);
                if($_HubAccountOrder->load($list,'') && $_HubAccountOrder->save()){
                    loggingHelper::writeLog('diandi_hub', 'OrderAccount', '奖励总订单写入成功',$list);
                    
                }else{
                    $msg = ErrorsHelper::getModelError($_HubAccountOrder);
                    loggingHelper::writeLog('diandi_hub', 'OrderAccount', '奖励总订单写入失败',$msg);
                }
        }
        
    }
    
    // 店铺订单分销总额
    public static function storeOrderDisCount()
    {
        
    }


    // 店铺订单等级总额
     public static function storeOrderLevelCount()
    {
        
    }


    // 店铺订单团队总额
     public static function storeOrderTeamCount()
    {
        
    }




  
    // 计算代理对应的奖励
    public static function storeOrderAgent()
    {
        
    }

        
    
    
}
