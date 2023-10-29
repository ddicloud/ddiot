<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-29 01:20:11
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-07-26 10:10:21
 */


namespace common\plugins\diandi_hub\services\account;

use common\plugins\diandi_hub\models\account\HubAccountOrder;
use common\plugins\diandi_hub\models\account\HubMemberAccount;
use common\plugins\diandi_hub\models\enums\AccountAudit;
use common\plugins\diandi_hub\models\enums\AccountChangeStatus;
use common\plugins\diandi_hub\models\enums\AccountTypeStatus;
use common\plugins\diandi_hub\models\enums\EarningsStatus;
use common\plugins\diandi_hub\models\enums\GoodsTypeStatus;
use common\plugins\diandi_hub\models\enums\OrderStatus;
use common\plugins\diandi_hub\models\enums\OrderTypeStatus;
use common\plugins\diandi_hub\models\enums\PayTypeStatus;
use common\plugins\diandi_hub\models\goods\HubGift;
use common\plugins\diandi_hub\models\goods\HubGoodsBaseGoods;
use common\plugins\diandi_hub\models\goods\HubGoodsSubsidy;
use common\plugins\diandi_hub\models\member\HubMemberLevel;
use common\plugins\diandi_hub\models\order\HubBaseOrderGoods;
use common\plugins\diandi_hub\models\order\HubOrder;
use common\plugins\diandi_hub\services\GiftService;
use common\plugins\diandi_hub\services\levelService;
use common\plugins\diandi_hub\services\MemberService;
use common\plugins\diandi_hub\services\OrderService;
use common\plugins\diandi_hub\services\StoreService;
use common\plugins\diandi_hub\models\store\HubAccountStorePay;
use common\helpers\ErrorsHelper;
use common\helpers\ImageHelper;
use common\helpers\loggingHelper;
use common\helpers\StringHelper;
use common\services\BaseService;
use Yii;
use yii\data\Pagination;

class OrderAccount extends BaseService
{

    // 我的团队等级
    public static  $my_level_num = 1;

    // 我的分销一级的团队等级
    public static  $dis_level_num1 = 1;

    // 我的分销二级的团队等级
    public static  $dis_level_num2 = 1;

    // 我的分销三级的团队等级
    public static  $dis_level_num3 = 1;

    //分销关系对应的用户id，按照等级顺序返回 

    public static  $Parent_member_ids = [];

    //分销关系对应的团队等级，按照等级顺序返回 

    public static  $Parent_member_levels = [];

    //我的下级 

    public static  $Mychild = [];

    //我的父级 
    public static  $Myparent = [];

    //  我的分销校验后参数
    public static  $MoneyConfig = [];

    //  我的团队等级校验后参数
    public static  $MoneyTeamConfig = [];

    public static function orderInit($my_level_num, $Parent_member_levels, $Parent_member_ids = [], $Mychild = [], $Myparent = [], $MoneyTeamConfig = [])
    {

        $dis_level_num1 =   $Parent_member_levels['level1'];
        $dis_level_num2 =   $Parent_member_levels['level2'];
        $dis_level_num3 =   $Parent_member_levels['level3'];


        loggingHelper::writeLog('diandi_hub', 'OrderAccount', '订单佣金日志开始', []);


        loggingHelper::writeLog('diandi_hub', 'OrderAccount', '我的等级', $my_level_num);
        loggingHelper::writeLog('diandi_hub', 'OrderAccount', '我的分销一级的团队等级', $dis_level_num1);
        loggingHelper::writeLog('diandi_hub', 'OrderAccount', '我的分销二级的团队等级', $dis_level_num2);
        loggingHelper::writeLog('diandi_hub', 'OrderAccount', '我的分销三级的团队等级', $dis_level_num3);

        self::$my_level_num     = intval($my_level_num);
        self::$dis_level_num1   = intval($dis_level_num1);
        self::$dis_level_num2   = intval($dis_level_num2);
        self::$dis_level_num3  = intval($dis_level_num3);
        self::$Parent_member_ids  = $Parent_member_ids;

        // 我的下级
        self::$Mychild = $Mychild;

        //我的父级 
        self::$Myparent = $Myparent;

        //  我的团队等级校验后参数
        self::$MoneyTeamConfig = $MoneyTeamConfig;
    }


    /**
     * 订单佣金日志
     * @param [type] $member_id 下单人
     * @param [type] $type 分佣类型0分销佣金1等级佣金2团队佣金3区域经理佣金
     * @param [type] $order_id
     * @return void
     */
    public static function addOrderAccount($member_id, $order_id, $is_store = false)
    {
        loggingHelper::writeLog('diandi_hub', 'OrderAccount', '订单佣金日志用户', $member_id);
        loggingHelper::writeLog('diandi_hub', 'OrderAccount', '订单佣金日志订单id', $order_id);

        $orderDetail = [];
        $store_id = 0;
        // 获取所有商品的成本价
        $goods_ids = [];
        $goods_costprices = [];

        //店主
        $store_member_id = 0;



        if (!$is_store) {
            // 获取订单详情
            $orderDetail = OrderService::detail($order_id);




            $order_type = $orderDetail['order_type'];

            $store_id = $orderDetail['store_id'];


            loggingHelper::writeLog('diandi_hub', 'OrderAccount', '非到店订单订单详情获取', [
                'orderDetail' => $orderDetail,
                'order_type' => $order_type,
                'store_id' => $store_id,
            ]);

            // 获取所有商品的成本价


            loggingHelper::writeLog('diandi_hub', 'OrderAccount', '订单商品全部信息', $orderDetail['goods']);

            foreach ($orderDetail['goods'] as $key => $value) {
                $goods_ids[] = $value['goods_id'];
                $goods_costprices[$value['goods_id']] = $value['goods_costprice'];
            }
            loggingHelper::writeLog('diandi_hub', 'OrderAccount', '订单商品信息处理后', [
                'goods_ids' => $goods_ids,
                'goods_costprices' => $goods_costprices
            ]);


            $money_uids = HubMemberLevel::find()->where([
                'is_store' => 1,
            ])->where("FIND_IN_SET({$store_id},member_store_id)")->select(['member_id'])->asArray()->one();
            //店主
            $store_member_id = $money_uids['member_id'];

            loggingHelper::writeLog('diandi_hub', 'OrderAccount', '非到店订单店主ID', [
                'store_member_id' => $store_member_id,
                'sql' => HubMemberLevel::find()->where([
                    'is_store' => 1,
                ])->where("FIND_IN_SET({$store_id},member_store_id)")->select(['member_id'])->createCommand()->getRawSql()
            ]);
            // 订单商品
            $goodsAll = $orderDetail['goods'];
        } else {


            // 如果是到店订单需要重置订单类型
            $order_type = OrderTypeStatus::getValueByName('到店订单');
            loggingHelper::writeLog('diandi_hub', 'OrderAccount', '到店订单修改订单类型', $order_type);
        }


        $child  =    levelService::getAllChild($member_id, '');

        self::$Mychild = $child;

        $Parent =    levelService::getAllParent($member_id, '');

        self::$Myparent = $Parent;


        loggingHelper::writeLog('diandi_hub', 'OrderAccount', '我的所有上级', $Parent);
        foreach ($Parent as $key => $value) {
            if ($value['level_num'] == 1) {
                unset($Parent[$key]);
            }
        }

        loggingHelper::writeLog('diandi_hub', 'OrderAccount', '我的所有上级过滤掉普通用户', $Parent);

        $myLevel = levelService::getLevelByUid($member_id);

        $my_level_num   = $myLevel['level_num'];
        $dis_level_num1 = $Parent[1]['level_num'];
        $dis_level_num2 = $Parent[2]['level_num'];
        $dis_level_num3 = $Parent[3]['level_num'];

        loggingHelper::writeLog('diandi_hub', 'OrderAccount', '一级的团队人', $Parent[1]);


        $Parent_member_ids    = [
            'level1' => intval($Parent[1]['member_id']),
            'level2' => intval($Parent[2]['member_id']),
            'level3' => intval($Parent[3]['member_id'])
        ];

        $Parent_member_levels   =   [
            'level1' => intval($dis_level_num1),
            'level2' => intval($dis_level_num2),
            'level3' => intval($dis_level_num3)
        ];


        loggingHelper::writeLog('diandi_hub', 'OrderAccount', '团队人', $Parent_member_ids);

        $Mychild    = [];
        $Myparent   = [];
        self::orderInit($my_level_num, $Parent_member_levels, $Parent_member_ids, $Mychild, $Myparent);



        $HubAccountOrder = new HubAccountOrder();

        // 等级关系
        // 佣金类型
        $Earnings =  EarningsStatus::listData();


        // 校验我的用户升级       
        $myParentLevel = levelService::getLevelByUid($myLevel['member_pid']);
        loggingHelper::writeLog('diandi_hub', 'OrderAccount', '开始校验我的上级是否升级', $myParentLevel);

        $is_up = levelService::checkLevelUpdate($myParentLevel['member_id']);
        loggingHelper::writeLog('diandi_hub', 'OrderAccount', '是否升级', $is_up);

        // if($is_up){
        //     loggingHelper::writeLog('diandi_hub', 'OrderAccount', '上级升级',$myParentLevel['level_num']+1);

        //     levelService::upgradeLevelByUid($myLevel['member_pid'],$myParentLevel['level_num']+1);
        //     loggingHelper::writeLog('diandi_hub', 'OrderAccount', '上级升级完成',$myLevel['member_pid']);

        //     loggingHelper::writeLog('diandi_hub', 'OrderAccount', '我的父级升级升级完成',$myParentLevel['level_num']+1);

        // }



        loggingHelper::writeLog('diandi_hub', 'OrderAccount', '订单类型', $order_type);

        if (OrderTypeStatus::getValueByName('到店订单') == $order_type) {

            // 等级收益+团队收益(分销) 2%-》开店
            loggingHelper::writeLog('diandi_hub', 'OrderAccount', '到店订单', [
                'order_type' => $order_type,
                'order_id' => $order_id
            ]);

            $order = HubAccountStorePay::find()->where(['id' => $order_id])->asArray()->one();

            //店主
            $member_store_id = $order['member_store_id'];

            $operation_mid =  $order['operation_mid'];

            loggingHelper::writeLog('diandi_hub', 'OrderAccount', '店主冻结资金', [
                'member_id' => $operation_mid,
                'store_id' => $member_store_id,
                'order' => $order
            ]);

            $change_type = AccountChangeStatus::getValueByName('冻结');
            $account_type = AccountTypeStatus::getValueByName('店铺待发放');

            $goods_type = GoodsTypeStatus::getValueByName('店铺支付商品');
            $performance = 0;

            // 店主资金明细写入
            $account_log_id  =  logAccount::addorderMoneyLog($operation_mid, $order_id, $order['store_money'], 0, $change_type, $account_type, $order_type, $goods_type, $order['money'], 0, 0, $performance);

            if ($account_log_id) {
                loggingHelper::writeLog('diandi_hub', 'OrderAccount', '店主冻结资金操作数据', [
                    'operation_mid' => $operation_mid,
                    'money' => $order['money'],
                    'account_log_id' => $account_log_id
                ]);
                //  店铺冻结资金增加
                $Res =  MemberService::updateAccountBymid($operation_mid, 'store_freeze', $order['store_money'], $account_log_id);

                loggingHelper::writeLog('diandi_hub', 'OrderAccount', '店主冻结资金操作结果', $Res);
            }


            foreach ($Earnings as $key => $typeStr) {
                switch ($key) {
                    case EarningsStatus::getValueByName('分销收益'):
                        // 获取礼包商品数据


                        break;
                    case EarningsStatus::getValueByName('团队收益'):



                        break;
                    case EarningsStatus::getValueByName('代理收益'):
                        //    暂时不管

                        break;

                    case EarningsStatus::getValueByName('店铺流水收益'):

                        if ($member_store_id == yii::$app->params['global_store_id']) {
                            $is_self = true;
                        } else {
                            $is_self = false;
                        }

                        // $storeDis = levelService::checkStoreDis($operation_mid, $member_id, $order['store_money'], $is_self);
                        $storeDis = levelService::checkStoreDis($operation_mid, $member_id, $order['money'], $is_self);
                        loggingHelper::writeLog('diandi_hub', 'OrderAccount', '流水奖励结果', $storeDis);
                        $money = 0;
                        foreach ($storeDis as $mid => $selfMoney) {

                            $money += $selfMoney;
                            // 资金变化类型
                            $change_type = AccountChangeStatus::getValueByName('冻结');
                            // 资金类型
                            $account_type = AccountTypeStatus::getValueByName('流水奖金待发放');

                            // 团队奖励资金日志写入
                            $account_log_id = logAccount::addorderMoneyLog($mid, $order_id, $selfMoney, 0, $change_type, $account_type, $order_type, $goods_type, $order['money'], 0, 0, $performance);

                            MemberService::updateAccountBymid($mid, 'team_freeze', $selfMoney, $account_log_id);


                            $member_level   = HubMemberLevel::find()->where(['member_id' => $member_id])->select('level_num')->scalar();

                            $memberc_level   = HubMemberLevel::find()->where(['member_id' => $mid])->select('level_num')->scalar();


                            // 等级明细
                            $data[] = [
                                'is_count' => 0,
                                'status'    => AccountAudit::getValueByName('冻结'),
                                'member_id' => $member_id,
                                'memberc_id' => $mid,
                                'member_level' => $member_level,
                                'memberc_level' => $memberc_level,
                                'type' => $key,
                                'order_goods_id' => 0,
                                'order_type' => $order_type,
                                'goods_type' => $goods_type,
                                'order_id' => 0,
                                "store_order_id" => $order_id, //订单id
                                'order_price' => $order['money'],
                                'goods_id' => 0,
                                'goods_price' =>  0,
                                'money' => $selfMoney,
                                "performance" => $performance,
                                'account_log_id' => $account_log_id


                            ];
                        }

                        // 总团队汇总收益
                        $data[] = [
                            'is_count' => 1,
                            'status'    => AccountAudit::getValueByName('冻结'),
                            'member_id' => $member_id,
                            'member_level' => $member_level,
                            'memberc_level' => 0,
                            'memberc_id' => 0,
                            'type' => $key,
                            'order_goods_id' => 0,
                            'order_type' => $order_type,
                            'goods_type' => $goods_type,
                            'order_id' => 0,
                            "store_order_id" => $order_id, //订单id
                            'order_price' => $order['money'],
                            'goods_id' =>   0,
                            'goods_price' =>  0,
                            'money' => $money,
                            "performance" => $performance,
                            'account_log_id' => 0
                        ];

                        break;
                }
            }

            loggingHelper::writeLog('diandi_hub', 'OrderAccount', '奖励总订单写入记录分析', $data);

            foreach ($data as $acorder => $list) {
                $_HubAccountOrder = clone $HubAccountOrder;

                $_HubAccountOrder->setAttributes($list);
                if ($_HubAccountOrder->load($list, '') && $_HubAccountOrder->save()) {
                    loggingHelper::writeLog('diandi_hub', 'OrderAccount', '奖励总订单写入成功', $list);
                } else {
                    $msg = ErrorsHelper::getModelError($_HubAccountOrder);
                    loggingHelper::writeLog('diandi_hub', 'OrderAccount', '奖励总订单写入失败', $msg);
                }
            }
        } elseif (OrderTypeStatus::getValueByName('在线订单') == $order_type) {
            // 团队收益(分销) 2%
            loggingHelper::writeLog('diandi_hub', 'OrderAccount', '在线订单', $order_type);
            foreach ($goodsAll as $type => $goods) {
                $goodsMoney = $goods['goods_price'];
                $goods_id = $goods['goods_id'];
                $goods_spec_id = $goods['goods_spec_id'];
                $order_goods_id = $goods['order_goods_id'];
                $goods_type = $goods['goods_type'];
                $total_price = $goods['total_price'];
                $goods_price = $goods['goods_price'];
                $performance = 0;

                $goods_costprice = floatval($goods_costprices[$goods_id]);
                loggingHelper::writeLog('diandi_hub', 'OrderAccount', '店主冻结资金', [
                    'member_id' => $store_member_id,
                    'goods_costprice' => $goods_costprice
                ]);

                $change_type = AccountChangeStatus::getValueByName('冻结');
                $account_type = AccountTypeStatus::getValueByName('店铺待发放');

                // 店主资金明细写入
                $account_log_id  =  logAccount::addorderMoneyLog($store_member_id, $order_id, $goods_costprice, $order_goods_id, $change_type, $account_type, $order_type, $goods['goods_type'], $orderDetail['total_price'], $goods_id, $goods['goods_price'], $performance);

                if ($account_log_id) {
                    loggingHelper::writeLog('diandi_hub', 'OrderAccount', '店主资金操作数据', [
                        'member_id' => $store_member_id,
                        'fileds' => 'store_freeze',
                        'goods_costprice' => $goods_costprice
                    ]);


                    //  店铺冻结资金增加
                    $Res = MemberService::updateAccountBymid($store_member_id, 'store_freeze', $goods_costprice, $account_log_id);

                    loggingHelper::writeLog('diandi_hub', 'OrderAccount', '店主资金操作结果', $Res);
                }


                foreach ($Earnings as $key => $typeStr) {
                    switch ($key) {
                        case EarningsStatus::getValueByName('分销收益'):
                            // 获取礼包商品数据


                            break;
                        case EarningsStatus::getValueByName('团队收益'):



                            break;
                        case EarningsStatus::getValueByName('代理收益'):
                            //    暂时不管

                            break;

                        case EarningsStatus::getValueByName('店铺流水收益'):

                            if ($goods['store_id'] == yii::$app->params['global_store_id']) {
                                $is_self = true;
                            } else {
                                $is_self = false;
                            }

                            $storeDis = levelService::checkStoreDis($store_member_id, $member_id, $goodsMoney, $is_self);
                            loggingHelper::writeLog('diandi_hub', 'OrderAccount', '流水奖励结果', $storeDis);
                            $money = 0;
                            foreach ($storeDis as $mid => $selfMoney) {

                                $money += $selfMoney;
                                // 资金变化类型
                                $change_type = AccountChangeStatus::getValueByName('冻结');
                                // 资金类型
                                $account_type = AccountTypeStatus::getValueByName('流水奖金待发放');

                                // 团队奖励资金日志写入
                                $account_log_id  = logAccount::addorderMoneyLog($mid, $order_id, $selfMoney, $order_goods_id, $change_type, $account_type, $order_type, $goods['goods_type'], $orderDetail['total_price'], $goods_id, $goods['goods_price'], $performance);

                                MemberService::updateAccountBymid($mid, 'team_freeze', $selfMoney, $account_log_id);


                                $member_level   = HubMemberLevel::find()->where(['member_id' => $member_id])->select('level_num')->scalar();

                                $memberc_level   = HubMemberLevel::find()->where(['member_id' => $mid])->select('level_num')->scalar();


                                // 等级明细
                                $data[$goods_id][$mid][] = [
                                    'is_count' => 0,
                                    'status'    => AccountAudit::getValueByName('冻结'),
                                    'member_id' => $member_id,
                                    'memberc_id' => $mid,
                                    'member_level' => $member_level,
                                    'memberc_level' => $memberc_level,
                                    'type' => $key,
                                    'order_goods_id' => $order_goods_id,
                                    'order_type' => $order_type,
                                    'goods_type' => $goods['goods_type'],
                                    'order_id' => $order_id,
                                    'order_price' => $orderDetail['total_price'],
                                    'goods_id' => $goods['goods_id'],
                                    'goods_price' =>  $goods['goods_price'],
                                    'money' => $selfMoney,
                                    "performance" => $performance,
                                    'account_log_id' => $account_log_id


                                ];
                            }

                            // 总团队汇总收益
                            $data[$goods_id][$mid][] = [
                                'is_count' => 1,
                                'status'    => AccountAudit::getValueByName('冻结'),
                                'member_id' => $member_id,
                                'member_level' => $member_level,
                                'memberc_level' => 0,
                                'memberc_id' => 0,
                                'type' => $key,
                                'order_goods_id' => $order_goods_id,
                                'order_type' => $order_type,
                                'goods_type' => $goods['goods_type'],
                                'order_id' => $order_id,
                                'order_price' => $orderDetail['total_price'],
                                'goods_id' => $goods['goods_id'],
                                'goods_price' =>  $goods['goods_price'],
                                'money' => $money,
                                "performance" => $performance,
                                'account_log_id' => 0

                            ];

                            break;
                    }
                }

                loggingHelper::writeLog('diandi_hub', 'OrderAccount', '奖励总订单写入记录分析', $data[$goods_id]);

                foreach ($data[$goods_id] as $acorder => $dataItem) {
                    foreach ($dataItem as $key => $list) {
                        $_HubAccountOrder = clone $HubAccountOrder;
                        $list['is_refund'] = 0;
                        $_HubAccountOrder->setAttributes($list);
                        if ($_HubAccountOrder->load($list, '') && $_HubAccountOrder->save()) {
                            loggingHelper::writeLog('diandi_hub', 'OrderAccount', '奖励总订单写入成功', $list);
                        } else {
                            $msg = ErrorsHelper::getModelError($_HubAccountOrder);
                            loggingHelper::writeLog('diandi_hub', 'OrderAccount', '奖励总订单写入失败', $msg);
                        }
                    }
                }
            }
        } elseif (OrderTypeStatus::getValueByName('自营订单') == $order_type) {
            // 团队等级收益 + 团队收益(分销) 2%
            loggingHelper::writeLog('diandi_hub', 'OrderAccount', '自营订单', $order_type);

            // 自营订单做补贴
            foreach ($goodsAll as $type => $goods) {
                $goodsMoney = $goods['goods_price'];
                $goods_id = $goods['goods_id'];
                $goods_spec_id = $goods['goods_spec_id'];
                $order_goods_id = $goods['order_goods_id'];
                $goods_type = $goods['goods_type'];
                $total_price = $goods['total_price'];
                $goods_price = $goods['goods_price'];
                $performance = 0;

                $goods_costprice = floatval($goods_costprices[$goods_id]);
                loggingHelper::writeLog('diandi_hub', 'OrderAccount', '店主冻结资金', [
                    'member_id' => $store_member_id,
                    'goods_costprice' => $goods_costprice
                ]);



                // 资金变化类型
                $change_type = AccountChangeStatus::getValueByName('冻结');

                $account_type = AccountTypeStatus::getValueByName('店铺待发放');

                // 店主资金明细写入
                $account_log_id  =  logAccount::addorderMoneyLog($store_member_id, $order_id, $goods_costprice, $order_goods_id, $change_type, $account_type, $order_type, $goods['goods_type'], $orderDetail['total_price'], $goods_id, $goods['goods_price'], $performance);

                if ($account_log_id) {
                    loggingHelper::writeLog('diandi_hub', 'OrderAccount', '店主资金操作数据', [
                        'member_id' => $store_member_id,
                        'fileds' => 'store_freeze',
                        'goods_costprice' => $goods_costprice
                    ]);


                    //  店铺冻结资金增加
                    $Res = MemberService::updateAccountBymid($store_member_id, 'store_freeze', $goods_costprice, $account_log_id);

                    loggingHelper::writeLog('diandi_hub', 'OrderAccount', '店主资金操作结果', $Res);
                }

                foreach ($Earnings as $key => $typeStr) {
                    switch ($key) {
                        case EarningsStatus::getValueByName('分销收益'):
                            // 获取礼包商品数据


                            break;
                        case EarningsStatus::getValueByName('团队收益'):



                            break;
                        case EarningsStatus::getValueByName('代理收益'):
                            //    暂时不管
                            break;

                        case EarningsStatus::getValueByName('店铺流水收益'):




                            if ($goods['store_id'] == yii::$app->params['global_store_id']) {
                                $is_self = true;
                            } else {
                                $is_self = false;
                            }


                            $storeDis = levelService::checkStoreDis($store_member_id, $member_id, $goodsMoney, $is_self);

                            $money = 0;
                            foreach ($storeDis as $mid => $selfMoney) {

                                $money += $selfMoney;

                                // 资金类型
                                $account_type = AccountTypeStatus::getValueByName('流水奖金待发放');

                                // 团队奖励资金日志写入
                                $account_log_id  =  logAccount::addorderMoneyLog($mid, $order_id, $selfMoney, $order_goods_id, $change_type, $account_type, $order_type, $goods['goods_type'], $orderDetail['total_price'], $goods_id, $goods['goods_price'], $performance);


                                MemberService::updateAccountBymid($mid, 'team_freeze', $selfMoney, $account_log_id);

                                $member_level   = HubMemberLevel::find()->where(['member_id' => $member_id])->select('level_num')->scalar();

                                $memberc_level   = HubMemberLevel::find()->where(['member_id' => $mid])->select('level_num')->scalar();


                                // 等级明细
                                $data[$goods_id][$mid][] = [
                                    'is_count' => 0,
                                    'status'    => AccountAudit::getValueByName('冻结'),
                                    'member_id' => $member_id,
                                    'memberc_id' => $mid,
                                    'member_level' => $member_level,
                                    'memberc_level' => $memberc_level,
                                    'type' => $key,
                                    'order_goods_id' => $order_goods_id,
                                    'order_type' => $order_type,
                                    'goods_type' => $goods['goods_type'],
                                    'order_id' => $order_id,
                                    'order_price' => $orderDetail['total_price'],
                                    'goods_id' => $goods['goods_id'],
                                    'goods_price' =>  $goods['goods_price'],
                                    'money' => $selfMoney,
                                    "performance" => $performance,
                                    'account_log_id' => $account_log_id


                                ];
                            }

                            // 总团队汇总收益
                            $data[$goods_id][$mid][] = [
                                'is_count' => 1,
                                'status'    => AccountAudit::getValueByName('冻结'),
                                'member_id' => $member_id,
                                'member_level' => $member_level,
                                'memberc_level' => 0,
                                'memberc_id' => 0,
                                'type' => $key,
                                'order_goods_id' => $order_goods_id,
                                'order_type' => $order_type,
                                'goods_type' => $goods['goods_type'],
                                'order_id' => $order_id,
                                'order_price' => $orderDetail['total_price'],
                                'goods_id' => $goods['goods_id'],
                                'goods_price' =>  $goods['goods_price'],
                                'money' => $money,
                                "performance" => $performance,
                                'account_log_id' => 0

                            ];

                            break;
                    }
                }

                loggingHelper::writeLog('diandi_hub', 'OrderAccount', '奖励总订单写入记录分析', $data[$goods_id]);

                foreach ($data[$goods_id] as $acorder => $dataItem) {
                    foreach ($dataItem as $key => $list) {
                        $_HubAccountOrder = clone $HubAccountOrder;

                        $_HubAccountOrder->setAttributes($list);
                        if ($_HubAccountOrder->load($list, '') && $_HubAccountOrder->save()) {
                            loggingHelper::writeLog('diandi_hub', 'OrderAccount', '奖励总订单写入成功', $list);
                        } else {
                            $msg = ErrorsHelper::getModelError($_HubAccountOrder);
                            loggingHelper::writeLog('diandi_hub', 'OrderAccount', '奖励总订单写入失败', $msg);
                        }
                    }
                }
            }
        } elseif (OrderTypeStatus::getValueByName('尊享订单') == $order_type) {
            // 分销收益、等级收益、团队收益
            loggingHelper::writeLog('diandi_hub', 'OrderAccount', '礼包订单', $order_type);
            loggingHelper::writeLog('diandi_hub', 'OrderAccount', '礼包商品数据', $goodsAll);

            // 获取所有的礼包数据，以商品id做区分
            $giftAll =  HubGift::find()
                ->select(['goods_id', 'performance'])
                ->indexBy('goods_id')
                ->asArray()->all();





            foreach ($goodsAll as $type => $goods) {
                $goods_id = $goods['goods_id'];
                $goods_spec_id = $goods['goods_spec_id'];
                $order_goods_id = $goods['order_goods_id'];

                // 礼包按照业绩分红，做特殊处理
                $performance = $giftAll[$goods_id]['performance'];

                $goods_costprice = floatval($goods_costprices[$goods_id]);
                loggingHelper::writeLog('diandi_hub', 'OrderAccount', '店主冻结资金', [
                    'member_id' => $store_member_id,
                    'goods_costprice' => $goods_costprice
                ]);



                // 资金变化类型
                $change_type = AccountChangeStatus::getValueByName('冻结');

                $account_type = AccountTypeStatus::getValueByName('店铺待发放');

                // 店主资金明细写入
                $account_log_id  =  logAccount::addorderMoneyLog($store_member_id, $order_id, $goods_costprice, $order_goods_id, $change_type, $account_type, $order_type, $goods['goods_type'], $orderDetail['total_price'], $goods_id, $goods['goods_price'], $performance);

                if ($account_log_id) {
                    loggingHelper::writeLog('diandi_hub', 'OrderAccount', '店主资金操作数据', [
                        'member_id' => $store_member_id,
                        'fileds' => 'store_freeze',
                        'goods_costprice' => $goods_costprice
                    ]);


                    //  店铺冻结资金增加
                    $Res = MemberService::updateAccountBymid($store_member_id, 'store_freeze', $goods_costprice, $account_log_id);

                    loggingHelper::writeLog('diandi_hub', 'OrderAccount', '店主资金操作结果', $Res);
                }



                foreach ($Earnings as $key => $typeStr) {
                    switch ($key) {
                        case EarningsStatus::getValueByName('分销收益'):
                            // 获取礼包商品数据
                            $giftInfo = GiftService::getGiftInfo($goods_id, 'gift');

                            $MoneyConfig = levelService::checkLevelDis($member_id, $giftInfo['gift']['level_num']);

                            loggingHelper::writeLog('diandi_hub', 'OrderAccount', '分销收益商品核算', $MoneyConfig);
                            $moneyTotal = 0;

                            foreach ($MoneyConfig as $mid => $radio) {
                                $performance = str_replace(",", ".", $performance);
                                $radio = str_replace(",", ".", $radio);
                                $money = floatval($performance) * floatval($radio);
                                loggingHelper::writeLog('diandi_hub', 'OrderAccount', '更新上级冻结金额', [
                                    $mid => $mid,
                                    $money => $money,
                                    'performance' => $performance,
                                    'radio' => $radio,
                                ]);

                                // 资金变化类型
                                $change_type = AccountChangeStatus::getValueByName('冻结');
                                // 资金类型
                                $account_type = AccountTypeStatus::getValueByName('分享待发放');
                                loggingHelper::writeLog('diandi_hub', 'OrderAccount', '开始写入资金变化日志', [
                                    $mid, $order_id, $money, $order_goods_id, $change_type, $order_type, $goods['goods_type'], $orderDetail['total_price'], $goods_id, $goods['goods_price']
                                ]);



                                // 分销资金日志写入
                                $account_log_id  = logAccount::addorderMoneyLog($mid, $order_id, $money, $order_goods_id, $change_type, $account_type, $order_type, $goods['goods_type'], $orderDetail['total_price'], $goods_id, $goods['goods_price'], $performance);



                                // 更新个人冻结金额
                                if ($account_log_id) {
                                    $moneyTotal += $money;
                                    $isUp = MemberService::updateAccountBymid($mid, 'self_freeze', $money, $account_log_id);
                                }

                                $member_level   = HubMemberLevel::find()->where(['member_id' => $member_id])->select('level_num')->scalar();

                                $memberc_level   = HubMemberLevel::find()->where(['member_id' => $mid])->select('level_num')->scalar();


                                // 单人明细
                                $data[$goods_id][$mid][] = [
                                    'is_count' => 0,
                                    'status'    => AccountAudit::getValueByName('冻结'),
                                    'member_id' => $member_id,
                                    'memberc_id' => $mid,
                                    'member_level' => $member_level,
                                    'memberc_level' => $memberc_level,
                                    'type' => $key,
                                    'order_goods_id' => $order_goods_id,
                                    'order_type' => $order_type,
                                    'goods_type' => $goods['goods_type'],
                                    'order_id' => $order_id,
                                    'order_price' => $orderDetail['total_price'],
                                    'goods_id' => $goods['goods_id'],
                                    'goods_price' =>  $goods['goods_price'],
                                    'money' => $money,
                                    "performance" => $performance,
                                    'account_log_id' => $account_log_id


                                ];
                            }

                            // 分销汇总
                            $data[$goods_id][$mid][] = [
                                'is_count' => 1,
                                'status'    => AccountAudit::getValueByName('冻结'),
                                'member_id' => $member_id,
                                'member_level' => $member_level,
                                'memberc_level' => 0,
                                'memberc_id' => 0,
                                'type' => $key,
                                'order_goods_id' => $order_goods_id,
                                'order_type' => $order_type,
                                'goods_type' => $goods['goods_type'],
                                'order_id' => $order_id,
                                'order_price' => $orderDetail['total_price'],
                                'goods_id' => $goods['goods_id'],
                                'goods_price' =>  $goods['goods_price'],
                                'money' => $moneyTotal,
                                "performance" => $performance,
                                'account_log_id' => 0

                            ];

                            loggingHelper::writeLog('diandi_hub', 'OrderAccount', '分销财务数据', $data);


                            break;
                        case EarningsStatus::getValueByName('团队收益'):

                            $goods_id = $goods['goods_id'];

                            //  根据商品id获取礼包信息
                            $giftInfo = GiftService::getGiftInfo($goods_id, 'gift');

                            // 返回礼包的等级对应的比例参数
                            $Teamradio = levelService::checkTeamDis($member_id, $giftInfo['gift']['level_num']);

                            loggingHelper::writeLog('diandi_hub', 'OrderAccount', '团队收益商品核算', $Teamradio);
                            $money = 0;
                            foreach ($Teamradio as $mid => $radio) {
                                $performance = str_replace(",", ".", $performance);
                                $radio = str_replace(",", ".", $radio);
                                $TeamMoney = floatval($performance) * floatval($radio);
                                $money += $TeamMoney;
                                // 资金变化类型
                                $change_type = AccountChangeStatus::getValueByName('冻结');
                                // 资金类型
                                $account_type = AccountTypeStatus::getValueByName('团队待发放');

                                // 团队奖励资金日志写入
                                $account_log_id  =  logAccount::addorderMoneyLog($mid, $order_id, $TeamMoney, $order_goods_id, $change_type, $account_type, $order_type, $goods['goods_type'], $orderDetail['total_price'], $goods_id, $goods['goods_price'], $performance);

                                MemberService::updateAccountBymid($mid, 'team_freeze', $TeamMoney, $account_log_id);

                                $member_level   = HubMemberLevel::find()->where(['member_id' => $member_id])->select('level_num')->scalar();

                                $memberc_level   = HubMemberLevel::find()->where(['member_id' => $mid])->select('level_num')->scalar();


                                // 等级明细
                                $data[$goods_id][$mid][] = [
                                    'is_count' => 0,
                                    'status'    => AccountAudit::getValueByName('冻结'),
                                    'member_id' => $member_id,
                                    'memberc_id' => $mid,
                                    'member_level' => $member_level,
                                    'memberc_level' => $memberc_level,
                                    'type' => $key,
                                    'order_goods_id' => $order_goods_id,
                                    'order_type' => $order_type,
                                    'goods_type' => $goods['goods_type'],
                                    'order_id' => $order_id,
                                    'order_price' => $orderDetail['total_price'],
                                    'goods_id' => $goods['goods_id'],
                                    'goods_price' =>  $goods['goods_price'],
                                    'money' => $TeamMoney,
                                    "performance" => $performance,
                                    'account_log_id' => $account_log_id

                                ];
                            }

                            // 总团队汇总收益
                            $data[$goods_id][$mid][] = [
                                'is_count' => 1,
                                'status'    => AccountAudit::getValueByName('冻结'),
                                'member_id' => $member_id,
                                'memberc_id' => 0,
                                'member_level' => $member_level,
                                'memberc_level' => 0,
                                'type' => $key,
                                'order_goods_id' => $order_goods_id,
                                'order_type' => $order_type,
                                'goods_type' => $goods['goods_type'],
                                'order_id' => $order_id,
                                'order_price' => $orderDetail['total_price'],
                                'goods_id' => $goods['goods_id'],
                                'goods_price' =>  $goods['goods_price'],
                                'money' => $money,
                                "performance" => $performance,
                                'account_log_id' => 0

                            ];

                            break;
                        case EarningsStatus::getValueByName('代理收益'):
                            //    暂时不管
                            break;

                        case EarningsStatus::getValueByName('店铺流水收益'):


                            // $goods_costprice = floatval($goods_costprices[$goods_id]);
                            // loggingHelper::writeLog('diandi_hub', 'OrderAccount', '店主冻结资金',[
                            //     'member_id'=>$store_member_id,
                            //     'goods_costprice'=>$goods_costprice
                            // ]);

                            // if($goods['store_id'] == yii::$App->params['global_store_id']){
                            //     $is_self = true;     
                            // }else{
                            //     $is_self = false;
                            // } 

                            // $storeDis = levelService::checkStoreDis($store_member_id,$member_id,$goods_costprice,$is_self);

                            // $money = 0;
                            // foreach ($storeDis as $mid => $selfMoney) {

                            //     $money += $selfMoney;
                            //      // 资金变化类型
                            //     $change_type = AccountChangeStatus::getValueByName('冻结');
                            //     // 资金类型
                            //     $account_type = AccountTypeStatus::getValueByName('流水奖金待发放');

                            //     // 团队奖励资金日志写入
                            //     $account_log_id  =  logAccount::addorderMoneyLog($mid,$order_id,$selfMoney,$order_goods_id,$change_type,$account_type,$order_type,$goods['goods_type'],$orderDetail['total_price'],$goods_id,$goods['goods_price'],$performance);   

                            //     MemberService::updateAccountBymid($mid,'team_freeze',$selfMoney,$account_log_id);

                            //     $member_level   = HubMemberLevel::find()->where(['member_id'=>$member_id])->select('level_num')->scalar(); 

                            //     $memberc_level   = HubMemberLevel::find()->where(['member_id'=>$mid])->select('level_num')->scalar(); 

                            //     // 等级明细
                            //     $data[$goods_id][$mid][] = [
                            //         'is_count'=>0,
                            //         'status'    => AccountAudit::getValueByName('冻结'),
                            //         'member_id' => $member_id,
                            //         'memberc_id' => $mid,
                            //         'member_level' => $member_level,
                            //         'memberc_level' => $memberc_level,
                            //         'type' => $key,
                            //         'order_goods_id'=>$order_goods_id,
                            //         'order_type' => $order_type,
                            //         'goods_type' => $goods['goods_type'],
                            //         'order_id' => $order_id,
                            //         'order_price' => $orderDetail['total_price'],
                            //         'goods_id' => $goods['goods_id'],
                            //         'goods_price' =>  $goods['goods_price'],
                            //         'money'=>$selfMoney,
                            //         "performance"=>$performance,
                            //         'account_log_id'=>$account_log_id 

                            //     ];

                            // }

                            // // 总团队汇总收益
                            // $data[$goods_id][$mid][] = [
                            //     'is_count'=>1,
                            //     'status'    => AccountAudit::getValueByName('冻结'),
                            //     'member_id' => $member_id,
                            //     'memberc_id' => 0,
                            //     'member_level' => $member_level,
                            //     'memberc_level' => 0,
                            //     'type' => $key,
                            //     'order_goods_id'=>$order_goods_id,
                            //     'order_type' => $order_type,
                            //     'goods_type' => $goods['goods_type'],
                            //     'order_id' => $order_id,
                            //     'order_price' => $orderDetail['total_price'],
                            //     'goods_id' => $goods['goods_id'],
                            //     'goods_price' =>  $goods['goods_price'],
                            //     'money'=>$money,
                            //     "performance"=>$performance,
                            //     'account_log_id'=>0

                            // ];




                            // continue;

                            break;
                    }
                }

                loggingHelper::writeLog('diandi_hub', 'OrderAccount', '奖励总订单写入记录分析', $data[$goods_id]);

                foreach ($data[$goods_id] as $acorder => $dataItem) {
                    foreach ($dataItem as $key => $list) {
                        $_HubAccountOrder = clone $HubAccountOrder;

                        $_HubAccountOrder->setAttributes($list);
                        if ($_HubAccountOrder->load($list, '') && $_HubAccountOrder->save()) {
                            loggingHelper::writeLog('diandi_hub', 'OrderAccount', '奖励总订单写入成功', $list);
                        } else {
                            $msg = ErrorsHelper::getModelError($_HubAccountOrder);
                            loggingHelper::writeLog('diandi_hub', 'OrderAccount', '奖励总订单写入失败', $msg);
                        }
                    }
                }
            }
        }
    }

    /**
     * 订单分销佣金总额 function
     * @param [type] $goods_id          商品id
     * @param [type] $goods_spec_id     商品属性id
     * @param [type] $team_level1       一级的团队等级
     * @param [type] $team_level2       二级的团队等级
     * @param [type] $team_level3       三级的团队等级
     * @return void
     */
    public static function getDisMoney($goods_id, $goods_spec_id, $team_level1, $team_level2, $team_level3)
    {
        // 我的团队等级
        $my_level_num = self::$my_level_num;

        // 我的分销一级的团队等级
        $dis_level_num1 = self::$dis_level_num1;

        // 我的分销二级的团队等级
        $dis_level_num2 = self::$dis_level_num2;

        // 我的分销三级的团队等级
        $dis_level_num13 = self::$dis_level_num3;

        $order_type = 1;

        // 商品分销佣金总和
        $levelCount = GoodsAccount::disLevelCount($goods_id, $goods_spec_id, $order_type);
    }

    // 订单等级佣金总额
    public static function getLevelMoney($goods_id, $goods_spec_id, $team_level1, $team_level2, $team_level3)
    {
        return 1;
    }




    // 订单区域佣金总额
    public static function getAreaMoney($goods_id, $goods_spec_id, $team_level1, $team_level2, $team_level3)
    {
        return 1;
    }

    // 礼包财务数据写入
    public static function addGiftCount()
    {
    }

    // 等级财务数据写入
    public static function addLevelCount()
    {
    }

    // 店铺财务数据写入
    public static function addStoreCount()
    {
    }

    // 团队财务数据写入
    public static function addTeamCount()
    {
    }

    // 订单资金变动日志写入
    public static function addLogCount()
    {
    }


    public static function getLevelInfo($user_id)
    {
        // 团队等级
        // 分销等级
        // 我的等级    
    }

    // 补贴金额计算
    public static function addSubsidies($order_id)
    {

        // 礼包不补贴
        $order     =    OrderService::detail($order_id);

        $money = $order['total_price'];
        $member_id = $order['user_id'];
        $order_goods_id = 0;
        $order_type =  $order['order_type'];
        $goods_type = 0;
        $total_price = $order['total_price'];
        $goods_id = 0;
        $goods_price = 0;


        loggingHelper::writeLog('diandi_hub', 'OrderAccount/addSubsidies', '订单开始补贴', $order_id);


        if ($order['is_rebate'] == 1) {
            // 订单资金已解冻，不能重复
            loggingHelper::writeLog('diandi_hub', 'OrderAccount/addSubsidies', '订单开始补贴重复被终止', $order_id);

            return false;
        }

        if ($order_type == OrderTypeStatus::getValueByName('尊享订单')) {

            loggingHelper::writeLog('diandi_hub', 'OrderAccount/addSubsidies', '礼包不补贴', $order_id);

            return false;
        }


        loggingHelper::writeLog('diandi_hub', 'OrderAccount/addSubsidies', '用户补贴开始计算', [
            $order_id, $money, $member_id, $order_goods_id, $order_type, $goods_type, $total_price, $goods_id, $goods_price
        ]);

        // 获取店铺信息
        $store_id = Yii::$app->params['store_id'];

        // 获取商品补贴参数
        $Redio = HubGoodsSubsidy::find()->where(['goods_id' => $goods_id])->one();

        if (!empty($Redio)) {
            $agemoney   = $Redio['provide_redio'];
            $moneyradio = $Redio['money_redio'];
            $douradio   = $Redio['integral_redio'];
        } else {

            $store = Yii::$app->service->commonGlobalsService->getStoreDetail($store_id);

            loggingHelper::writeLog('diandi_hub', 'OrderAccount/addSubsidies', '商品补贴参数', [
                'agemoney'   => $store['agemoney'],
                'moneyradio' => $store['moneyradio'],
                'douradio'   => $store['douradio']
            ]);

            $agemoney   = $store['agemoney'];
            $moneyradio = $store['moneyradio'];
            $douradio   = $store['douradio'];

            loggingHelper::writeLog('diandi_hub', 'OrderAccount/addSubsidies', '店铺补贴参数获取', [
                'agemoney'   => $agemoney,
                'moneyradio' => $moneyradio,
                'douradio'   => $douradio
            ]);
        }

        $credit1    = $money * floatval($moneyradio); //我的补贴金额
        $credit2   =  $money * floatval($agemoney); //养老金
        $user_integral =  intval($money * $douradio);

        //保留两位数 
        $credit1    = StringHelper::currency_format($credit1); //我的补贴金额
        $credit2   =  StringHelper::currency_format($credit2); //养老金

        loggingHelper::writeLog('diandi_hub', 'OrderAccount/addSubsidies', '用户补贴计算结果', [
            'credit1'    =>  $credit1, //我的补贴金额
            'credit2'   =>  $credit2, //养老金
            'user_integral' =>  $user_integral,
            'member_id' => $member_id
        ]);




        $change_type = AccountChangeStatus::getValueByName('补贴消费');

        $account_type = AccountTypeStatus::getValueByName('余额');

        $account_log_id  = logAccount::addorderMoneyLog($member_id, $order_id, $credit1, $order_goods_id, $change_type, $account_type, $order_type, $goods_type, $total_price, $goods_id, $goods_price);

        loggingHelper::writeLog('diandi_hub', 'OrderAccount/addSubsidies', '补贴credit1 日志ID', $account_log_id);

        if ($account_log_id) {
            $Res = MemberService::updateAccountBymid($member_id, 'credit1', $credit1, $account_log_id);
        }

        // 补贴资金日志写入
        $change_type = AccountChangeStatus::getValueByName('补贴养老');

        $account_type = AccountTypeStatus::getValueByName('金库');
        $account_log_id  =  logAccount::addorderMoneyLog($member_id, $order_id, $credit2, $order_goods_id, $change_type, $account_type, $order_type, $goods_type, $total_price, $goods_id, $goods_price);

        if ($account_log_id) {
            $Res = MemberService::updateAccountBymid($member_id, 'credit2', $credit2, $account_log_id);
            loggingHelper::writeLog('diandi_hub', 'OrderAccount/addSubsidies', '补贴credit2 结果', $Res);
        }

        $change_type = AccountChangeStatus::getValueByName('补贴团豆');

        $account_type = AccountTypeStatus::getValueByName('团豆');
        $account_log_id  = logAccount::addorderMoneyLog($member_id, $order_id, $user_integral, $order_goods_id, $change_type, $account_type, $order_type, $goods_type, $total_price, $goods_id, $goods_price);


        if ($account_log_id) {

            $Res = MemberService::updateAccountBymid($member_id, 'user_integral', $user_integral, $account_log_id);
            loggingHelper::writeLog('diandi_hub', 'OrderAccount/addSubsidies', '补贴user_integral 结果', $Res);
        }

        HubOrder::updateAll(['is_rebate' => 1], ['order_id' => $order_id]);
        loggingHelper::writeLog('diandi_hub', 'OrderAccount/addSubsidies', '订单补贴完成', $order_id);
    }

    // 计算销售额

    public static function getSaleCountBymid($member_id, $levelcnum = 0)
    {
        if (intval($levelcnum) > 0) {

            $teams = levelService::getLevelChild($member_id, $levelcnum);
            $team_ids = array_column($teams, 'member_id');
        } else {
            $team_ids = levelService::getAllChild($member_id, '');
        }
        $order_type = OrderTypeStatus::getValueByName('尊享订单');
        $goods_type = GoodsTypeStatus::getValueByName('礼包商品');

        $where = [
            'member_id' => $team_ids,
            'order_type' => $order_type,
            'goods_type' => $goods_type
        ];



        //下单人当前团队销售总额
        $self_teamsale =  HubAccountOrder::find()->where($where)->sum('goods_price');
        //当前累计消费
        $self_selfsale =  HubAccountOrder::find()->where([
            'member_id' => $member_id,
            'order_type' => $order_type,
            'goods_type' => $goods_type
        ])->sum('goods_price');

        return [];
    }


    /**
     * Undocumented function
     * @param [type] $user_id   用户id
     * @param [type] $order_status 1 冻结 2 无效 3 已审核 4 已申请 5 待打款 6 已打款
     * @param [type] $pageSize  每页显示的数量
     * @return void
     */
    public static function list($order_type, $type, $user_id, $order_status, $pageSize)
    {
        $page = Yii::$app->request->get('page');

        $where = []; //初始化条件数组

        // 根据受益人查询
        $where['memberc_id'] = $user_id;
        $where['order_type'] = $order_type;
        $where['type'] = $type;

        if (is_numeric($order_status)) {
            $where['status'] = $order_status;
        }

        // 是否是汇总订单0分1汇总
        $where['is_count'] = 0;

        // 创建一个 DB 查询来获得所有
        $query = HubAccountOrder::find()->where($where)->andWhere(['>', 'money', 0])->with([
            'orderGoods' => function ($query) {
                $query->select(['goods_id', 'total_num', 'order_goods_id', 'bloc_id', 'store_id', 'goods_type', 'thumb', 'goods_price', 'line_price', 'stock_up', 'goods_weight', 'total_price', 'goods_name', 'goods_attr']);
            }, 'order', 'goodsShare', 'goodsSpecRel', 'goodsSpec',
            'goods' => function ($query) {
                $query->select(['goods_id', 'goods_name', 'stock', 'spec_type', 'deduct_stock_type', 'thumb', 'line_price', 'goods_weight', 'goods_price', 'sales_initial', 'sales_actual', 'delivery_id', 'goods_status', 'goods_costprice', 'goods_type', 'images']);
            }
        ])->orderBy('create_time desc');

        // p($query->createCommand()->getRawSql());

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

            $item['goods']['thumb'] = ImageHelper::tomedia($item['goods']['thumb']);

            $item['status_label'] = OrderStatus::getLabel($item['order_status']);
        }

        return $list;
    }

    /**
     * 确认收货收资金解冻处理
     * @param [type] $order_id 订单ID
     * @return void
     */
    public static  function thawMoney($order_id)
    {
        $order     =    OrderService::detail($order_id);
        loggingHelper::writeLog('diandi_hub', 'OrderAccount/thawMoney', '订单资金开始解冻', $order_id);

        if ($order['is_money'] == 1) {
            // 订单资金已解冻，不能重复
            loggingHelper::writeLog('diandi_hub', 'OrderAccount/thawMoney', '订单资金重复解冻', $order_id);

            return false;
        }

        $member_id = $order['user_id'];
        $goodsAll  = $order['goods'];
        // 获取结算商户用户id
        $store_id = $order['store_id'];

        $money_uids = HubMemberLevel::find()->where([
            'is_store' => 1,
        ])->where("FIND_IN_SET({$store_id},member_store_id)")->select(['member_id'])->asArray()->one();

        loggingHelper::writeLog('diandi_hub', 'OrderAccount/thawMoney', '获取店主信息', $money_uids);

        loggingHelper::writeLog('diandi_hub', 'OrderAccount/thawMoney', '所有商品', $goodsAll);

        // 非余额支付进行补贴
        if ($order['pay_type'] != PayTypeStatus::getValueByName('余额支付')) {
            // 计算补贴
            self::addSubsidies($order_id);
        }

        $goods_ids = array_column($goodsAll, 'goods_id');

        $gifts = HubGift::find()->where(['IN', 'goods_id', $goods_ids])->select(['performance', 'goods_id'])->indexBy('goods_id')->all();

        // 补贴金额
        foreach ($goodsAll as $type => $goods) {
            $money = $goods['goods_price'];
            $goods_id = $goods['goods_id'];
            $goods_spec_id = $goods['goods_spec_id'];
            $order_goods_id = $goods['order_goods_id'];
            $goods_type = $goods['goods_type'];
            $total_price = $goods['total_price'];
            $goods_price = $goods['goods_price'];
            $order_type  = $order['order_type'];

            $goods_costprice = $goods['goods_costprice'];

            if (!empty($money_uids)) {


                loggingHelper::writeLog('diandi_hub', 'OrderAccount/thawMoney', '店主解冻资金', [
                    'member_id' => $money_uids['member_id'],
                    'goods_costprice' => $goods_costprice
                ]);

                // store_money	decimal			店铺收益
                // store_freeze	decimal			店铺收益冻结

                $account_type = AccountTypeStatus::getValueByName('店铺待发放');

                $change_type    =  AccountChangeStatus::getValueByName('解冻');
                $order_price    = $order['total_price'];

                if (!empty($gifts[$goods_id])) {

                    $performance    = $gifts[$goods_id]['performance'];
                } else {

                    $performance = 0;
                }


                $account_log_id  =  logAccount::addorderMoneyLog($money_uids['member_id'], $order_id, -$goods_costprice, $order_goods_id, $change_type, $account_type, $order_type, $goods_type, $order_price, $goods_id, $goods_price, $performance);

                if ($account_log_id) {

                    MemberService::updateAccountBymid($money_uids['member_id'], 'store_freeze', -$goods_costprice, $account_log_id);
                }

                $account_type = AccountTypeStatus::getValueByName('店铺可提现');

                $account_log_id  =  logAccount::addorderMoneyLog($money_uids['member_id'], $order_id, $goods_costprice, $order_goods_id, $change_type, $account_type, $order_type, $goods_type, $order_price, $goods_id, $goods_price, $performance);

                if ($account_log_id) {

                    MemberService::updateAccountBymid($money_uids['member_id'], 'store_money', $goods_costprice, $account_log_id);
                }
            }
        }
        $HubAccountOrder = new HubAccountOrder();

        // 获取所有分订单财务数据
        $accounts = $HubAccountOrder->find()->where(['order_id' => $order_id, 'is_count' => 0])->andWhere(['!=', 'is_refund', 1])->asArray()->all();

        loggingHelper::writeLog('diandi_hub', 'OrderAccount/thawMoney', '解冻数据', $accounts);

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

            if ($account['type'] == EarningsStatus::getValueByName('分销收益')) {
                loggingHelper::writeLog('diandi_hub', 'OrderAccount/thawMoney', '分销收益start', [
                    'member_id' => $memberc_id,
                    'money' => $money
                ]);

                $account_type = AccountTypeStatus::getValueByName('分享待发放');

                $account_log_id  =  logAccount::addorderMoneyLog($memberc_id, $order_id, -$money, $order_goods_id, $change_type, $account_type, $order_type, $goods_type, $order_price, $goods_id, $goods_price, $performance);

                if ($account_log_id) {


                    $Res1 = MemberService::updateAccountBymid($memberc_id, 'self_freeze', -$money, $account_log_id);
                }


                $account_type = AccountTypeStatus::getValueByName('分享可提现');

                $account_log_id  = logAccount::addorderMoneyLog($memberc_id, $order_id, $money, $order_goods_id, $change_type, $account_type, $order_type, $goods_type, $order_price, $goods_id, $goods_price, $performance);

                if ($account_log_id) {
                    $Res2 = MemberService::updateAccountBymid($memberc_id, 'self_money', $money, $account_log_id);
                }

                loggingHelper::writeLog('diandi_hub', 'OrderAccount/thawMoney', '分销收益end', [
                    'Res2' => $Res2,
                    'Res1' => $Res1
                ]);
            } elseif ($account['type'] == EarningsStatus::getValueByName('团队收益')) {
                loggingHelper::writeLog('diandi_hub', 'OrderAccount/thawMoney', '团队收益start', [
                    'member_id' => $memberc_id,
                    'money' => $money
                ]);

                // team_money	decimal			团队奖金
                // team_freeze	decimal			团队奖金冻结
                $account_type = AccountTypeStatus::getValueByName('团队待发放');

                $account_log_id  =  logAccount::addorderMoneyLog($memberc_id, $order_id, -$money, $order_goods_id, $change_type, $account_type, $order_type, $goods_type, $order_price, $goods_id, $goods_price, $performance);

                if ($account_log_id) {

                    $Res1 = MemberService::updateAccountBymid($memberc_id, 'team_freeze', -$money, $account_log_id);
                }

                $account_type = AccountTypeStatus::getValueByName('团队可提现');

                $account_log_id  =  logAccount::addorderMoneyLog($memberc_id, $order_id, $money, $order_goods_id, $change_type, $account_type, $order_type, $goods_type, $order_price, $goods_id, $goods_price, $performance);

                if ($account_log_id) {
                    $Res2 = MemberService::updateAccountBymid($memberc_id, 'team_money', $money, $account_log_id);
                }

                loggingHelper::writeLog('diandi_hub', 'OrderAccount/thawMoney', '团队收益end', [
                    'Res2' => $Res2,
                    'Res1' => $Res1
                ]);
            } elseif ($account['type'] == EarningsStatus::getValueByName('店铺流水收益')) {
                // team_money	decimal			团队奖金
                // team_freeze	decimal			团队奖金冻结
                $account_type = AccountTypeStatus::getValueByName('流水奖金待发放');

                $account_log_id  =  logAccount::addorderMoneyLog($memberc_id, $order_id, -$money, $order_goods_id, $change_type, $account_type, $order_type, $goods_type, $order_price, $goods_id, $goods_price, $performance);

                if ($account_log_id) {
                    $Res1 = MemberService::updateAccountBymid($memberc_id, 'team_freeze', -$money, $account_log_id);
                }
                $account_type = AccountTypeStatus::getValueByName('流水奖金可提现');


                $account_log_id  =  logAccount::addorderMoneyLog($memberc_id, $order_id, $money, $order_goods_id, $change_type, $account_type, $order_type, $goods_type, $order_price, $goods_id, $goods_price, $performance);

                if ($account_log_id) {
                    $Res2 = MemberService::updateAccountBymid($memberc_id, 'team_money', $money, $account_log_id);
                }

                loggingHelper::writeLog('diandi_hub', 'OrderAccount/thawMoney', '店铺流水收益end', [
                    'Res2' => $Res2,
                    'Res1' => $Res1
                ]);
            } elseif ($account['type'] == EarningsStatus::getValueByName('代理收益')) {
            } elseif ($account['type'] == EarningsStatus::getValueByName('等级收益')) {
            }
        }

        // 更新订单解冻状态
        HubOrder::updateAll(['is_money' => 1], ['order_id' => $order_id]);
        loggingHelper::writeLog('diandi_hub', 'OrderAccount/thawMoney', '订单资金解冻完成', $order_id);

        return true;
    }
}
