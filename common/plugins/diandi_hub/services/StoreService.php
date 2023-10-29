<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-05 03:35:34
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-01 19:33:29
 */

namespace common\plugins\diandi_hub\services;

use common\plugins\diandi_hub\models\account\HubAccountOrder as AccountHubAccountOrder;
use common\plugins\diandi_hub\models\enums\AccountChangeStatus;
use common\plugins\diandi_hub\models\enums\AccountTypeStatus;
use common\plugins\diandi_hub\models\enums\EarningsStatus;
use common\plugins\diandi_hub\models\enums\GoodsTypeStatus;
use common\plugins\diandi_hub\models\enums\OrderStatus;
use common\plugins\diandi_hub\models\enums\OrderTypeStatus;
use common\plugins\diandi_hub\models\enums\PayTypeStatus;
use common\plugins\diandi_hub\models\enums\StorePayStatus;
use common\plugins\diandi_hub\models\enums\StoreUserStatus;
use common\plugins\diandi_hub\models\member\HubMemberLevel;
use common\plugins\diandi_hub\models\order\HubOrder;
use common\plugins\diandi_hub\models\order\HubOrderAddress;
use common\plugins\diandi_hub\models\order\HubOrderGoods;
use common\plugins\diandi_hub\models\store\HubAccountStorePay;
use common\plugins\diandi_hub\models\store\HubAccountStorePayList;
use common\plugins\diandi_hub\models\store\HubStore;
use common\plugins\diandi_hub\models\store\HubStoreUser;
use common\plugins\diandi_hub\services\account\logAccount;
use common\plugins\diandi_hub\services\account\OrderAccount;
use common\plugins\diandi_hub\services\account\StoreAccount;
use admin\modules\officialaccount\models\DdWechatFans;
use common\helpers\ErrorsHelper;
use common\helpers\loggingHelper;
use common\helpers\ResultHelper;
use common\helpers\StringHelper;
use common\models\DdCorePaylog;
use common\models\DdMemberAccount;
use common\models\DdUser as ModelsDdMember;
use common\services\BaseService;
use diandi\addons\models\BlocStore;
use Yii;
use yii\data\Pagination;

class StoreService extends BaseService
{

    // 申请提交
    public static function addStore($name,$mobile,$address,$city,$provice,$area,$desc,$linkman,$storefront,$business,$cardFront,$cardReverse,$interior,$wechat_code,$certification,$status=0)
    {
        $member_id = Yii::$app->user->identity->user_id;
        $store = [
            'member_id'=>$member_id,
            "name" =>$name, 
            "mobile" =>$mobile, 
            "address" =>$address, 
            "city" =>$city, 
            "provice" =>$provice, 
            "area" =>$area, 
            "interior" =>$interior, 
            "linkman" =>$linkman, 
            "storefront" =>$storefront, 
            "business" =>$business, 
            "certification" =>$certification, 
            "cardFront" =>$cardFront, 
            "cardReverse" =>$cardReverse, 
            "desc" =>$desc, 
            "wechat_code" =>$wechat_code,
             "status"=>$status,
        ];

        $HubStore = new HubStore();
        $HubStore->load($store,'');
        $Res = $HubStore->save();
        if($Res){
            return true;
        }else{
            $msg = ErrorsHelper::getModelError($HubStore);
            loggingHelper::writeLog('diandi_hub', 'StoreService/add', '添加错误',$msg);
            
            return false;
            
        }
        
    }

    public static function getStoreBymid($member_id)
    {
        $mLevel = HubMemberLevel::find()->where(['member_id'=>$member_id])->select(['member_store_id'])->one();
        $member_store_id = $mLevel['member_store_id'];
        $storelists = BlocStore::find()->where(['IN','store_id',explode(',',$member_store_id)])->asArray()->all();
        
        return $storelists;
    }

    public static function getStoreByStoreId($store_id)
    {
        $mLevel = HubMemberLevel::find()
        ->where("FIND_IN_SET($store_id,member_store_id)")
        ->select(['member_id'])->one();
        
        return $mLevel['member_id'];
    }

    
    public static function addPay($operation_mid,$member_id,$member_store_id,$money,$remark,$goods=[])
    {
          
        loggingHelper::writeLog('diandi_hub', 'StoreService/addPay', '开始创建到店订单',[
            'operation_mid'=>$operation_mid,
            'member_id'=>$member_id,
            'member_store_id'=>$member_store_id,
            'money'=>$money,
            'is_rebate'=>0,
            'is_money'=>0,
            'remark'=>$remark,
            'goods'=>$goods
        ]);
        $HubAccountStorePay = new HubAccountStorePay();
        
        $status =  StorePayStatus::getValueByName('创建');
        $money = StringHelper::currency_format($money);
        
        $store = Yii::$app->service->commonGlobalsService->getStoreDetail($member_store_id);
        
        loggingHelper::writeLog('diandi_hub', 'StoreService/addPay', '店铺数据',$store);
        
        $store_radio    =  $store['storeRadio'];
        $store_money    =  StringHelper::currency_format($money*$store_radio);
        
        $data = [
            'order_no'      =>'S'.self::CreateOrderno(),
            'member_id'     =>$member_id,//付款人
            'operation_mid' =>$operation_mid,//发起人
            'money'         =>$money,
            'store_radio'   =>$store_radio,
            'store_money'   =>$store_money,
            'remark'        =>$remark,
            'status'        =>$status,
            'affirm_mid'    =>0,
            'member_store_id'=>$member_store_id,
            'transaction_id'=>'',
            'pay_time'      =>0,
            'qrcode_time' =>0,
            'confirm_time' =>0,
        ];
        
        loggingHelper::writeLog('diandi_hub', 'StoreService/addPay', '创建到店订单数据',$data);
        
        $HubAccountStorePay->load($data,'');
        if($HubAccountStorePay->save()){
            $order_id =  Yii::$app->db->getLastInsertID();

            // 计算冻结
            StoreAccount::storeOrderLog($order_id,$member_store_id,$member_id,$money);

            if(!empty($goods)){
                 $HubAccountStorePayList = new HubAccountStorePayList();
                 
                //  loggingHelper::writeLog('diandi_hub', 'StoreService/addPay', '店铺冻结资金增加',[
                //     'operation_mid'=>$operation_mid,
                //     'money'=>$money,
                //     'store_money'=>$store_money
                //  ]);

                // //  店铺冻结资金增加
                // $res = MemberService::updateAccountBymid($operation_mid,'store_freeze',$store_money);

                // loggingHelper::writeLog('diandi_hub', 'StoreService/addPay', '店主冻结资金增加更新结果',$res);
                    
                        
                // $goods_type  = GoodsTypeStatus::getValueByName('店铺支付商品');
                
                // $order_type = OrderTypeStatus::getValueByName('到店订单');
                    
                // $change_type = AccountChangeStatus::getValueByName('冻结');

                // $account_type =  AccountTypeStatus::getValueByName('店铺待发放');

                // if($res){
                                        
                //     logAccount::addorderMoneyLog($operation_mid,$order_id,$store_money,0,$change_type,$account_type,$order_type,0,$money,0,$money,0); 
                   
                // }

               
                 
                 
                 if($member_id){
                    self::paylog($data); 
                 }
                foreach ($goods as $key => $value) {    
                    $_HubAccountStorePayList = clone $HubAccountStorePayList;
                    if(!empty($value['num'])){
                        $datas = [
                            'order_id'  =>$order_id,
                            'name' =>$value['name'],
                            'goods_id' =>0,
                            'member_store_id'=>$member_store_id,
                            'goods_price' =>$value['num'],
                            'goods_num'     =>1,
                        ];
                        
                        $_HubAccountStorePayList->setAttributes($datas);
                        if(!$_HubAccountStorePayList->save()){
                            $msg = ErrorsHelper::getModelError($_HubAccountStorePayList);
                            return $msg;
                        }
                    }
                }
            }

            return [
                'code'=>0,
                'order_id'=>$order_id
            ];

        }else{
            
            $msg = ErrorsHelper::getModelError($HubAccountStorePay);
            
            return [
                'code'=>1,
                'msg'=>$msg
            ];
        } 

        return  [
            'code'=>1,
            'msg'=>'创建失败'
        ];;
        
    }

    // 
    public static function list($member_id,$order_status,$page,$pageSize)
    {
        $HubAccountStorePay = new HubAccountStorePay();
        
        $stores = self::getStoreBymid($member_id);
         
        $store_ids = array_column($stores,'store_id');

        if(empty($store_ids)){
            $status = StoreUserStatus::getValueByName('在线');
            $store_ids = HubStoreUser::find()->where(['member_id'=>$member_id,'status'=>$status])->select(['store_id'])->all();
         }
         
         if(empty($store_ids)){
            return [];
         }
         
        // 创建一个 DB 查询来获得所有
        $query = $HubAccountStorePay
                    ->find()
                    ->where(['status'=>$order_status])
                    ->andFilterWhere([
                        'IN','store_id',$store_ids
                    ])
                    ->with(['list','member','affirm','operation'])
                    ->orderBy(['create_time'=>SORT_DESC]);     
                    
        loggingHelper::writeLog('diandi_hub', 'StoreService', '我创建的店铺订单',$query->createCommand()->getRawSql());
                    
        $count = $query->count();

        // 使用总数来创建一个分页对象
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $pageSize,
            // 'page'=>$page-1
            // 'pageParam'=>'page'
        ]);

        $list = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->asArray()
            ->all();
          
        foreach ($list as $key => &$value) {
            $value['create_time'] =  date('y-m-d H:i',$value['create_time']);
            $value['status_label'] = StorePayStatus::getLabel($value['status_label']);
        }
        loggingHelper::writeLog('diandi_hub', 'StoreService', '我创建的店铺订单',Yii::$app->request->getMethod());
        loggingHelper::writeLog('diandi_hub', 'StoreService', '我创建的店铺订单',$HubAccountStorePay->find()->where(['operation_mid'=>$member_id])->with(['list'])->createCommand()->getRawSql());

        return $list;
    }


    public static function memberPayList($member_id,$order_status,$page,$pageSize)
    {
        $HubAccountStorePay = new HubAccountStorePay();
        
       
         
        // 创建一个 DB 查询来获得所有
        $query = $HubAccountStorePay
                    ->find()
                    ->where([
                        'status'=>$order_status,
                        'member_id'=>$member_id
                        ])
                    ->with(['store','list','member','affirm','operation'])
                    ->orderBy(['create_time'=>SORT_DESC]);     
                    
        $count = $query->count();

        // 使用总数来创建一个分页对象
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $pageSize,
            // 'page'=>$page-1
            // 'pageParam'=>'page'
        ]);

        $list = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->asArray()
            ->all();
          
        foreach ($list as $key => &$value) {
            $value['create_time'] =  date('y-m-d H:i',$value['create_time']);
            $value['status_label'] = StorePayStatus::getLabel($value['status_label']);
            
            $value['pay_type_str'] = PayTypeStatus::getLabel($value['pay_type']);
        }
        
        
        return $list;
    }


    public static function detail($order_id,$member_id=0)
    {
        
        $HubAccountStorePay = new HubAccountStorePay();

        $list = $HubAccountStorePay->find()->where(['id'=>$order_id])->with(['list'])->asArray()->one();
        
       
        if(!empty($member_id)){
            
            $list['status_label'] = StorePayStatus::getLabel($list['status_label']);
        
            $account = DdMemberAccount::find()->where(['member_id'=>$member_id])->select(['credit1'])->one();
                    
            $list['is_credit1'] = true; 
    
            $list['credit1'] = $account['credit1'];
    
        }
      
        return $list;
    }

    /**
     * 1：手机，2：电脑
     */
    public static function confirm($member_id,$order_id,$terminal=1)
    {
        $order = HubAccountStorePay::find()->where(['id'=>$order_id])->select(['status'])->asArray()->one();
        if($order['status'] ==  StorePayStatus::getValueByName('创建')){
            return  [
                'status'=>1,
                'msg'   =>'未付款订单不能确认'
            ];
        }
        if($order['status'] ==  StorePayStatus::getValueByName('确认')){
            return  [
                'status'=>1,
                'msg'   =>'不能重复确认'
            ];
        }
        // 订单确认后资金解冻，补贴到账，店铺结算     
        $Res =  self::thawMoney($order_id);      
         
        $member = ModelsDdMember::find()->where(['id'=>$member_id])->select(['username'])->one();
        
        if($Res){
           $res = HubAccountStorePay::updateAll([
                'confirm_time'  =>  time(),
                'affirm_mid'    =>  $member_id,
                'affirm_name'   =>  $member['username'],
                'status'        =>  StorePayStatus::getValueByName('确认')
            ],['id'=>$order_id]);
        
            return  [
                'status'=>0,
                'msg'   =>'确认成功'
            ];
        
        }else{
            
            return  [
                'status'=>1,
                'msg'   =>'确认失败'
            ];
            
        }
    }

    
    public static  function thawMoney($order_id)
    {
        $order = HubAccountStorePay::find()->where(['id'=>$order_id])->asArray()->one();

        loggingHelper::writeLog('diandi_hub', 'StoreService/thawMoney', '到店订单确认资金开始解冻',$order_id);
     
        if($order['is_money'] == 1){
            // 订单资金已解冻，不能重复
            loggingHelper::writeLog('diandi_hub', 'StoreService/thawMoney', '到店订单确认资金重复解冻',$order_id);

            return false;
        }
        
        $member_id = $order['member_id'];
        
        // 店主
        $operation_mid = $order['operation_mid'];

        loggingHelper::writeLog('diandi_hub', 'StoreService/thawMoney', '获取店主信息',$operation_mid);
        
        $store_money = $order['store_money'];
        $money       = $order['money'];
        
        $order_type = OrderTypeStatus::STORE;
        
        // 非余额支付进行补贴
        if( $order['pay_type'] != PayTypeStatus::CREDIT){
              // 计算补贴
             self::addSubsidies($order_id,$money,$member_id,0,$order_type,0,$money,0,$store_money);
        
        }
        
        
      
            // store_money	decimal			店铺收益
        // store_freeze	decimal			店铺收益冻结
        $res = MemberService::updateAccountBymid($operation_mid,'store_freeze',-$store_money);

        $change_type = AccountChangeStatus::getValueByName('解冻');
        
        
        $goods_type  = GoodsTypeStatus::getValueByName('店铺支付商品');
        
        if($res){
            $account_ype =  AccountTypeStatus::getValueByName('店铺待发放');

            logAccount::addorderMoneyLog($operation_mid,$order_id,-$store_money,0,$change_type,$account_ype,$order_type,$goods_type,$money,0,$money,0); 
        }

        $res = MemberService::updateAccountBymid($operation_mid,'store_money',$store_money);   
    

        if($res){
            $account_ype =  AccountTypeStatus::getValueByName('店铺可提现');

            logAccount::addorderMoneyLog($operation_mid,$order_id,$store_money,0,$change_type,$account_ype,$order_type,$goods_type,$money,0,$money,0); 
        }
        
        $HubAccountOrder = new AccountHubAccountOrder();
        
        // 获取所有分订单财务数据
        $accounts = $HubAccountOrder->find()->where(['store_order_id'=>$order_id,'is_count'=>1])->asArray()->all();
        
        loggingHelper::writeLog('diandi_hub', 'StoreService/thawMoney', '解冻数据',$accounts);
        
        $change_type    =  AccountChangeStatus::getValueByName('解冻');

        foreach ($accounts as $key => $account) {
            $money          = $account['money'];
            $memberc_id     = $account['memberc_id'];
            $order_goods_id = $account['order_goods_id'];
            $order_type     = $account['order_type'];    
            $goods_type     = $account['goods_type'];    
            $order_price    = $account['order_price'];    
            $goods_id       = $account['goods_id'];    
            $goods_price    = $account['goods_price'];  
            $performance    = $account['performance'];  
            switch ($account['type']) {
                case EarningsStatus::getValueByName('分销收益'):
                    // self_money	decimal	个人奖金
                    // self_freeze	decimal		个人冻结
                    // 分享可提现
                    
                    loggingHelper::writeLog('diandi_hub', 'StoreService/thawMoney', '分销收益start',[
                        'member_id'=>$memberc_id,
                        'money'=>$money
                    ]);
                    
                    $Res1 = MemberService::updateAccountBymid($memberc_id,'self_freeze',-$money);
                    if($Res1){
                        
                        $account_ype = AccountTypeStatus::getValueByName('分享待发放');
                        
                        logAccount::addorderMoneyLog($memberc_id,$order_id,-$money,$order_goods_id,$change_type,$account_ype,$order_type,$goods_type,$order_price,$goods_id,$goods_price,$performance); 
                    }

                    $Res2 = MemberService::updateAccountBymid($memberc_id,'self_money',$money);
                    if($Res2){
                        $account_ype = AccountTypeStatus::getValueByName('分享可提现');
                        
                        logAccount::addorderMoneyLog($memberc_id,$order_id,-$money,$order_goods_id,$change_type,$account_ype,$order_type,$goods_type,$order_price,$goods_id,$goods_price,$performance); 
                    }
                    
                    loggingHelper::writeLog('diandi_hub', 'StoreService/thawMoney', '分销收益end',[
                        'Res2'=>$Res2,
                        'Res1'=>$Res1
                    ]); 
                    
                break;
                case EarningsStatus::getValueByName('团队收益'):
                    
                    loggingHelper::writeLog('diandi_hub', 'StoreService/thawMoney', '团队收益start',[
                        'member_id'=>$memberc_id,
                        'money'=>$money
                    ]);
                    
                    // team_money	decimal			团队奖金
                    // team_freeze	decimal			团队奖金冻结
                    $Res1 = MemberService::updateAccountBymid($memberc_id,'team_freeze',-$money);
                    
                    if($Res1){
                        
                        $account_ype = AccountTypeStatus::getValueByName('团队待发放');
                        
                        logAccount::addorderMoneyLog($memberc_id,$order_id,-$money,$order_goods_id,$change_type,$account_ype,$order_type,$goods_type,$order_price,$goods_id,$goods_price,$performance); 
                    }
                    
                    $Res2 = MemberService::updateAccountBymid($memberc_id,'team_money',$money);

                    if($Res2){
                        $account_ype = AccountTypeStatus::getValueByName('团队可提现');
                        
                        
                        logAccount::addorderMoneyLog($memberc_id,$order_id,$money,$order_goods_id,$change_type,$account_ype,$order_type,$goods_type,$order_price,$goods_id,$goods_price,$performance); 
                    }
                    
                    loggingHelper::writeLog('diandi_hub', 'StoreService/thawMoney', '团队收益end',[
                        'Res2'=>$Res2,
                        'Res1'=>$Res1
                    ]); 
                    
                break;

                case EarningsStatus::getValueByName('店铺流水收益'):
                    
                    $store_order_id = $account['store_order_id'];
                    
                    $Storeorder = StoreService::detail($store_order_id);
                    
                    // 操作店主资金
                    
                    $operation_mid = $Storeorder['operation_mid'];
                    
                    // loggingHelper::writeLog('diandi_hub', 'StoreService/thawMoney', '店铺流水收益start',[
                    //     'member_id'=>$memberc_id,
                    //     'money'=>$money,
                    //     'operation_mid'=>$operation_mid,

                    // ]);

                    
                    
                    // $store1 = MemberService::updateAccountBymid($operation_mid,'store_freeze',-$money);
                    
                    // if($store1){
                        
                    //     $account_ype = AccountTypeStatus::getValueByName('流水奖金待发放');
                        
                    //     logAccount::addorderMoneyLog($operation_mid,$store_order_id,-$money,$order_goods_id,$change_type,$account_ype,$order_type,$goods_type,$order_price,$goods_id,$goods_price,$performance); 
                    // }
                    
                    
                    // $store2 = MemberService::updateAccountBymid($operation_mid,'store_money',$money);
                    
                    // if($store2){
                        
                    //     $account_ype = AccountTypeStatus::getValueByName('流水奖金可提现');
                        
                    //     logAccount::addorderMoneyLog($operation_mid,$store_order_id,$money,$order_goods_id,$change_type,$account_ype,$order_type,$goods_type,$order_price,$goods_id,$goods_price,$performance); 
                    // }
                    
                    // loggingHelper::writeLog('diandi_hub', 'StoreService/thawMoney', '店主流水操作结果',[
                    //     'store1'=>$store1,
                    //     'store2'=>$store2
                    // ]);

                      // team_money	decimal			团队奖金
                    // team_freeze	decimal			团队奖金冻结

                    $account_ype = AccountTypeStatus::getValueByName('流水奖金待发放');

                    $money_id = logAccount::addorderMoneyLog($memberc_id,$order_id,-$money,$order_goods_id,$change_type,$account_ype,$order_type,$goods_type,$order_price,$goods_id,$goods_price,$performance); 

                    if($money_id){
                        

                        $Res1 = MemberService::updateAccountBymid($memberc_id,'team_freeze',-$money,$money_id);
                      
                    }
                    

                    $account_ype = AccountTypeStatus::getValueByName('流水奖金可提现');
                        
                        
                    $money_id = logAccount::addorderMoneyLog($memberc_id,$order_id,$money,$order_goods_id,$change_type,$account_ype,$order_type,$goods_type,$order_price,$goods_id,$goods_price,$performance); 

                    

                    if($money_id){
                        $Res2 = MemberService::updateAccountBymid($memberc_id,'team_money',$money,$money_id);
                      
                    }
                    
                    loggingHelper::writeLog('diandi_hub', 'StoreService/thawMoney', '店铺流水收益end',[
                        'Res2'=>$Res2,
                        'Res1'=>$Res1
                    ]); 
                    
                    
                break;
                    
                case EarningsStatus::getValueByName('代理收益'):
               
                    
                break;  
    
                case EarningsStatus::getValueByName('等级收益'):
                    
                    
                break;  
            }   
            
          
                
        }
        
        // 更新订单解冻状态
        HubAccountStorePay::updateAll(['is_money'=>1],['id'=>$order_id]);
        loggingHelper::writeLog('diandi_hub', 'StoreService/thawMoney', '订单资金解冻完成',$order_id);
        
        return true;
    }

    
    // 补贴金额计算
    public static function addSubsidies($order_id,$money,$member_id,$order_goods_id,$order_type,$goods_type,$total_price,$goods_id,$goods_price)
    {
    
        loggingHelper::writeLog('diandi_hub', 'StoreService/addSubsidies', '订单开始补贴',$order_id);
     
    
        $order = HubAccountStorePay::find()->where(['id'=>$order_id])->select(['status'])->asArray()->one();

     
        if($order['is_rebate'] == 1){
            // 订单资金已解冻，不能重复
            loggingHelper::writeLog('diandi_hub', 'StoreService/addSubsidies', '到店订单确认资金重复补贴',$order_id);

            return false;
        }
        

        loggingHelper::writeLog('diandi_hub','StoreService/addSubsidies', '用户补贴开始计算',[
            $order_id,$money,$member_id,$order_goods_id,$order_type,$goods_type,$total_price,$goods_id,$goods_price
        ]);
        
        // 获取店铺信息
        $store_id = Yii::$app->params['store_id'];    
      
        $store = Yii::$app->service->commonGlobalsService->getStoreDetail($store_id);
        
        loggingHelper::writeLog('diandi_hub','StoreService/addSubsidies', '商品补贴参数',[
            'agemoney'   => $store['agemoney'],
            'moneyradio' => $store['moneyradio'],
            'douradio'   => $store['douradio']
        ]);
        
        $agemoney   = $store['agemoney'];
        $moneyradio = $store['moneyradio'];
        $douradio   = $store['douradio'];

        loggingHelper::writeLog('diandi_hub','StoreService/addSubsidies', '店铺补贴参数获取',[
            'agemoney'   => $agemoney,
            'moneyradio' => $moneyradio,
            'douradio'   => $douradio
        ]);
        
        $credit1    = $money*floatval($moneyradio); //我的补贴金额
        $credit2   =  $money*floatval($agemoney); //养老金
        $user_integral =  intval($money*$douradio);  

        //保留两位数 
        $credit1    = StringHelper::currency_format($credit1); //我的补贴金额
        $credit2   =  StringHelper::currency_format($credit2); //养老金
        
        loggingHelper::writeLog('diandi_hub','StoreService/addSubsidies', '用户补贴计算结果',[
            'credit1'    =>  $credit1, //我的补贴金额
            'credit2'   =>  $credit2, //养老金
            'user_integral' =>  $user_integral,  
            'member_id' => $member_id
        ]);

       
        
        $Res = MemberService::updateAccountBymid($member_id,'credit1',$credit1);
        
         
        loggingHelper::writeLog('diandi_hub','StoreService/addSubsidies', '补贴credit1 结果',$Res);
        
        if($Res){
            $change_type = AccountChangeStatus::getValueByName('补贴消费');
            
            $account_ype = AccountTypeStatus::getValueByName('余额');
            
            logAccount::addorderMoneyLog($member_id,$order_id,$credit1,$order_goods_id,$change_type,$account_ype,$order_type,$goods_type,$total_price,$goods_id,$goods_price);   
            
        }

        // 补贴资金日志写入

        $Res =MemberService::updateAccountBymid($member_id,'credit2',$credit2);
        loggingHelper::writeLog('diandi_hub','StoreService/addSubsidies', '补贴credit2 结果',$Res);

        if($Res){
            $change_type = AccountChangeStatus::getValueByName('补贴养老');
            $account_ype = AccountTypeStatus::getValueByName('金库');
            logAccount::addorderMoneyLog($member_id,$order_id,$credit2,$order_goods_id,$change_type,$account_ype,$order_type,$goods_type,$total_price,$goods_id,$goods_price);   
            
        }

        $Res = MemberService::updateAccountBymid($member_id,'user_integral',$user_integral);
        loggingHelper::writeLog('diandi_hub','StoreService/addSubsidies', '补贴user_integral 结果',$Res);
        
        if($Res){
            $change_type = AccountChangeStatus::getValueByName('补贴团豆');
            $account_ype = AccountTypeStatus::getValueByName('团豆');
            logAccount::addorderMoneyLog($member_id,$order_id,$user_integral,$order_goods_id,$change_type,$account_ype,$order_type,$goods_type,$total_price,$goods_id,$goods_price);   
        }
          
        HubAccountStorePay::updateAll(['is_rebate'=>1],['id'=>$order_id]);
        loggingHelper::writeLog('diandi_hub', 'StoreService/addSubsidies', '订单补贴完成',$order_id);
        
    }
    
    // 生成订单编号
    public static function CreateOrderno()
    {
        return date('Ymd').substr(implode('', array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }

     // 写入订单支付日志
     public static function paylog($order)
     {
         $user_id = $order['member_id'];
         $fans = DdWechatFans::getFansByUid($user_id);
         $openid = $fans['openid'];
         $data = [
             'type' => 'wechat',
             'openid' => $openid,
             'member_id' => $user_id,
             'uniontid' => $order['order_no'],
             'fee' => $order['money'],
             'status' => 0,
             'module' => 'diandi_hub',
             'tag' => '到店支付',
         ];
         $DdCorePaylog = new DdCorePaylog();
         $DdCorePaylog->load($data, '');
         $res = $DdCorePaylog->save();
 
         return $res;
     }


     public static function creditPay($order_id)
     {
        loggingHelper::writeLog('diandi_hub', 'storeService/creditPay', '到店订单开始回调',$order_id);

        // 到店支付订单 Store2020121499549755
        $orderInfo = HubAccountStorePay::find()->where(['id' => $order_id])->asArray()->one();
        
        $member =  DdMemberAccount::find()->where(['member_id'=>$orderInfo['member_id']])->select(['credit1'])->one();

        if($orderInfo['money']>$member['credit1']){
            return [
                'status'=>1,
                'msg'=>'您的团豆不足'
            ];
        }

        loggingHelper::writeLog('diandi_hub', 'storeService/creditPay', '到店订单详情sql',HubAccountStorePay::find()->where(['id' => $order_id])->createCommand()->getRawSql());
        loggingHelper::writeLog('diandi_hub', 'storeService/creditPay', '到店订单详情',$orderInfo);
        
        if ($orderInfo['status'] == StorePayStatus::getValueByName('支付') || $orderInfo['pay_status'] == StorePayStatus::getValueByName('确认') ) {
            return [
                'status'=>1,
                'msg'=>'不能重复支付'
            ];
        }
        
        $transaction = HubAccountStorePay::getDb()->beginTransaction();

        try {
            
            loggingHelper::writeLog('diandi_hub', 'storeService/creditPay', '到店订单处理',[
                'status' => StorePayStatus::getValueByName('支付'),
                'pay_time' => time()
            ]);


            $Res = HubAccountStorePay::updateAll([
                'status' => StorePayStatus::getValueByName('支付'),
                'pay_time' => time(),
                'pay_type'=>PayTypeStatus::getValueByName('余额支付')
            ], ['id' => $order_id]);

            loggingHelper::writeLog('diandi_hub', 'storeService/creditPay', '到店订单处理',$Res);
            
            loggingHelper::writeLog('diandi_hub', 'storeService/creditPay', '到店订单处理分销处理开始',$Res);
            
            $change_type = AccountChangeStatus::getValueByName('余额消费');
            $account_type = AccountTypeStatus::getValueByName('余额');

            $goods_type = GoodsTypeStatus::getValueByName('店铺支付商品');
            
          
            $order_type = OrderTypeStatus::getValueByName('到店订单');
            
            $account_log_id  =  logAccount::addorderMoneyLog($orderInfo['member_id'],$order_id,-$orderInfo['money'],0,$change_type,$account_type,$order_type,$goods_type,$orderInfo['money'],0,0,0);   
            
            
            MemberService::updateAccountBymid($orderInfo['member_id'],'credit1',-$orderInfo['money'],$account_log_id,'到店余额支付');
                        
            OrderAccount::addOrderAccount($orderInfo['member_id'],$orderInfo['id'],1);

            $transaction->commit();
            
        } catch (\Exception $e) {
            $transaction->rollBack();
            loggingHelper::writeLog('diandi_hub', 'storeService/creditPay', '到店订单处理,错误信息Exception',$e);
            throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            loggingHelper::writeLog('diandi_hub', 'storeService/creditPay', '到店订单处理,错误信息Throwable',$e);
            
            throw $e;
        }

        return [
            'status'=>0,
            'msg'=>'支付成功'
        ];
     }

     
     // 订单列表
     public static function onlineList($user_id, $order_status, $pageSize)
     {
        loggingHelper::writeLog('diandi_hub', 'storeService/onlineList', '店铺在线订单查询开始',[
            'user_id'       =>$user_id,
            'order_status'  =>$order_status,
            'pageSize'      =>$pageSize,
        ]);


         $stores = self::getStoreBymid($user_id);
         
         $store_ids = array_column($stores,'store_id');
         loggingHelper::writeLog('diandi_hub', 'storeService/onlineList', '店铺在线订单查询，店铺ID列表1',$store_ids);

         if(empty($store_ids)){
            $status = StoreUserStatus::getValueByName('在线');
            $store_ids = HubStoreUser::find()->where(['member_id'=>$user_id,'status'=>$status])->select(['store_id'])->all();
         }
         loggingHelper::writeLog('diandi_hub', 'storeService/onlineList', '店铺在线订单查询，店铺ID列表2',$store_ids);
         
         if(empty($store_ids)){
            return [];
         }

         $page = Yii::$app->request->get('page');
 
         $where = []; //初始化条件数组
         
         $where['is_split'] = 0;
         
         if (is_numeric($order_status)) {
             $where['order_status'] = $order_status;
         }
 
         $andWhere1 = ['!=','order_status',OrderStatus::getValueByName('已取消')];
         $andWhere2 = ['!=','order_status',OrderStatus::getValueByName('未付款')];

         // 创建一个 DB 查询来获得所有
         $query = HubOrder::find()->where($where)->andWhere($andWhere1)->andWhere($andWhere2)->andFilterWhere([
             'IN','store_id',$store_ids
         ])->with([
             'goods','express'
         ])->orderBy('create_time desc');
         
         loggingHelper::writeLog('diandi_hub', 'storeService/onlineList', '店铺在线订单查询sql',$query->createCommand()->getRawSql());

         // 得到订单的总数（但是还没有从数据库取数据）
         $count = $query->count();
         $pagination = new Pagination([
             'totalCount' => $count,
             'pageSize' => $pageSize,
         ]);
         $list = $query->offset($pagination->offset)
             ->asArray()
             ->limit($pagination->limit)
             ->all();
 
         foreach ($list as &$item) {
             $item['create_time'] = date('m-d H:i:s', $item['create_time']);
             $item['status_label'] = OrderStatus::getLabel($item['order_status']);
         }
 
         return $list;
     }


      /**
     * 订单操作.
     *
     * @param [type] $order_id
     * @param [type] $ctype
     *
     * @return void
     */
    public static function confirmOrder($order_id, $ctype,$expressCode='',$express_company='')
    {
        $massage = '操作成功';
        switch ($ctype) {
            case 'qxdd':
                // 取消订单
                $res = HubOrder::updateAll(['order_status' => OrderStatus::getValueByName('已取消')], ['order_id' => $order_id]);
                $massage = '取消成功';
                break;
            case 'qrfh':
                // 确认发货
                $HubOrder = new HubOrder();
                $Res = $HubOrder::updateAll([
                    'express_no'=>$expressCode,
                    'express_company'=>$express_company
                ],['order_id'=>$order_id,
                    ]);
                    
                $res = HubOrder::updateAll([
                    'order_status' => OrderStatus::getValueByName('已发货'),
                    'delivery_status' => 1,
                    'delivery_time' => time(),
                ], ['order_id' => $order_id]);
                
                $orderInfo = HubOrder::find()->where(['order_id' => $order_id])->asArray()->one();
                
                $OrderCode      = $orderInfo['order_no'];
                $ShipperCode    = $orderInfo['express_company'];
                $LogisticCode   = $orderInfo['express_no'];
                
                KdApiService::getOrderTracesByJson($OrderCode,$ShipperCode,$LogisticCode);
                
                $massage = '发货成功';
                break;
            case 'qrsh':
                // 确认收货
                $res = HubOrder::updateAll([
                    'order_status' => OrderStatus::getValueByName('已收货'),
                    'receipt_status' => 1,
                    'receipt_time' => time(),
                ], ['order_id' => $order_id]);

                loggingHelper::writeLog('diandi_hub', 'OrderAccount/thawMoney', '订单确认收货',[
                    'order_id'=>$order_id,
                    'res'=>$res
                ]);
                
                if($res){
                    // 确认收货后资金解冻，补贴到账，店铺结算     
                    OrderAccount::thawMoney($order_id);               
                }
                $massage = '确认收货成功';
                break;
            case 'scdd':
                // 删除订单
                $DdOrder = new HubOrder();
                $DdOrderGoods = new HubOrderGoods();
                $DdOrderAddress = new HubOrderAddress();

                $DdOrder::deleteAll(['order_id' => $order_id]);
                $DdOrderGoods::deleteAll(['order_id' => $order_id]);
                $DdOrderAddress::deleteAll(['order_id' => $order_id]);
                $massage = '删除成功';

                break;
            case 'qrfk':
                // 确认付款
                $logPath = Yii::getAlias('@runtime/diandi_hub/order.log');
                $orders = HubOrder::findOne(['order_id' => $order_id]);
                OrderService::orderNotify($orders['order_no'], $orders['pay_price'], '', $logPath);
                $massage = '付款成功';
                break;
        }
        $orderinfo = self::detail($order_id);

        return  ResultHelper::json(200, $massage, $orderinfo);
    }

}
