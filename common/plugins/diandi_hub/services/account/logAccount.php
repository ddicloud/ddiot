<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-29 01:20:11
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-27 02:52:25
 */

 
namespace common\plugins\diandi_hub\services\account;

use api\models\DdMember;
use common\models\DdUser;
use common\plugins\diandi_hub\models\account\HubAccountLog;
use common\plugins\diandi_hub\models\enums\AccountChangeStatus;
use common\plugins\diandi_hub\models\enums\AccountTypeStatus;
use common\plugins\diandi_hub\models\enums\OrderTypeStatus;
use common\plugins\diandi_hub\services\MemberService;
use common\helpers\ErrorsHelper;
use common\helpers\loggingHelper;
use common\helpers\StringHelper;
use common\services\BaseService;
use Yii;
use yii\data\Pagination;

class logAccount extends OrderAccount
{
    
    /**
     * 订单对应的资金变动日志 function
     * @param [type] $member_id 会员id
     * @param [type] $order_id 订单id
     * @param [type] $order_goods_id
     * @param [type] $type 资金变化类型
     * @param [type] $order_type 订单类型
     * @param [type] $goods_type 商品类型
     * @param [type] $order_price 订单价格
     * @param [type] $goods_id 商品id
     * @param [type] $goods_price 商品价格
     * @return void
     */
    public static function addorderMoneyLog($member_id,$order_id,$money,$order_goods_id,$change_type,$account_type,$order_type,$goods_type,$order_price,$goods_id,$goods_price,$performance=0)
   {
        $data = Yii::$app->request->input();
        loggingHelper::writeLog('diandi_hub', 'logAccount', '更新zichan qingqiu数据',$data);
        
        $HubAccountLog = new HubAccountLog();
        
        if($order_type ==  OrderTypeStatus::getValueByName('到店订单')){
            $store_order_id = $order_id;
            $order_id = 0;

        }else{
            $store_order_id = 0;
        }

        $change_type_str = AccountChangeStatus::getLabel($change_type);
        $account_type_str = AccountTypeStatus::getLabel($account_type);

        $str = '';

        if(floatval($money)>0){
            $str = '增加';
        }elseif(floatval($money)<0){
            $str = '减少';
        }elseif(floatval($money) == 0){
            $str = '未增减';
        }
        
        $remark = $change_type_str.'/'.$account_type_str.'/'.$str;

        $data = [
            "member_id"=>intval($member_id),//会员id
            "money"=>$money,//会员id
            "remark"=>$remark,//会员id
            "is_add"=>floatval($money)>0?1:0,//会员id
            "order_goods_id"=>$order_goods_id,	    //		
            'account_type'=>$account_type,
            "change_type" =>$change_type,    //资金变化类型
            "order_type"=>$order_type,//订单类型
            "goods_type"=>$goods_type,//商品类型
            "order_id"=>$order_id,//订单id
            "store_order_id"=>$store_order_id,//订单id
            "order_price"=>$order_price,//订单价格
            "goods_id"=>$goods_id,//商品id
            "goods_price"=>$goods_price,//商品价格
            "performance"=>$performance
        ];

        loggingHelper::writeLog('diandi_hub', 'logAccount', '更新用户资产数据',$data); 

        
        $HubAccountLog->load($data,'');
        if(!$HubAccountLog->save($data)){
           $msg = ErrorsHelper::getModelError($HubAccountLog);
           loggingHelper::writeLog('diandi_hub', 'logAccount', '更新用户资产错误',$msg); 
           return false;
        }else{
    
            loggingHelper::writeLog('diandi_hub', 'logAccount', '更新用户资产数据成功'); 

            return $HubAccountLog->id;
        }
        
        return false;
        
    }


    public static function getListByMid($member_id,$change_type=0,$account_type=0,$pageSize=10,$page=1)
    {
        $condition['member_id']  =  $member_id;
        
        if(!empty($change_type)){
            
            $condition['change_type']  =  $change_type;
            
        }
        
        $accountWhere = [];
    
        switch ($account_type) {
            case AccountTypeStatus::getValueByName('团豆'):
                $accountWhere['account_type']  =  $account_type;
                
            break;
            case AccountTypeStatus::getValueByName('余额'):
                $accountWhere['account_type']  =  $account_type;
                
            break;
            case AccountTypeStatus::getValueByName('金库'):
                $accountWhere['account_type']  =  $account_type;
        
            break;     
            case AccountTypeStatus::getValueByName('分享可提现'):
                $accountWhere['account_type']  =  $account_type;
        
            break;    
            case AccountTypeStatus::getValueByName('分享待发放'):
                $accountWhere['account_type']  =  $account_type;

            break;     
            case AccountTypeStatus::getValueByName('分享已提现'):
                $accountWhere['account_type']  =  $account_type;

            break; 
            case AccountTypeStatus::getValueByName('团队可提现'):
                $accountTypes = [
                    $account_type,
                    AccountTypeStatus::getValueByName('流水奖金可提现')
                ];
                $accountWhere = ['IN','account_type',$accountTypes];
            break;        
            case AccountTypeStatus::getValueByName('团队待发放'):
                
                $accountTypes = [
                    $account_type,
                    AccountTypeStatus::getValueByName('流水奖金待发放')
                ];
                $accountWhere = ['IN','account_type',$accountTypes];

            break;      
            case AccountTypeStatus::getValueByName('团队已提现'):
                $accountTypes = [
                    $account_type,
                    AccountTypeStatus::getValueByName('流水奖金已提现')
                ];
                $accountWhere = ['IN','account_type',$accountTypes];
            break;      
            case AccountTypeStatus::getValueByName('店铺可提现'):
                $accountWhere['account_type']  =  $account_type;

            break;    
            case AccountTypeStatus::getValueByName('店铺待发放'):
                $accountWhere['account_type']  =  $account_type;

            break; 
            case AccountTypeStatus::getValueByName('店铺已提现'):
                $accountWhere['account_type']  =  $account_type;

            break;      
            case AccountTypeStatus::getValueByName('代理可提现'):
                $accountWhere['account_type']  =  $account_type;

            break;    
            case AccountTypeStatus::getValueByName('代理已提现'):
                $accountWhere['account_type']  =  $account_type;

            break;    
            case AccountTypeStatus::getValueByName('代理待发放'):
                $accountWhere['account_type']  =  $account_type;

            break;        
            case AccountTypeStatus::getValueByName('流水奖金已提现'):
                $accountWhere['account_type']  =  $account_type;

            break;    
            case AccountTypeStatus::getValueByName('流水奖金待发放'):
                $accountWhere['account_type']  =  $account_type;

            break;  
            case AccountTypeStatus::getValueByName('流水奖金可提现'):
                $accountWhere['account_type']  =  $account_type;

            break;            
                
            default:
                if(!empty($account_type)){
                    $accountWhere['account_type']  =  $account_type;                    
                }
            break;
        }
        
        loggingHelper::writeLog('diandi_hub', 'logAccount', '日志查询sql1',$accountWhere); 

        
        // $list = HubAccountLog::find()->where($condition)->with(['order','ordergoods','goods'])->asArray()->all();
        
        $query = HubAccountLog::find()
                    ->where($condition)
                    ->andWhere($accountWhere)
                    ->andWhere(['!=','money',0])
                    ->with(['order','ordergoods','goods'])
                    ->orderBy([
                        'create_time'=>SORT_DESC
                    ]);

        loggingHelper::writeLog('diandi_hub', 'logAccount', '日志查询sql1',$query->createCommand()->getRawSql()); 

        $count = $query->count();

        // 使用总数来创建一个分页对象
        $pagination = new Pagination([
            'totalCount' => $count,
            'pageSize' => $pageSize,
            'page' => $page - 1,
            // 'pageParam'=>'page'
        ]);

        $list = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->asArray()
            ->all();
        
        $isadd_str = ['增加','减少'];
        // 获取下单人信息
        
        foreach ($list as $key => &$value) {
            // 获取下单人
            $user_id = $value['order']['user_id'];
            $orderUser = DdUser::find()->where([
                'id'=>$user_id,
                ])->asArray()->one();
            $orderUser['username'] = StringHelper::msubstr($orderUser['username'], 0,8); 
            $value['orderUser'] = $orderUser;
            
            if($value['account_type'] == AccountTypeStatus::getValueByName('团豆')){
                $value['money'] = intval($value['money']);
            }else{
                $value['money'] = StringHelper::currency_format($value['money']);
            }

            
              
                // 资金变化类型
            $value['change_type'] = AccountChangeStatus::getLabel($value['change_type']); 
          
            // 资金类型
            $value['account_type_num']  = $value['account_type']; 
            
            $value['account_type']      = AccountTypeStatus::getLabel($value['account_type']); 
                
            $value['is_add'] = $isadd_str[$value['is_add']]; 
            
            $value['create_time'] = date('Y-m-d H:i:s',$value['create_time']); 
            
        }
        return $list;
    }

    // "平台冻结",
    public static function ACCOUNT1()
    {
        
    }
    
    // "平台解冻",
    public static function ACCOUNT2()
    {
        
    }
    
    // "平台打款",
    public static function ACCOUNT3()
    {
        
    }
    // "线上退款",
    public static function ACCOUNT4()
    {
        
    }
    
    // "补贴养老",
    public static function ACCOUNT5()
    {
        
    }
    
    // "补贴消费",
    public static function ACCOUNT6()
    {
        
    }
    
    // "补贴团豆",
    public static function ACCOUNT7()
    {
        
    }
    
    // "团豆兑换",
    public static function ACCOUNT8()
    {
        
    }
    
    // "线下付款",
    public static function ACCOUNT9()
    {
        
    }
    
    // "店铺收款",
    public static function ACCOUNT10()
    {
        
    }
    
    // "区县代理收益",
    public static function ACCOUNT11()
    {
        
    }
    
    // "省代理收益",
    public static function ACCOUNT12()
    {
        
    }
    
    // "城市代理收益",
    public static function ACCOUNT13()
    {
        
    }
    // "店铺退款",
    public static function ACCOUNT14()
    {
        
    }
    
    // "余额消费",
    public static function ACCOUNT15()
    {
        
    }
    
    // "养老金支出",
    public static function ACCOUNT16()
    {
        
    }
}
