<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-04 01:06:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-01 19:31:49
 */

namespace common\plugins\diandi_hub\services;

use common\plugins\diandi_hub\models\order\HubOrderLog;
use common\plugins\diandi_hub\models\enums\OrderStatus;
use common\plugins\diandi_hub\models\order\HubGoodsOrderLog;
use common\helpers\ErrorsHelper;
use common\helpers\loggingHelper;
use common\helpers\StringHelper;
use common\services\BaseService;
use Yii;

/**
 * Class AddressController.
 */
class HubService extends BaseService
{
    public $modelClass = '\common\models\Member';

    public function actionSearch()
    {
        return [
            'error_code' => 20,
            'res_msg' => 'ok',
        ];
    }

    // 跟进订单分销初始数据
    public static function disOrderLog($order_id)
    {
        
        loggingHelper::writeLog('diandi_hub','disOrderLog','订单id',$order_id);
    
        // 获取订单所有的商品
        $list = OrderService::detail($order_id);
        
        loggingHelper::writeLog('diandi_hub','disOrderLog','订单详情',$list);

        $user_id = $list['user_id'];
        loggingHelper::writeLog('diandi_hub','disOrderLog','用户id',$user_id);
        
        $myLevel = levelService::getLevelByUid($user_id);
        
        loggingHelper::writeLog('diandi_hub','disOrderLog','我的分销等级',$myLevel);

        $goods = $list['goods'];
        
        $goods_ids = [];
        $goods_ids = array_column($goods, 'goods_id');
        loggingHelper::writeLog('diandi_hub','disOrderLog','所有的商品id',$goods_ids);
        

        $dis = GoodsService::goodsDisList($goods_ids);

        loggingHelper::writeLog('diandi_hub','disOrderLog','所有的商品分销参数：',$dis);
        
        
        MoneyService::disMoneyFreeze($user_id,$order_id,$goods,$dis['dis']);
        

        // 获取我的所有上级
        $myParent = levelService::getAllParent($user_id);
        
        loggingHelper::writeLog('diandi_hub','disOrderLog','我的所有上级',$myParent);

        $HubOrderLog = new HubOrderLog();
        foreach ($goods as $key => $value) {
            $_HubOrderLog = clone $HubOrderLog;
            $goods_id = $value['goods_id'];
            loggingHelper::writeLog('diandi_hub','disOrderLog','当前商品02：',$dis['dis'][$goods_id]);
            $specIds[] =  $value['goods_spec_id'];
            $datas = [
                'member_id' => $user_id, //会员id
                // 'member_pid1_level'  =>intval($myParent[0]['level_num']), //	一级会员等级
                // 'member_pid2_level' =>intval($myParent[1]['level_num']),	//二级会员等级
                // 'member_pid3_level' => intval($myParent[2]['level_num']), //三级会员等级
                // 'member_pid3' =>intval($myParent[0]['member_id']), //三级会员id
                // 'member_pid2' =>intval($myParent[1]['member_id']), //二级会员id
                // 'member_pid1' =>intval($myParent[2]['member_id']), //一级会员id

                'member_pid1_level' => 0, //	一级会员等级
                'member_pid2_level' => 0,	//二级会员等级
                'member_pid3_level' => 0, //三级会员等级
                'member_pid3' => 0, //三级会员id
                'member_pid2' => 0, //二级会员id
                'member_pid1' => 0, //一级会员id

                'group_member_pid1_level' => intval($myParent[0]['level_num']), //	一级分销商等级
                'group_member_pid2_level' => intval($myParent[1]['level_num']), //二级分销商等级
                'group_member_pid3_level' => intval($myParent[2]['level_num']), //三级分销商等级
                'group_member_pid1' => intval($myParent[0]['member_id']), //一级分销商id
                'group_member_pid2' => intval($myParent[1]['member_id']), //二级分销商id
                'group_member_pid3' => intval($myParent[2]['member_id']), //三级分销商id
                'order_status'=>OrderStatus::getValueByName('未付款'),
                'order_id' => $order_id, //订单id
                'goods_id' => $value['goods_id'], //商品id
                'goods_spec_id' => intval($value['goods_spec_id']), //规格id
                'goods_price' => StringHelper::currency_format($value['goods_price']),
                'tota_price' => StringHelper::currency_format($value['total_price']),
                'memberprice' => $dis['dis'][$goods_id]['member_price'], //会员价格
                'type' => $dis['dis'][$goods_id]['type'], //分销方式
                'refund_money' => 0, //	退款金额
                'order_status' => 0, //订单状态
                'money_status' => 0, //资金状态
                'refundstatus' => 0, //退款状态
                'price1' => StringHelper::currency_format($dis['dis'][$goods_id]['price1']), //价格1
                'price2' => StringHelper::currency_format($dis['dis'][$goods_id]['price2']), //价格2
                'price3' => StringHelper::currency_format($dis['dis'][$goods_id]['price3']), //价格3
                'price4' => StringHelper::currency_format($dis['dis'][$goods_id]['price4']), //	价格4
                'price5' => StringHelper::currency_format($dis['dis'][$goods_id]['price5']), //	价格5
                'price6' => StringHelper::currency_format($dis['dis'][$goods_id]['price6']), //价格6
            ];
            
            loggingHelper::writeLog('diandi_hub','disOrderLog','分销日志数据写入',$datas);

            // 计算奖励金额 
            
            $group_member_pid1_level = intval($myParent[0]['level_num']); //	一级分销商等级
            $group_member_pid2_level = intval($myParent[1]['level_num']); //二级分销商等级
            $group_member_pid3_level = intval($myParent[2]['level_num']); //三级分销商等级
            $group_member_pid1 = intval($myParent[0]['member_id']); //一级分销商id
            $group_member_pid2 = intval($myParent[1]['member_id']); //二级分销商id
            $group_member_pid3 = intval($myParent[2]['member_id']); //三级分销商id
            

            
            $_HubOrderLog->setAttributes($datas);
            if (!$_HubOrderLog->save()) {
                $errors = ErrorsHelper::getModelError($_HubOrderLog);
                loggingHelper::writeLog('diandi_hub','disOrderLog','错误信息',$errors);
            }else{
                // 写入初始化规则数据
                loggingHelper::writeLog('diandi_hub','disOrderLog','分销规则数据写入',$dis['dis'][$goods_id]['goodsspec']);

                if($dis['dis'][$goods_id]){
                    $goodsspec = $dis['dis'][$goods_id]['goodsspec'];
                    $HubGoodsOrderLog = new HubGoodsOrderLog();
                    foreach ($goodsspec as $key => $value) {
                        unset($value['id']);
                        $_HubGoodsOrderLog = clone $HubGoodsOrderLog;
                        $value['user_id']  = $user_id;
                        $value['order_id'] = $order_id;
                        
                        loggingHelper::writeLog('diandi_hub','disOrderLog','分销规则数据写入',['goods_spec_id'=>$value['goods_spec_id'],'specIds'=>$specIds]);
                        
                        if(in_array($value['goods_spec_id'],$specIds)){
                            $_HubGoodsOrderLog->setAttributes($value);
                        
                            if (!$_HubGoodsOrderLog->save()) {
                                $errors = ErrorsHelper::getModelError($_HubGoodsOrderLog);
                                loggingHelper::writeLog('diandi_hub','disOrderLog','分销规则数据写入错误信息',$errors);
                            }
                        }
                    }
                    
                }
            }
        }
    }
}
