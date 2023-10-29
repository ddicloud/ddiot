<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-04 01:06:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-11-28 22:31:57
 */

namespace common\plugins\diandi_hub\services;

use common\plugins\diandi_hub\models\HubOrderLog;
use common\plugins\diandi_hub\models\money\HubMoneyLog;
use common\plugins\diandi_hub\models\order\HubOrderLog as OrderHubOrderLog;
use common\helpers\loggingHelper;
use common\helpers\StringHelper;
use common\services\BaseService;
use Yii;

/**
 * Class AddressController
 */
class MoneyService extends BaseService
{
    public $modelClass = '\common\models\Member';

    public function actionSearch()
    {
        return [
            'error_code'    => 20,
            'res_msg'       => 'ok',
        ];
    }
   
    // 我的下级团队下单业绩
    public static function getSaleTotal($member_ids=[])
    {
        $HubOrderLog = new OrderHubOrderLog();
        $where = ['IN','member_id',$member_ids];
        $saleTotal = $HubOrderLog->find()->where($where)->sum('money-refund_money');
        return $saleTotal;
    }
    
    // 根据分销规则计算冻结金额
    public static function disMoneyFreeze($user_id,$order_id,$goods,$dis)
    {

        $HubMoneyLog = new HubMoneyLog();

        $goods_spec_ids = array_column($goods,'goods_spec_id');
      
        foreach ($goods as $key => $value) {
            $goods_id = $value['goods_id'];
            $goods_price = $value['goods_price'];
            if($dis[$goods_id]){
                foreach ($dis[$goods_id]['goodsspec'] as $k => $val) {
                    $_HubMoneyLog = clone $HubMoneyLog;
                    $levelnum = $val['levelnum'];
                    $type = $val['type'];
                    $goods_spec_id = $val['goods_spec_id'];
                    $moneyOptions =$val['money'];
                    
                    loggingHelper::writeLog('diandi_hub','disMoneyFreeze','分销日志',[
                        'val'=>$val,
                        'goods_spec_id'=>$goods_spec_id,
                        'goods_spec_ids'=>$goods_spec_ids,
                        'in_array'=>in_array($goods_spec_id,$goods_spec_ids)
                        ]);

                    if(in_array($goods_spec_id,$goods_spec_ids)){
                        $data = [
                            'order_id'=>$order_id,
                            'user_id'=>$user_id,
                            'goods_id'=>$goods_id,
                            'goods_spec_id'=>$goods_spec_id,
                            'levelnum'=>$levelnum,
                            'member_id'=>$user_id,
                            'order_money'=>$goods_price,
                            'money'=>$type==1?$moneyOptions:StringHelper::currency_format($goods_price*$moneyOptions/100),
                        ];
                        p($data);die;

                        $_HubMoneyLog->setAttributes($data);
                        $_HubMoneyLog->save();
                    }
                }
            }
           
        }
    }

    // 资金解冻


    // 提现审核
    

}
