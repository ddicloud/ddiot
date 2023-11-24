<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-16 10:30:53
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-23 15:16:38
 */

namespace addons\diandi_tea\services;

use addons\diandi_tea\models\config\TeaGlobalConfig;
use addons\diandi_tea\models\config\TeaHourse;
use addons\diandi_tea\models\marketing\TeaCoupon;
use addons\diandi_tea\models\marketing\TeaMemberCoupon;
use addons\diandi_tea\models\marketing\TeaRecharge;
use addons\diandi_tea\models\marketing\TeaSetMeal;
use addons\diandi_tea\models\order\TeaCouponBuyList;
use addons\diandi_tea\models\order\TeaCouponList;
use addons\diandi_tea\models\order\TeaOrderList;
use addons\diandi_tea\models\order\TeaRechargeList;
use addons\diandi_tea\models\order\TeaSetMealList;
use addons\diandi_tea\models\order\TeaSetMealRenewList;
use addons\diandi_tea\services\jobs\CreateLockPassWord;
use addons\diandi_tea\services\jobs\Noticeobs;
use addons\diandi_tea\services\jobs\Renewobs;
use addons\diandi_tea\services\jobs\TeaSmsJob;
use api\modules\wechat\models\DdWxappFans;
use common\components\addons\AddonsModule;
use common\helpers\ArrayHelper;
use common\helpers\loggingHelper;
use common\helpers\ResultHelper;
use common\helpers\StringHelper;
use common\models\AccountLog;
use common\models\DdMember;
use common\models\DdMemberAccount;
use GuzzleHttp\Exception\GuzzleException;
use Yii;
use yii\db\Exception;

/**
 * diandi_dingzuo module definition class.
 */
class NotifyService extends AddonsModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = "addons\diandi_tea\api";

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();
    }

    // 支付回调
    // {
    //     "appid": "wx028eb56f4b4a7d99",
    //     "bank_type": "OTHERS",
    //     "cash_fee": "5",
    //     "fee_type": "CNY",
    //     "is_subscribe": "N",
    //     "mch_id": "1228641802",
    //     "nonce_str": "5e6be567474bb",
    //     "openid": "oE5EC0aqNTAdAXpPfikBpkHiSG1o",
    //     "out_trade_no": "2020031455505497",
    //     "result_code": "SUCCESS",
    //     "return_code": "SUCCESS",
    //     "sign": "99C78A7B9A9110E9A4EA4D5040596700",
    //     "time_end": "20200314035649",
    //     "total_fee": "5",
    //     "trade_type": "JSAPI",
    //     "transaction_id": "4200000518202003141950666245"
    // }

    /**
     * Undocumented function.
     *
     * @param [type] $params
     *
     * @return array
     * @throws GuzzleException
     * @throws \Throwable
     * @throws Exception
     */
    public static function Notify($params): array
    {
        loggingHelper::writeLog('diandi_tea', 'Notify', '模块内回调', $params);

        $GorderType = StringHelper::msubstr($params['out_trade_no'], 0, 1);
        loggingHelper::writeLog('diandi_tea', 'Notify', '订单类型', $GorderType);

        if ($GorderType == 'H') {
            loggingHelper::writeLog('diandi_tea', 'Notify', '包间下单回调', $GorderType);

            // 包间支付订单 H2020121499549755
            $orderInfo = TeaOrderList::find()->where(['order_number' => $params['out_trade_no']])->with(['hourse'])->asArray()->one();

            loggingHelper::writeLog('diandi_tea', 'Notify', '包间订单详情sql', TeaOrderList::find()->where(['order_number' => $params['out_trade_no']])->createCommand()->getRawSql());
            loggingHelper::writeLog('diandi_tea', 'Notify', '包间订单详情', $orderInfo);
            if ($orderInfo['status'] > 1) {
                if (isset($params['is_auto']) && $params['is_auto'] == 1) {
                    return ResultHelper::json(401, '订单已支付');
                } else {
                    echo ArrayHelper::toXml(['return_code' => 'SUCCESS', 'return_msg' => 'OK']);
                    die;
                }
            }

            //$transaction = DistributionAccountStorePay::getDb()->beginTransaction();
            $transaction = Yii::$app->db->beginTransaction();

            try {
                $balance = DdMemberAccount::find()->where(['member_id' => $orderInfo['member_id']])->select('user_money')->asArray()->one()['user_money'];
                loggingHelper::writeLog('diandi_tea', 'Notify', '包间订单处理', [
                    'order_id' => $orderInfo['id'],
                    'status' => 2,
                    'pay_time' => date('Y-m-d H:i:s'),
                    'balance' => $balance,
                    'transaction_id' => $params['transaction_id'],
                ]);
                //房间密码
                $x = 100000;
                $y = 999999;
                $pwd = rand($x, $y);
                //更新订单状态
                $Res = TeaOrderList::updateAll([
                    'status' => 2,
                    'pwd' => $pwd,
                    'pay_type' => 1,
                    'pay_time' => date('Y-m-d H:i:s'),
                    'balance' => $balance,
                    'transaction_id' => $params['transaction_id'],
                ], ['id' => $orderInfo['id']]);
                loggingHelper::writeLog('diandi_tea', 'Notify', '包间订单处理', $Res);

                //赠送积分
                $memberIntegral = DdMemberAccount::find()->select('user_integral')
                    ->where(['member_id' => $orderInfo['member_id']])->asArray()->one()['user_integral'];
                $memberLevel = DdMember::find()->select('level')
                    ->where(['member_id' => $orderInfo['member_id']])->asArray()->one()['level'];
                $scale = TeaGlobalConfig::find()->select(['mumber_scale', 'vip_scale'])
                    ->where(['store_id' => $orderInfo['store_id']])->asArray()->one();
                if ($scale){
                    if ($memberLevel == 1) {
                        $integral = round($orderInfo['real_pay'] * $scale['mumber_scale'] / 100);
                    } else {
                        $integral = round($orderInfo['real_pay'] * $scale['vip_scale'] / 100);
                    }
                }

                $innn = ['inte' => $integral, 'memberint' => $memberIntegral, 'level' => $memberLevel, 'scale' => $scale, 'money' => $orderInfo['real_pay']];
                loggingHelper::writeLog('diandi_tea', 'integral', '计算积分', $innn);
                if ($integral > 0) {
                    //更改积分
                    DdMemberAccount::updateAllCounters([
                        'user_integral' => $integral,
                        'accumulate_integral' => $integral,
                        'give_integral' => $integral,
                    ], ['member_id' => $orderInfo['member_id']]);
                    //记录系统赠送积分记录
                    $accountLoginfoIntegral = [
                        'member_id' => $orderInfo['member_id'],
                        'account_type' => 'tea_member_give_integral',
                        'money' => $integral,
                        'is_add' => 0,
                        'old_money' => $memberIntegral,
                        'money_id' => $orderInfo['id'],
                        'remark' => '下单赠送积分',
                    ];
                    loggingHelper::writeLog('diandi_tea', 'Notify', '更新系统用户下单赠送积分记录', $accountLoginfoIntegral);
                    self::AccountLog($accountLoginfoIntegral);
                }

                //记录套餐消费记录
                $set_meal = [
                    'title' => $orderInfo['set_meal_name'],
                    'price' => $orderInfo['amount_payable'],
                    'renew_price' => $orderInfo['renew_price'],
                    'order_id' => $orderInfo['id'],
                    'set_meal_id' => $orderInfo['set_meal_id'],
                    'member_id' => $orderInfo['member_id'],
                ];

                loggingHelper::writeLog('diandi_tea', 'Notify', '记录套餐消费记录', $set_meal);
                $set_meal_list_model = new TeaSetMealList();
                $set_meal_list_model->load($set_meal, '');
                $set_meal_list_model->save();

                //下房间开锁订单
                // 派遣器
                // $dispatcher = new DdDispatcher();
                // // 监听器
                // $listener = new DdListener();

                // $subscriber = new LockopenServer();
                // $dispatcher->addSubscriber($subscriber);

                $member_id = $orderInfo['member_id'];
                $password = $pwd;
                $ext_room_id = $orderInfo['hourse_id'];
                $start_time = $orderInfo['start_time'];
                $end_time = $orderInfo['end_time'];
                $ext_order_id = $orderInfo['id'];
                // $event = new LockOrderEvent($ext_order_id, $member_id, $password, $ext_room_id, $start_time, $end_time);
                // $dispatcher->dispatch(LockOrderEvent::EVENT_LOCK_ORDER, $event);

//                $diandiLockSdk = new diandiSdk();
//                $diandiLockSdk->createLockOrder($ext_order_id, $member_id, $password, $ext_room_id, $start_time, $end_time);

                loggingHelper::writeLog('diandi_tea', 'Notify', '房间开锁下单', [$ext_order_id, $member_id, $password, $ext_room_id, $start_time, $end_time]);

                //记录卡券使用记录及增加卡券已使用数量
                if ($orderInfo['coupon_id']) {
                    $coupon_model = TeaCoupon::find()
                        ->select(['name', 'type', 'price'])
                        ->where(['id' => $orderInfo['coupon_id']])
                        ->asArray()
                        ->one();
                    $coupon_list = [
                        'member_id' => $orderInfo['member_id'],
                        'coupon_id' => $orderInfo['coupon_id'],
                        'coupon_name' => $coupon_model['name'],
                        'coupon_type' => $coupon_model['type'],
                        'order_id' => $orderInfo['id'],
                        'price' => $coupon_model['price'],
                    ];
                    //记录卡券使用记录
                    $set_coupon_list_model = new TeaCouponList();
                    $set_coupon_list_model->load($coupon_list, '');
                    $set_coupon_list_model->save();
                    //增加卡券已使用数量
                    TeaCoupon::updateAllCounters(['use_num' => 1], ['id' => $orderInfo['coupon_id']]);
                }

                //添加系统用户消费记录
                $accountLoginfo_money = [
                    'member_id' => $orderInfo['member_id'],
                    'account_type' => 'tea_member_money',
                    'money' => -$orderInfo['real_pay'],
                    'is_add' => 1,
                    'old_money' => 0,
                    'money_id' => $orderInfo['id'],
                    'remark' => '下单现金消费',
                ];
                loggingHelper::writeLog('diandi_tea', 'Notify', '添加系统用户余额变更记录', $accountLoginfo_money);
                self::AccountLog($accountLoginfo_money);

                $openid = DdWxappFans::find()->where(['user_id' => $member_id])->select('openid')->scalar();
                //小程序下单通知
                $hourse_name = TeaHourse::find()->where(['id' => $orderInfo['hourse_id']])->select('title')->scalar();
                NoticeService::OrderNotice(['openid' => $openid, 'hourse_name' => $hourse_name, 'order_num' => $orderInfo['order_number'], 'price' => $orderInfo['real_pay'], 'order_id' => $orderInfo['id'], 'store_id' => $orderInfo['store_id']]);
                //小程序预约到期前10分钟通知
                $dif = (strtotime($orderInfo['start_time']) - 600) - time();
                if ($dif > 0) {
                    $notice_time = $dif;
                } else {
                    $notice_time = 1;
                }
                $store = Yii::$app->service->commonGlobalsService->getStoreDetail($orderInfo['store_id']);
                $address = '西安市雁塔区' . $store['address'];
                $url = Yii::$app->request->hostInfo . '/api/diandi_tea/notice/orderobs?bloc_id=30&store_id=79';
                loggingHelper::writeLog('diandi_tea', 'notice_time', 'url地址', $url);
                Yii::$app->queue->delay($notice_time)->push(new Noticeobs([
                    'data' => ['openid' => $openid, 'hourse_name' => $hourse_name, 'order_num' => $orderInfo['order_number'], 'start_time' => $orderInfo['start_time'], 'address' => $address, 'order_id' => $orderInfo['id']],
                    'url' => $url,
                ]));

                //小程序订单到期前10分钟续费通知
                $dif_renew = (strtotime($orderInfo['end_time']) - 600) - time();
                if ($dif_renew > 0) {
                    $notice_time_renew = $dif_renew;
                } else {
                    $notice_time_renew = 1;
                }

                // 增加关灯任务
//                $switch_dif_renew = (strtotime($orderInfo['end_time'])) - time();
//                if ($switch_dif_renew > 0) {
//                    $switch_time_renew = $switch_dif_renew;
//                } else {
//                    $switch_time_renew = 1;
//                }
//
//                $diandiLockSdk = new diandiSdk();
//                $ext_event_id = $orderInfo['id'];
//                // 增加5个关灯任务
//                for ($i = 0; $i < 5; $i++) {
//                    $switch_time_renew += 5 * 60;
//                    $diandiLockSdk->switchStatue($ext_room_id, 1, $switch_time_renew, $ext_event_id, true);
//                }

                 Yii::$app->queue->delay(20)->push(new CreateLockPassWord([
                     'ext_room_id' => 1375,
                     'member_id'=>2001,
                     'ext_order_id' => 2,
                     'password'=>'123456',
                     'start_time'=>time(),
                     'end_time'=>time()+3600*2,
                 ]));

                Yii::$app->queue->delay($notice_time_renew)->push(new Renewobs([
                    'bloc_id' => $orderInfo['bloc_id'],
                    'store_id' => $orderInfo['store_id'],
                    'data' => ['openid' => $openid, 'end_time' => $orderInfo['end_time'], 'order_id' => $orderInfo['id']],
                ]));
                loggingHelper::writeLog('diandi_tea', 'Notify', '订单数据', $orderInfo);

                Yii::$app->queue->push(new TeaSmsJob([
                    'bloc_id' => $orderInfo['bloc_id'],
                    'store_id' => $orderInfo['store_id'],
                    'product' => '订单，房间' . $orderInfo['hourse']['hourse_name'] . ',时间段：' . $orderInfo['start_time'] . '至' . $orderInfo['end_time'],
                ]));

                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                loggingHelper::writeLog('diandi_tea', 'Notify', '包间订单处理,错误信息Exception', $e);
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                loggingHelper::writeLog('diandi_tea', 'Notify', '包间订单处理,错误信息Throwable', $e);

                throw $e;
            }

            if (isset($params['is_auto']) && $params['is_auto'] == 1) {
                return ResultHelper::json(200, '支付成功');
            } else {
                echo ArrayHelper::toXml(['return_code' => 'SUCCESS', 'return_msg' => 'OK']);
                die;
            }
        } elseif ($GorderType == 'X') {
            //包间续费订单回调
            loggingHelper::writeLog('diandi_tea', 'Notify', '包间续费回调', $GorderType);

            // 包间续费订单 X2020121499549755
            $orderInfo = TeaOrderList::find()->where(['order_number' => $params['out_trade_no']])->asArray()->one();

            loggingHelper::writeLog('diandi_tea', 'Notify', '包间续费详情sql', TeaOrderList::find()->where(['order_number' => $params['out_trade_no']])->createCommand()->getRawSql());
            loggingHelper::writeLog('diandi_tea', 'Notify', '包间续费详情', $orderInfo);

            if ($orderInfo['status'] > 1 && $orderInfo['status'] != 4) {
                echo ArrayHelper::toXml(['return_code' => 'SUCCESS', 'return_msg' => 'OK']);
                die;
            }

            //$transaction = DistributionAccountStorePay::getDb()->beginTransaction();
            $transaction = Yii::$app->db->beginTransaction();

            try {
                $balance = DdMemberAccount::find()->where(['member_id' => $orderInfo['member_id']])->select('user_money')->asArray()->one()['user_money'];
                loggingHelper::writeLog('diandi_tea', 'Notify', '包间续费处理', [
                    'order_id' => $orderInfo['id'],
                    'status' => 2,
                    'pay_time' => date('Y-m-d H:i:s'),
                    'balance' => $balance,
                    'transaction_id' => $params['transaction_id'],
                ]);

                //更新续费订单状态
                $Res = TeaOrderList::updateAll([
                    'status' => 2,
                    'pay_type' => 1,
                    'pay_time' => date('Y-m-d H:i:s'),
                    'transaction_id' => $params['transaction_id'],
                ], ['id' => $orderInfo['id']]);
                loggingHelper::writeLog('diandi_tea', 'Notify', '包间续费处理', $Res);

                //记录套餐续费记录
                $renew_order_id = $orderInfo['renew_order_id'];
                $order_model = TeaOrderList::find()->where(['id' => $renew_order_id])->asArray()->one();
                $set_meal_model = TeaSetMeal::find()->select(['title', 'renew_price'])->where(['id' => $order_model['set_meal_id']])->asArray()->one();

                $set_meal_renew = [
                    'set_meal_id' => $order_model['set_meal_id'],
                    'price' => $orderInfo['real_pay'],
                    'renew_price' => $set_meal_model['renew_price'],
                    'order_id' => $orderInfo['id'],
                    'renew_num' => $orderInfo['renew_num'],
                    'member_id' => $orderInfo['member_id'],
                ];

                loggingHelper::writeLog('diandi_tea', 'Notify', '记录套餐续费记录', $set_meal_renew);
                $set_meal_renew_list_model = new TeaSetMealRenewList();
                $set_meal_renew_list_model->load($set_meal_renew, '');
                $set_meal_renew_list_model->save();

                //房间开锁加时订单
                // 派遣器
                // $dispatcher = new DdDispatcher();
                // // 监听器
                // $listener = new DdListener();

                // $subscriber = new LockopenServer();
                // $dispatcher->addSubscriber($subscriber);

                $member_id = $orderInfo['member_id'];
                $password = '';
                $ext_room_id = $orderInfo['hourse_id'];
                $start_time = $orderInfo['start_time'];
                $end_time = $orderInfo['end_time'];
                $ext_order_id = $orderInfo['renew_order_id'];
                // $event = new LockOrderEvent($ext_order_id, $member_id, $password, $ext_room_id, $start_time, $end_time);
                // $dispatcher->dispatch(LockOrderEvent::EVENT_LOCK_ORDER, $event);

                $diandiLockSdk = new diandiSdk();
                $diandiLockSdk->createLockOrder($ext_order_id, $member_id, $password, $ext_room_id, $start_time, $end_time);
                loggingHelper::writeLog('diandi_tea', 'Notify', '房间开锁加时下单', [$ext_order_id, $member_id, $password, $ext_room_id, $start_time, $end_time]);

                //赠送积分
                $memberIntegral = DdMemberAccount::find()->select('user_integral')
                    ->where(['member_id' => $orderInfo['member_id']])->asArray()->one()['user_integral'];
                $memberLevel = DdMember::find()->select('level')
                    ->where(['member_id' => $orderInfo['member_id']])->asArray()->one()['level'];
                $scale = TeaGlobalConfig::find()->select('mumber_scale', 'vip_scale')
                    ->where(['store_id' => $orderInfo['store_id']])->asArray()->one();
                if ($memberLevel == 1) {
                    $integral = round($orderInfo['real_pay'] * $scale['mumber_scale'] / 100);
                } else {
                    $integral = round($orderInfo['real_pay'] * $scale['vip_scale'] / 100);
                }

                if ($integral > 0) {
                    //更改积分
                    DdMemberAccount::updateAllCounters([
                        'user_integral' => $integral,
                        'accumulate_integral' => $integral,
                        'give_integral' => $integral,
                    ], ['member_id' => $orderInfo['member_id']]);
                    //记录系统赠送积分记录
                    $accountLoginfoIntegral = [
                        'member_id' => $orderInfo['member_id'],
                        'account_type' => 'tea_member_give_inte_ren',
                        'money' => $integral,
                        'is_add' => 0,
                        'old_money' => $memberIntegral,
                        'money_id' => $orderInfo['id'],
                        'remark' => '下单续费赠送积分',
                    ];

                    loggingHelper::writeLog('diandi_tea', 'Notify', '更新系统用户下单续费赠送积分记录', $accountLoginfoIntegral);
                    self::AccountLog($accountLoginfoIntegral);
                }

                //添加系统用户消费记录
                $accountLoginfo = [
                    'member_id' => $orderInfo['member_id'],
                    'account_type' => 'tea_member_renew_money',
                    'money' => -$orderInfo['real_pay'],
                    'is_add' => 1,
                    'old_money' => 0,
                    'money_id' => $orderInfo['id'],
                    'remark' => '订单续费现金消费',
                ];

                loggingHelper::writeLog('diandi_tea', 'Notify', '添加系统用户余额变更记录', $accountLoginfo);
                self::AccountLog($accountLoginfo);

                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                loggingHelper::writeLog('diandi_tea', 'Notify', '包间续费订单处理,错误信息Exception', $e);
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                loggingHelper::writeLog('diandi_tea', 'Notify', '包间续费订单处理,错误信息Throwable', $e);

                throw $e;
            }

            if ($params['is_auto'] == 1) {
                return ResultHelper::json(200, '支付成功');
            } else {
                echo ArrayHelper::toXml(['return_code' => 'SUCCESS', 'return_msg' => 'OK']);
                die;
            }
        } elseif ($GorderType == 'K') {
            //卡券购买订单回调
            loggingHelper::writeLog('diandi_tea', 'Notify', '卡券购买回调', $GorderType);

            // 卡券购买订单 K2020121499549755
            $orderInfo = TeaCouponBuyList::find()->where(['order_number' => $params['out_trade_no']])->asArray()->one();

            loggingHelper::writeLog('diandi_tea', 'Notify', '卡券购买详情sql', TeaCouponBuyList::find()->where(['order_number' => $params['out_trade_no']])->createCommand()->getRawSql());
            loggingHelper::writeLog('diandi_tea', 'Notify', '卡券购买详情', $orderInfo);

            if ($orderInfo['status'] > 1) {
                echo ArrayHelper::toXml(['return_code' => 'SUCCESS', 'return_msg' => 'OK']);
                die;
            }

            //$transaction = DistributionAccountStorePay::getDb()->beginTransaction();
            $transaction = Yii::$app->db->beginTransaction();

            try {
                $balance = DdMemberAccount::find()->where(['member_id' => $orderInfo['member_id']])->select('user_money')->asArray()->one()['user_money'];
                loggingHelper::writeLog('diandi_tea', 'Notify', '卡券购买处理', [
                    'status' => 2,
                    'pay_time' => date('Y-m-d H:i:s'),
                    'balance' => $balance,
                    'transaction_id' => $params['transaction_id'],
                ]);

                //更新卡券购买订单状态
                $Res = TeaCouponBuyList::updateAll([
                    'status' => 2,
                    'pay_type' => 1,
                    'balance' => $balance,
                    'pay_time' => date('Y-m-d H:i:s'),
                    'transaction_id' => $params['transaction_id'],
                ], ['id' => $orderInfo['id']]);
                loggingHelper::writeLog('diandi_tea', 'Notify', '卡券购买处理', $Res);

                //赠送积分
                $memberIntegral = DdMemberAccount::find()->select('user_integral')
                    ->where(['member_id' => $orderInfo['member_id']])->asArray()->one()['user_integral'];
                $memberLevel = DdMember::find()->select('level')
                    ->where(['member_id' => $orderInfo['member_id']])->asArray()->one()['level'];
                $scale = TeaGlobalConfig::find()->select('mumber_scale', 'vip_scale')
                    ->where(['store_id' => $orderInfo['store_id']])->asArray()->one();
                if ($memberLevel == 1) {
                    $integral = round($orderInfo['price'] * $scale['mumber_scale'] / 100);
                } else {
                    $integral = round($orderInfo['price'] * $scale['vip_scale'] / 100);
                }

                if ($integral > 0) {
                    //更改积分
                    DdMemberAccount::updateAllCounters([
                        'user_integral' => $integral,
                        'accumulate_integral' => $integral,
                        'give_integral' => $integral,
                    ], ['member_id' => $orderInfo['member_id']]);
                    //记录系统赠送积分记录
                    $accountLoginfoIntegral = [
                        'member_id' => $orderInfo['member_id'],
                        'account_type' => 'tea_member_give_inte_cou',
                        'money' => $integral,
                        'is_add' => 0,
                        'old_money' => $memberIntegral,
                        'money_id' => $orderInfo['id'],
                        'remark' => '卡券购买赠送积分',
                    ];

                    loggingHelper::writeLog('diandi_tea', 'Notify', '更新系统用户下单续费赠送积分记录', $accountLoginfoIntegral);
                    self::AccountLog($accountLoginfoIntegral);
                }

                //增加已发售卡券数量
                TeaCoupon::updateAllCounters(['all_num' => 1], ['id' => $orderInfo['coupon_id']]);
                //增加用户卡券数量
                $is_have = TeaMemberCoupon::find()->select('id')
                    ->where(['member_id' => $orderInfo['member_id'], 'coupon_id' => $orderInfo['coupon_id']])
                    ->asArray()->one();
                if ($is_have['id']) {
                    //增加剩余使用次数
                    loggingHelper::writeLog('diandi_tea', 'Notify', '增加用户卡券可用次数', $is_have['id']);
                    TeaMemberCoupon::updateAllCounters(['surplus_num' => 1], ['id' => $is_have['id']]);
                } else {
                    //创建用户卡券
                    $data['member_id'] = $orderInfo['member_id'];
                    $data['coupon_name'] = $orderInfo['coupon_name']; //卡券名称
                    $data['coupon_id'] = $orderInfo['coupon_id']; //卡券id
                    $data['coupon_type'] = $orderInfo['coupon_type']; //卡券类型
                    $data['surplus_num'] = 1; //剩余数量
                    $data['receive_type'] = 2; //卡券获取方式： 1.领取 2.购买  3.充值赠送
                    $MemberCouponModel = new TeaMemberCoupon();
                    loggingHelper::writeLog('diandi_tea', 'Notify', '创建用户卡券', $data);
                    $MemberCouponModel->load($data, '');
                    $MemberCouponModel->save();
                }
                //添加系统用户卡券购买消费记录
                $accountLoginfo = [
                    'member_id' => $orderInfo['member_id'],
                    'account_type' => 'tea_buy_coupon_money',
                    'money' => -$orderInfo['price'],
                    'is_add' => 1,
                    'old_money' => 0,
                    'money_id' => $orderInfo['id'],
                    'remark' => '会员购买卡券现金消费',
                ];

                loggingHelper::writeLog('diandi_tea', 'Notify', '更新系统用户余额变更记录', $accountLoginfo);
                self::AccountLog($accountLoginfo);

                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                loggingHelper::writeLog('diandi_tea', 'Notify', '包间续费订单处理,错误信息Exception', $e);
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                loggingHelper::writeLog('diandi_tea', 'Notify', '包间续费订单处理,错误信息Throwable', $e);

                throw $e;
            }

            if ($params['is_auto'] == 1) {
                return ResultHelper::json(200, '支付成功');
            } else {
                echo ArrayHelper::toXml(['return_code' => 'SUCCESS', 'return_msg' => 'OK']);
                die;
            }
        } elseif ($GorderType == 'Y') {
            //余额充值订单回调
            loggingHelper::writeLog('diandi_tea', 'Notify', '余额充值回调', $GorderType);

            // 余额充值订单 C2020121499549755
            $rechargeInfo = TeaRechargeList::find()->where(['order_number' => $params['out_trade_no']])->asArray()->one();

            loggingHelper::writeLog('diandi_tea', 'Notify', '余额充值详情sql', TeaRechargeList::find()->where(['order_number' => $params['out_trade_no']])->createCommand()->getRawSql());
            loggingHelper::writeLog('diandi_tea', 'Notify', '余额充值详情', $rechargeInfo);

            if ($rechargeInfo['status'] > 1) {
                echo ArrayHelper::toXml(['return_code' => 'SUCCESS', 'return_msg' => 'OK']);
                die;
            }

            //$transaction = DistributionAccountStorePay::getDb()->beginTransaction();
            $transaction = Yii::$app->db->beginTransaction();

            try {
                loggingHelper::writeLog('diandi_tea', 'Notify', '余额充值处理', [
                    'status' => 2,
                    'pay_time' => date('Y-m-d H:i:s'),
                    'recharge_id' => $rechargeInfo['recharge_id'],
                    'transaction_id' => $params['transaction_id'],
                ]);

                //赠送积分
                $memberIntegral = DdMemberAccount::find()->select('user_integral')
                    ->where(['member_id' => $rechargeInfo['member_id']])->asArray()->one()['user_integral'];
                $memberLevel = DdMember::find()->select('level')
                    ->where(['member_id' => $rechargeInfo['member_id']])->asArray()->one()['level'];
                $scale = TeaGlobalConfig::find()->select('mumber_scale', 'vip_scale')
                    ->where(['store_id' => $rechargeInfo['store_id']])->asArray()->one();
                if ($memberLevel == 1) {
                    $integral = round($rechargeInfo['price'] * $scale['mumber_scale'] / 100);
                } else {
                    $integral = round($rechargeInfo['price'] * $scale['vip_scale'] / 100);
                }

                if ($integral > 0) {
                    //更改积分
                    DdMemberAccount::updateAllCounters([
                        'user_integral' => $integral,
                        'accumulate_integral' => $integral,
                        'give_integral' => $integral,
                    ], ['member_id' => $rechargeInfo['member_id']]);
                    //记录系统赠送积分记录
                    $accountLoginfoIntegral = [
                        'member_id' => $rechargeInfo['member_id'],
                        'account_type' => 'tea_member_give_inte_rec',
                        'money' => $integral,
                        'is_add' => 0,
                        'old_money' => $memberIntegral,
                        'money_id' => $rechargeInfo['id'],
                        'remark' => '余额充值送积分',
                    ];

                    loggingHelper::writeLog('diandi_tea', 'Notify', '更新系统余额充值赠送积分记录', $accountLoginfoIntegral);
                    self::AccountLog($accountLoginfoIntegral);
                }

                //更新用户余额开始
                $recharge = TeaRecharge::find()->select(['price', 'give_money', 'give_coupon_ids', 'type'])->where(['id' => $rechargeInfo['recharge_id']])->asArray()->one();
                $addMoney = $recharge['price'] + $recharge['give_money'];
                if ($recharge['type'] == 1) {
                    //余额增量
                    //增加赠送卡券
                    if (!empty($recharge['give_coupon_ids'])) {
                        loggingHelper::writeLog('diandi_tea', 'Notify', '充值赠送卡券记录', ['member_id' => $rechargeInfo['member_id'], 'give_coupon_ids' => $recharge['give_coupon_ids']]);

                        $coupon_ids_arr = explode(',', $recharge['give_coupon_ids']);

                        foreach ($coupon_ids_arr as $v) {
                            //增加已发售卡券数量
                            TeaCoupon::updateAllCounters(['all_num' => 1], ['id' => $v]);
                            //增加用户卡券数量
                            $is_have = TeaMemberCoupon::find()->select('id')
                                ->where(['member_id' => $rechargeInfo['member_id'], 'coupon_id' => $v])
                                ->asArray()->one();
                            if ($is_have['id']) {
                                //增加剩余使用次数
                                loggingHelper::writeLog('diandi_tea', 'Notify', '增加用户卡券可用次数', $is_have['id']);
                                TeaMemberCoupon::updateAllCounters(['surplus_num' => 1], ['id' => $is_have['id']]);
                            } else {
                                //创建用户卡券
                                $couponModel = TeaCoupon::find()->select(['name', 'type'])
                                    ->where(['id' => $v])->asArray()->one();
                                $data['member_id'] = $rechargeInfo['member_id'];
                                $data['coupon_name'] = $couponModel['name']; //卡券名称
                                $data['coupon_id'] = $v; //卡券id
                                $data['coupon_type'] = $couponModel['type']; //卡券类型
                                $data['surplus_num'] = 1; //剩余数量
                                $data['receive_type'] = 3; //卡券获取方式： 1.领取 2.购买 3.充值赠送
                                $MemberCouponModel = new TeaMemberCoupon();
                                loggingHelper::writeLog('diandi_tea', 'Notify', '创建用户卡券', $data);
                                $MemberCouponModel->load($data, '');
                                $MemberCouponModel->save();
                            }
                        }
                    }
                }
                //更新前余额
                $oldMoney = DdMemberAccount::find()->select('user_money')
                    ->where(['member_id' => $rechargeInfo['member_id']])->asArray()->one()['user_money'];

                //更新余额
                DdMemberAccount::updateAllCounters([
                    'user_money' => $addMoney,
                    'accumulate_money' => $addMoney,
                    'give_money' => $recharge['give_money'],
                ], ['member_id' => $rechargeInfo['member_id']]);

                //更新充值订单状态
                $Res = TeaRechargeList::updateAll([
                    'status' => 2,
                    'balance' => $oldMoney + $addMoney,
                    'pay_time' => date('Y-m-d H:i:s'),
                    'transaction_id' => $params['transaction_id'],
                ], ['id' => $rechargeInfo['id']]);
                loggingHelper::writeLog('diandi_tea', 'Notify', '余额充值处理', $Res);

                //升级VIP
                if ($memberLevel == 1) {
                    DdMember::updateAll(['level' => 2], ['member_id' => $rechargeInfo['member_id']]);
                    DdMemberAccount::updateAll(['level' => 2], ['member_id' => $rechargeInfo['member_id']]);
                }

                //更新系统余额变更记录
                $accountLoginfo = [
                    'member_id' => $rechargeInfo['member_id'],
                    'account_type' => 'tea_member_balance',
                    'old_money' => $oldMoney,
                    'money' => $addMoney,
                    'is_add' => 0,
                    'money_id' => $rechargeInfo['id'],
                    'remark' => '用户充值余额',
                ];

                loggingHelper::writeLog('diandi_tea', 'Notify', '添加系统用户余额充值记录', $accountLoginfo);
                self::AccountLog($accountLoginfo);

                $openid = DdWxappFans::find()->where(['user_id' => $rechargeInfo['member_id']])->select('openid')->scalar();
                //小程序通知
                $give_price = TeaRecharge::find()->where(['id' => $rechargeInfo['recharge_id']])->select('give_money')->scalar();
                NoticeService::RechargeNotice(['openid' => $openid, 'store_id' => $rechargeInfo['store_id'], 'price' => $rechargeInfo['price'], 'time' => $rechargeInfo['create_time'], 'give_price' => $give_price]);

                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                loggingHelper::writeLog('diandi_tea', 'Notify', '余额充值订单处理,错误信息Exception', $e);
                throw $e;
            } catch (\Throwable $e) {
                $transaction->rollBack();
                loggingHelper::writeLog('diandi_tea', 'Notify', '余额充值订单处理,错误信息Throwable', $e);

                throw $e;
            }

            if ($params['is_auto'] == 1) {
                return ResultHelper::json(200, '支付成功');
            } else {
                echo ArrayHelper::toXml(['return_code' => 'SUCCESS', 'return_msg' => 'OK']);
                die;
            }
        }

        echo ArrayHelper::toXml(['return_code' => 'SUCCESS', 'return_msg' => 'OK']);
        die;
    }

    public static function AccountLog($data): bool
    {
        $AccountLog = new AccountLog();
        $AccountLog->load($data, '');
        return $AccountLog->save();
    }
}
