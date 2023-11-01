<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-25 09:30:33
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-05-29 20:13:36
 */

namespace common\plugins\diandi_hub\backend;

use common\plugins\diandi_hub\backend\member\MemberlevelController;
use common\plugins\diandi_hub\models\account\HubAccountLog;
use common\plugins\diandi_hub\models\account\HubAccountOrder;
use common\plugins\diandi_hub\models\account\HubAccountStorePay;
use common\plugins\diandi_hub\models\account\HubWithdrawLog;
use common\plugins\diandi_hub\models\advertising\HubLocation;
use common\plugins\diandi_hub\models\enums\AccountChangeStatus;
use common\plugins\diandi_hub\models\enums\AccountTypeStatus;
use common\plugins\diandi_hub\models\enums\EarningsStatus;
use common\plugins\diandi_hub\models\enums\GoodsTypeStatus;
use common\plugins\diandi_hub\models\enums\OrderTypeStatus;
use common\plugins\diandi_hub\models\enums\WithdrawTypeStatus;
use common\plugins\diandi_hub\models\express\HubExpressCompany;
use common\plugins\diandi_hub\models\express\HubExpressLog;
use common\plugins\diandi_hub\models\goods\HubGift;
use Yii;
use backend\controllers\BaseController;
use common\plugins\diandi_hub\models\goods\HubGoodsBaseGoods;
use common\plugins\diandi_hub\models\level\HubLevel;
use common\plugins\diandi_hub\models\member\HubMemberLevel;
use common\plugins\diandi_hub\models\member\HubUserBank;
use common\plugins\diandi_hub\models\order\HubBaseOrderGoods;
use common\plugins\diandi_hub\models\order\HubOrder;
use common\plugins\diandi_hub\models\Searchs\account\HubMemberAccount;
use common\plugins\diandi_hub\services\account\logAccount;
use common\plugins\diandi_hub\services\account\OrderAccount;
use common\plugins\diandi_hub\services\AftersaleService;
use common\plugins\diandi_hub\services\CartService;
use common\plugins\diandi_hub\services\GiftService;
use common\plugins\diandi_hub\services\KdApiService;
use common\plugins\diandi_hub\services\levelService;
use common\plugins\diandi_hub\services\MemberService;
use common\plugins\diandi_hub\services\OrderService;
use common\plugins\diandi_hub\services\StoreService;
use api\models\DdMember as ModelsDdMember;
use common\helpers\ArrayHelper;
use common\helpers\HashidsHelper;
use common\helpers\loggingHelper;
use common\helpers\StringHelper;
use common\models\DdMember;
use common\services\common\AddonsService;
use yii\web\Response;

/**
 * DefaultController
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class DefaultController extends BaseController
{

    // public $layout = "@backend/views/layouts/plugins-base";
    /**
     * Action index
     */
    public function actionIndex()
   {

        $info = AddonsService::getAddonsInfo('diandi_hub');
        // $out_refund_no =  'Ref2021011797101559';
        // AftersaleService::rundAccountOrder($out_refund_no);
        // $nickname = GoodsTypeStatus::GIFT;
        // p($nickname);
        return $this->render('index', [
            'info' => $info
        ]);
    }

    // public function actionLog()
    // {

    //     $ids = [317,188,120,98,45,44,43,41,40,39,257];

    //     $store_member_id = 17;


    //     foreach ($ids as $key => $order_id) {
    //         $orderDetail = OrderService::detail($order_id);
    //         $goodsAll = $orderDetail['goods'];

    //         $order_type = $orderDetail['order_type'];
    //         foreach ($goodsAll as $type => $goods) {

    //             $goods_id = $goods['goods_id'];
    //             $goods_spec_id = $goods['goods_spec_id'];
    //             $order_goods_id = $goods['order_goods_id'];

    //              // 礼包按照业绩分红，做特殊处理
    //              $performance = HubGift::find()->where(['goods_id'=>$goods_id])->select('performance')->scalar(); 

    //              $goods_costprice = floatval($goods['goods_costprice']);

    //              loggingHelper::writeLog('diandi_hub', 'OrderAccount', '店主冻结资金',[
    //                  'member_id'=>$store_member_id,
    //                  'goods_costprice'=>$goods_costprice
    //              ]);



    //                  // 资金变化类型
    //              $change_type = AccountChangeStatus::getValueByName('冻结');

    //              $account_type = AccountTypeStatus::getValueByName('店铺待发放');

    //              // 店主资金明细写入
    //              $account_log_id  =  logAccount::addorderMoneyLog($store_member_id,$order_id,$goods_costprice,$order_goods_id,$change_type,$account_type,$order_type,$goods['goods_type'],$orderDetail['total_price'],$goods_id,$goods['goods_price'],$performance);   

    //              if($account_log_id){
    //                  loggingHelper::writeLog('diandi_hub', 'OrderAccount', '店主资金操作数据',[
    //                      'member_id'=>$store_member_id,
    //                      'fileds'=>'store_freeze',
    //                      'goods_costprice'=>$goods_costprice
    //                  ]);


    //                  //  店铺冻结资金增加
    //                  $Res = MemberService::updateAccountBymid($store_member_id,'store_freeze',$goods_costprice,$account_log_id);

    //                  loggingHelper::writeLog('diandi_hub', 'OrderAccount', '店主资金操作结果',$Res);

    //              }

    //         }
    //     }


    // }



    public function actionXiufu()
    {
           // 礼包权益更新
           OrderAccount::addOrderAccount(2003,791);
    }

    // public function actionStorepay()
    // {
    //     $HubAccountStorePay = new HubAccountStorePay();

    //     $list = $HubAccountStorePay->find()->where(['>','status',0])->all();

    //     foreach ($list as $key => $value) {


    //         $order_id = $value['id'];

    //         $store_money= $value['id'];

    //         $operation_mid= $value['operation_mid'];


    //         $change_type = AccountChangeStatus::getValueByName('冻结');
    //         $account_type = AccountTypeStatus::getValueByName('店铺待发放');

    //         $goods_type = GoodsTypeStatus::getValueByName('店铺支付商品');

    //         $order_type = OrderTypeStatus::getValueByName('到店订单');
    //         $performance = 0;

    //         // 店主资金明细写入
    //         logAccount::addorderMoneyLog($operation_mid,$order_id,$value['store_money'],0,$change_type,$account_type,$order_type,$goods_type,$value['money'],0,0,$performance);



    //         StoreService::thawMoney($order_id);               



    //     }


    // }

    // public function actionTixian()
    // {

    //     $list = HubWithdrawLog::find()->asArray()->all();

    //     foreach ($list as $key => $value) {

    //         $member_id = $value['member_id'];

    //         $type = $value['withdraw_type'];

    //         $money_count = $value['money_count'];


    //         switch ($type) {

    //             case WithdrawTypeStatus::getValueByName('用户'):

    //                 $change_type =  AccountChangeStatus::getValueByName('申请提现');
    //                 $account_ype  = AccountTypeStatus::getValueByName('分享可提现');
    //                 $order_type     = OrderTypeStatus::getValueByName('提现订单');

    //                 // 资金明细写入
    //                 $account_log_id = logAccount::addorderMoneyLog($member_id,0,-$money_count,0,$change_type,$account_ype,$order_type,0,0,0,0);  

    //                 break;
    //             case WithdrawTypeStatus::getValueByName('团队'):

    //                 $change_type =  AccountChangeStatus::getValueByName('申请提现');
    //                 $account_ype  = AccountTypeStatus::getValueByName('团队可提现');
    //                 $order_type     = OrderTypeStatus::getValueByName('提现订单');


    //                     // 资金明细写入
    //                 $account_log_id = logAccount::addorderMoneyLog($member_id,0,-$money_count,0,$change_type,$account_ype,$order_type,0,0,0,0);  
    //                 break;

    //             case WithdrawTypeStatus::getValueByName('店铺'):


    //                 $change_type =  AccountChangeStatus::getValueByName('申请提现');
    //                 $account_ype  = AccountTypeStatus::getValueByName('店铺可提现');
    //                 $order_type     = OrderTypeStatus::getValueByName('提现订单');

    //                     // 资金明细写入
    //                     $account_log_id = logAccount::addorderMoneyLog($member_id,0,-$money_count,0,$change_type,$account_ype,$order_type,0,0,0,0);  

    //                 break;

    //             case WithdrawTypeStatus::getValueByName('代理'):

    //                 break;

    //         }


    //     }




    // }

    // public function actionTime()
    // {
    //     $list = HubAccountLog::find()->with(['order'])->asArray()->all();

    //     foreach ($list as $key => $value) {
    //             if($value['change_type']==1){
    //                 // 更新为付款时间
    //                 $time = $value['order']['pay_time'];
    //             }else{
    //                 // 更新为收货时间
    //                 $time = $value['order']['receipt_time'];
    //             }
    //             HubAccountLog::updateAll([
    //                 'create_time'=>$time
    //             ],[
    //                 'id'=>$value['id']
    //             ]);
    //     }

    // }


    public function actionExpress()
    {
        $orders = HubOrder::find()->where(['>', 'create_time', 1609437124])->andWhere(['!=', 'express_no', ''])->asArray()->all();

        foreach ($orders as $key => $orderInfo) {
            $OrderCode      = $orderInfo['order_no'];
            $ShipperCode    = $orderInfo['express_company'];
            $LogisticCode   = $orderInfo['express_no'];

            KdApiService::getOrderTracesByJson($OrderCode, $ShipperCode, $LogisticCode);
        }
    }

    public function actionButie()
    {
    
        $storeDis = levelService::checkStoreDis($operation_mid, $member_id, $order['store_money'], $is_self);
        

    }

}
