<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-21 03:55:26
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-27 11:23:55
 */

namespace common\plugins\diandi_hub\services;

use common\plugins\diandi_hub\models\account\HubMemberAccount;
use common\plugins\diandi_hub\models\account\HubWithdrawLog;
use common\plugins\diandi_hub\models\config\HubConfig;
use common\plugins\diandi_hub\models\enums\AccountChangeStatus;
use common\plugins\diandi_hub\models\enums\AccountTypeStatus;
use common\plugins\diandi_hub\models\enums\OrderTypeStatus;
use common\plugins\diandi_hub\models\enums\PayStatus;
use common\plugins\diandi_hub\models\enums\WithdrawStatus;
use common\plugins\diandi_hub\models\enums\WithdrawTypeStatus;
use common\plugins\diandi_hub\models\goods\HubGoodsBaseCollect;
use common\plugins\diandi_hub\models\level\HubLevel;
use common\plugins\diandi_hub\models\member\HubMemberLevel;
use common\plugins\diandi_hub\models\member\HubUserBank;
use common\plugins\diandi_hub\services\account\logAccount;
use admin\modules\officialaccount\models\DdWechatFans;
use common\helpers\ErrorsHelper;
use common\helpers\ImageHelper;
use common\helpers\loggingHelper;
use common\helpers\StringHelper;
use common\models\DdUser;
use common\services\BaseService;
use Yii;
use yii\data\Pagination;

class MemberService extends BaseService
{
    // 获取用户等级信息
    public static function getByUid($uid, $is_insert = false)
   {
        loggingHelper::writeLog('diandi_hub', 'MemberService', '获取用户信息', $uid);
        if (intval($uid) == 0) {
            loggingHelper::writeLog('diandi_hub', 'MemberService', '获取用户信息失败，id为0', $uid);

            return false;
        }

        $DistributormemberLevel = new HubMemberLevel();
        $userInfo = $DistributormemberLevel->find()->where(['member_id' => $uid])->with(['level'])->asArray()->one();
        loggingHelper::writeLog('diandi_hub', 'MemberService', '获取用户信息', $userInfo);

        $member_pid = 0;
        if (empty($userInfo) && $is_insert) {
            $userInfo = [];
            $userInfo['is_level'] = false;
            $HubLevel = new HubLevel();
            $level_ids = $HubLevel::find()->where(['levelnum' => 1])->asArray()->one();
            $data = [
                'member_id' => intval($uid),
                'member_pid' => 0,
                'level_pid' => 0,
                'level_id' => $level_ids['id'],
                'level_pid_num' => 0,
                'level_num' => 1,
                'family' => '', //我的上级与上级的家族就是我的上级家族
            ];

            loggingHelper::writeLog('diandi_hub', 'MemberService', '写入用户信息', $data);

            $DistributormemberLevel->load($data, '');
            if (!$DistributormemberLevel->save()) {
                $msg = ErrorsHelper::getModelError($DistributormemberLevel);
                loggingHelper::writeLog('diandi_hub', 'MemberService', 'getByUid写入基础用户数据，父级不存在的情况下写父级错误', $msg);
            }

            $userInfo['levelname'] = '普通用户';
            $userInfo['end_time'] = '开通尊享权益';
        } else {
            $userInfo['levelname'] = !empty($userInfo['level']['levelname']) ? $userInfo['level']['levelname'] : '普通用户';

            if ($userInfo['end_time'] == 0) {
                $userInfo['end_time'] = '开通尊享权益';
            } elseif ($userInfo['end_time'] == 1) {
                $userInfo['end_time'] = '永久';
            } else {
                $userInfo['end_time'] = date('Y-m-d', $userInfo['end_time']);
            }
            $userInfo['is_level'] = true;
            $member_pid = $userInfo['member_pid'];
        }

        // 我的上级
        $userInfo['parent'] = DdUser::find()->where(['id' => $member_pid])->one();

        return $userInfo;
    }

    // 获取用户资金
    public static function getAccount($member_id, $is_store = 0)
    {
        $account = HubMemberAccount::find()->where(['member_id' => $member_id])->asArray()->one();

        if (empty($account)) {
            $account = [
                'member_id' => $member_id,
                'self_money' => 0,
                'self_withdraw' => 0,
                'self_freeze' => 0,
                'team_money' => 0,
                'team_withdraw' => 0,
                'team_freeze' => 0,
                'store_money' => 0,
                'store_withdraw' => 0,
                'store_freeze' => 0,
            ];
            $HubMemberAccount = new HubMemberAccount();
            $HubMemberAccount->load($account, '');
            if (!$HubMemberAccount->save()) {
                return $account;
            }
        }

        $account['self_money'] = $account['self_money'] > 0 ? $account['self_money'] : '0.00';

        $account['self_withdraw'] = $account['self_withdraw'] > 0 ? $account['self_withdraw'] : '0.00';

        $account['self_freeze'] = $account['self_freeze'] > 0 ? $account['self_freeze'] : '0.00';

        $account['team_money'] = $account['team_money'] > 0 ? $account['team_money'] : '0.00';

        $account['team_withdraw'] = $account['team_withdraw'] > 0 ? $account['team_withdraw'] : '0.00';

        $account['team_freeze'] = $account['team_freeze'] > 0 ? $account['team_freeze'] : '0.00';

        $account['store_money'] = $account['store_money'] > 0 ? $account['store_money'] : '0.00';

        $account['store_withdraw'] = $account['store_withdraw'] > 0 ? $account['store_withdraw'] : '0.00';

        $account['store_freeze'] = $account['store_freeze'] > 0 ? $account['store_freeze'] : '0.00';

        $account['agent_money'] = $account['agent_money'] > 0 ? $account['agent_money'] : '0.00';

        $account['agent_withdraw'] = $account['agent_withdraw'] > 0 ? $account['agent_withdraw'] : '0.00';

        $account['agent_freeze'] = $account['agent_freeze'] > 0 ? $account['agent_freeze'] : '0.00';

        return $account;
    }

    public static function updateAccountBymid($member_id, $fileds, $num, $money_id = 0, $remark = '')
    {
        loggingHelper::writeLog('diandi_hub', 'MemberService/updateAccountBymid', '开始更新用户资产', [
            'member_id' => $member_id,
            'fileds' => $fileds,
            'num' => $num,
        ]);

        if (empty($member_id) || empty($num)) {
            return false;
        }
        $Res = false;
        loggingHelper::writeLog('diandi_hub', 'MemberService/updateAccountBymid', '更新用户资产', [
            $member_id, $fileds, $num,
        ]);

        // 全局资产
        if (in_array($fileds, [
            'credit1', //'可用余额',
            'credit2', //'养老金',
            'credit3', //'权益有效期',
            'user_integral', //'团豆',
            'user_money', //'可提现金额 '
        ])) {
            $Res = Yii::$app->service->commonMemberService->updateAccount($member_id, $fileds, $num, 1);
        } elseif (in_array($fileds, [
            // 分销资产
            'self_money',	//个人奖金
            'self_withdraw', //个人已提现
            'self_freeze',	//个人冻结
            'team_money',	//团队奖金
            'team_withdraw', //团队奖金提现
            'team_freeze',	//团队奖金冻结
            'store_money',	//店铺收益
            'store_withdraw',	//店铺可提现
            'store_freeze',	//店铺收益冻结
        ])) {
            $HubMemberAccount = new HubMemberAccount();

            loggingHelper::writeLog('diandi_hub', 'MemberService/updateAccountBymid', '开始更新资产', [
                $fileds => $num,
                'member_id' => $member_id,
            ]);

            $old_money = $HubMemberAccount->find()->where([
                'member_id' => $member_id,
            ])->select($fileds)->scalar();

            loggingHelper::writeLog('diandi_hub', 'MemberService/updateAccountBymid', '用户原资产数据', [
                $fileds => $old_money,
            ]);

            $Res = $HubMemberAccount::updateAllCounters([
                $fileds => $num,
            ], [
                'member_id' => $member_id,
            ]);

            loggingHelper::writeLog('diandi_hub', 'MemberService/updateAccountBymid', '更新资产结果', $Res);

            if ($Res) {
                $Res = Yii::$app->service->commonMemberService->addAccountLog($member_id, $fileds, $num, $old_money, $money_id, $remark);
            } else {
                $msg = ErrorsHelper::getModelError($HubMemberAccount);
                loggingHelper::writeLog('diandi_hub', 'MemberService/updateAccountBymid', '更新用户资产失败信息', $msg);
            }
        }

        return $Res;
    }

    // 用户资金提现
    public static function withdraw($member_id, $type, $pay_type = 0)
    {
        loggingHelper::writeLog('diandi_hub', 'MemberService/withdraw', '开始提现', [
            '用户id' => $member_id,
        ]);

        $re_user_name = HubUserBank::find()->where(['member_id' => $member_id])->select('name')->scalar();

        // 获取提现规则
        $conf = HubConfig::findOne(1);
        // 'min_money' => '最低提现金额',
        // 'max_num' => '每天最多提现次数',
        // 'max_money' => '每天最多提现金额',
        // 'store_radio' => '商户提现手续费',
        // 'user_radio' => '用户提现手续费',

        // 获取用户今天提现的记录
        $ymd_time = date('ymd', time());

        $num = HubWithdrawLog::find()->where(['ymd_time' => $ymd_time, 'member_id' => $member_id])->asArray()->count();

        $total_money = HubWithdrawLog::find()->where(['ymd_time' => $ymd_time, 'member_id' => $member_id])->sum('money');

        loggingHelper::writeLog('diandi_hub', 'MemberService/withdraw', '当天提现记录', [
            'ymd_time' => $ymd_time,
            'num' => $num,
            'total_money' => $total_money,
        ]);

        // 获取用户信息
        $memnber = DdWechatFans::find()->where(['user_id' => $member_id])->select(['openid'])->asArray()->one();

        loggingHelper::writeLog('diandi_hub', 'MemberService/withdraw', '用户信息', $memnber);

        // 获取用户资金
        $account = HubMemberAccount::find()->where(['member_id' => $member_id])->asArray()->one();
        loggingHelper::writeLog('diandi_hub', 'MemberService/withdraw', '获取用户资金', $account);

        // self_money	个人奖金
        // self_withdraw		个人已提现
        // self_freeze	decimal		个人冻结
        // team_money	decimal 团队奖金
        // team_withdraw	decimal			团队奖金提现
        // team_freeze	decimal			团队奖金冻结
        // store_money	decimal	店铺收益
        // store_withdraw	decimal			店铺可提现
        // store_freeze	decimal	店铺收益冻结

        $partner_trade_no = self::CreateOrderno();

        // 处理事务开始
        $transaction = Yii::$app->db->beginTransaction();

        try {
            switch ($type) {
                case WithdrawTypeStatus::getValueByName('用户'):

                    if ($num >= $conf['max_num']) {
                        loggingHelper::writeLog('diandi_hub', 'MemberService/withdraw', '超出每天提现次数', [
                            'ymd_time' => $ymd_time,
                            'num' => $num,
                            'total_money' => $total_money,
                        ]);

                        return [
                            'code' => 1,
                            'msg' => '超出每天提现次数'.$conf['max_num'].'次',
                        ];
                    }

                    if ($total_money >= $conf['max_money']) {
                        loggingHelper::writeLog('diandi_hub', 'MemberService/withdraw', '超出每天提现限额', [
                            'ymd_time' => $ymd_time,
                            'num' => $num,
                            'total_money' => $total_money,
                        ]);

                        return [
                            'code' => 1,
                            'msg' => '超出每天提现限额'.$conf['max_money'].'元',
                        ];
                    }

                    if ($account['self_money'] < $conf['min_money']) {
                        return [
                            'code' => 1,
                            'msg' => '可提现额度不够'.$conf['min_money'].'元',
                        ];
                        break;
                    }

                    if (intval($account['self_money'] == 0)) {
                        return [
                            'code' => 1,
                            'msg' => '可提现额度不够为0元',
                        ];
                        break;
                    }

                    $user_radio_money = StringHelper::currency_format($account['self_money'] * $conf['user_radio']);
                    $self_money = StringHelper::currency_format($account['self_money'] - $user_radio_money);

                    $log = [
                        'money' => $self_money,
                        'money_count' => $account['self_money'],
                        'partner_trade_no' => $partner_trade_no,
                        'withdraw_type' => $type,
                        'withdraw_status' => WithdrawStatus::getValueByName('申请提现'),
                        'member_id' => $member_id,
                        'pay_type' => $pay_type,
                        'service_charge' => $user_radio_money,
                        'confirm_name' => '',
                        'openid' => $memnber['openid'],
                        're_user_name' => $re_user_name,
                        'desc' => '用户提现',
                        'ymd_time' => $ymd_time,
                    ];
                    loggingHelper::writeLog('diandi_hub', 'MemberService/withdraw', '用户提现处理', $log);

                    $HubWithdrawLog = new HubWithdrawLog();
                    $HubWithdrawLog->load($log, '');
                    if ($HubWithdrawLog->save()) {
                        loggingHelper::writeLog('diandi_hub', 'MemberService/withdraw', '用户提现申请写入成功');

                        $change_type = AccountChangeStatus::getValueByName('申请提现');
                        $account_ype = AccountTypeStatus::getValueByName('分享可提现');
                        $order_type = OrderTypeStatus::getValueByName('提现订单');

                        // 资金明细写入
                        $account_log_id = logAccount::addorderMoneyLog($member_id, 0, -$account['self_money'], 0, $change_type, $account_ype, $order_type, 0, 0, 0, 0);

                        loggingHelper::writeLog('diandi_hub', 'MemberService/withdraw', '用户提现申请日志写入结果', [
                            'account_log_id' => $account_log_id,
                        ]);

                        //  可提现资金减少，成功后增加已提现
                        $Res = MemberService::updateAccountBymid($member_id, 'self_money', -$account['self_money'], $account_log_id);

                        loggingHelper::writeLog('diandi_hub', 'MemberService/withdraw', '用户提现资产更新结果', $Res);

                        ErrorsHelper::throwError($Res);

                    // return self::wechatWithdraw($partner_trade_no,$memnber['openid'],$account['self_money'],'用户提现');
                    } else {
                        $msg = ErrorsHelper::getModelError($HubWithdrawLog);
                        ErrorsHelper::throwError($msg);
                    }

                    break;
                case WithdrawTypeStatus::getValueByName('团队'):

                    if ($num >= $conf['max_num']) {
                        loggingHelper::writeLog('diandi_hub', 'MemberService/withdraw', '超出每天提现次数', [
                            'ymd_time' => $ymd_time,
                            'num' => $num,
                            'total_money' => $total_money,
                        ]);

                        return [
                            'code' => 1,
                            'msg' => '超出每天提现次数'.$conf['max_num'].'次',
                        ];
                    }

                    if ($total_money >= $conf['max_money']) {
                        loggingHelper::writeLog('diandi_hub', 'MemberService/withdraw', '超出每天提现限额', [
                            'ymd_time' => $ymd_time,
                            'num' => $num,
                            'total_money' => $total_money,
                        ]);

                        return [
                            'code' => 1,
                            'msg' => '超出每天提现限额'.$conf['max_money'].'元',
                        ];
                    }

                    if ($account['team_money'] < $conf['min_money']) {
                        return [
                            'code' => 1,
                            'msg' => '可提现额度不够'.$conf['min_money'].'元',
                        ];
                        break;
                    }

                    if (intval($account['team_money'] == 0)) {
                        return [
                            'code' => 1,
                            'msg' => '可提现额度不够为0元',
                        ];
                        break;
                    }

                    $user_radio_money = StringHelper::currency_format($account['team_money'] * $conf['user_radio']);
                    $team_money = StringHelper::currency_format($account['team_money'] - $user_radio_money);

                    $log = [
                        'money' => $team_money,
                        'money_count' => $account['team_money'],
                        'partner_trade_no' => $partner_trade_no,
                        'withdraw_type' => $type,
                        'withdraw_status' => WithdrawStatus::getValueByName('申请提现'),
                        'member_id' => $member_id,
                        'pay_type' => $pay_type,
                        'service_charge' => $user_radio_money,
                        'confirm_name' => '',
                        'openid' => $memnber['openid'],
                        're_user_name' => $re_user_name,
                        'desc' => '团队提现',
                        'ymd_time' => $ymd_time,
                    ];
                    loggingHelper::writeLog('diandi_hub', 'MemberService/withdraw', '团队提现处理', $log);

                    $HubWithdrawLog = new HubWithdrawLog();
                    $HubWithdrawLog->load($log, '');
                    if ($HubWithdrawLog->save()) {
                        loggingHelper::writeLog('diandi_hub', 'MemberService/withdraw', '团队提现处理记录写入', $log);

                        $change_type = AccountChangeStatus::getValueByName('申请提现');
                        $account_ype = AccountTypeStatus::getValueByName('团队可提现');
                        $order_type = OrderTypeStatus::getValueByName('提现订单');

                        // 资金明细写入
                        $account_log_id = logAccount::addorderMoneyLog($member_id, 0, -$account['team_money'], 0, $change_type, $account_ype, $order_type, 0, 0, 0, 0);

                        loggingHelper::writeLog('diandi_hub', 'MemberService/withdraw', '团队提现日志写入结果', [
                        'account_log_id' => $account_log_id,
                    ]);

                        //  可提现资金减少，成功后增加已提现
                        $Res = MemberService::updateAccountBymid($member_id, 'team_money', -$account['team_money'], $account_log_id);
                        loggingHelper::writeLog('diandi_hub', 'MemberService/withdraw', '团队提现资产更新结果', $Res);

                        ErrorsHelper::throwError($Res);

                    // return self::wechatWithdraw($partner_trade_no,$memnber['openid'],$account['team_money'],'团队提现');
                    } else {
                        $msg = ErrorsHelper::getModelError($HubWithdrawLog);
                        ErrorsHelper::throwError($msg);
                    }

                    break;

                case WithdrawTypeStatus::getValueByName('店铺'):

                    if ($num >= $conf['store_max_num']) {
                        loggingHelper::writeLog('diandi_hub', 'MemberService/withdraw', '超出每天提现次数', [
                            'ymd_time' => $ymd_time,
                            'num' => $num,
                            'total_money' => $total_money,
                        ]);

                        return [
                            'code' => 1,
                            'msg' => '超出每天提现次数'.$conf['store_max_num'].'次',
                        ];
                    }

                    if ($total_money >= $conf['store_max_money']) {
                        loggingHelper::writeLog('diandi_hub', 'MemberService/withdraw', '超出每天提现限额', [
                            'ymd_time' => $ymd_time,
                            'num' => $num,
                            'total_money' => $total_money,
                        ]);

                        return [
                            'code' => 1,
                            'msg' => '超出每天提现限额'.$conf['store_max_money'].'元',
                        ];
                    }

                    if ($account['store_money'] < $conf['store_min_money']) {
                        return [
                            'code' => 1,
                            'msg' => '可提现额度不够'.$conf['store_min_money'].'元',
                        ];
                        break;
                    }

                    if (intval($account['store_money'] == 0)) {
                        return [
                            'code' => 1,
                            'msg' => '可提现额度不够为0元',
                        ];
                        break;
                    }

                    $store_radio_money = StringHelper::currency_format($account['store_money'] * $conf['store_radio']);
                    $store_money = StringHelper::currency_format($account['store_money'] - $store_radio_money);

                    $log = [
                        'money' => $store_money,
                        'money_count' => $account['store_money'],
                        'partner_trade_no' => $partner_trade_no,
                        'withdraw_type' => $type,
                        'pay_type' => $pay_type,
                        'pay_status' => PayStatus::getValueByName('未付款'),
                        'withdraw_status' => WithdrawStatus::getValueByName('申请提现'),
                        'member_id' => $member_id,
                        'service_charge' => $store_radio_money,
                        'confirm_name' => '',
                        'openid' => $memnber['openid'],
                        're_user_name' => $re_user_name,
                        'desc' => '店铺提现',
                        'ymd_time' => $ymd_time,
                    ];
                    loggingHelper::writeLog('diandi_hub', 'MemberService/withdraw', '店铺提现处理', $log);

                    $HubWithdrawLog = new HubWithdrawLog();
                    $HubWithdrawLog->load($log, '');
                    if ($HubWithdrawLog->save()) {
                        loggingHelper::writeLog('diandi_hub', 'MemberService/withdraw', '店铺提现申请保存成功');

                        $change_type = AccountChangeStatus::getValueByName('申请提现');
                        $account_ype = AccountTypeStatus::getValueByName('店铺可提现');
                        $order_type = OrderTypeStatus::getValueByName('提现订单');

                        // 资金明细写入
                        $account_log_id = logAccount::addorderMoneyLog($member_id, 0, -$account['store_money'], 0, $change_type, $account_ype, $order_type, 0, 0, 0, 0);
                        loggingHelper::writeLog('diandi_hub', 'MemberService/withdraw', '店铺提现申请日志写入结果', [
                            'account_log_id' => $account_log_id,
                        ]);

                        //  可提现资金减少，成功后增加已提现
                        $Res = MemberService::updateAccountBymid($member_id, 'store_money', -$account['store_money'], $account_log_id);
                        loggingHelper::writeLog('diandi_hub', 'MemberService/withdraw', '店铺提现资产更新结果', $Res);

                        ErrorsHelper::throwError($Res);

                    // return  self::wechatWithdraw($partner_trade_no,$memnber['openid'],$account['store_money'],'店铺提现');
                    } else {
                        $msg = ErrorsHelper::getModelError($HubWithdrawLog);
                        ErrorsHelper::throwError($msg);
                    }

                    break;

                case WithdrawTypeStatus::getValueByName('代理'):

                    break;
            }

            $transaction->commit();
        } catch (\Exception $e) {
            loggingHelper::writeLog('diandi_hub', 'MemberService/withdraw', '申请提现错误Exception', $e);

            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            loggingHelper::writeLog('diandi_hub', 'MemberService/withdraw', '申请提现错误Throwable', $e);

            $transaction->rollBack();
            throw $e;
        }

        return [
            'code' => 0,
            'msg' => '提现申请成功',
        ];
    }

    // 驳回提现
    public static function notAuditWithdraw($id)
    {
        $info = HubWithdrawLog::find()->where(['id' => $id])->with(['userbank'])->one();
        $money = $info['money_count'];

        $member_id = $info['member_id'];

        $order_type = OrderTypeStatus::getValueByName('提现订单');

        $change_type = AccountChangeStatus::getValueByName('提现驳回');

        // 处理事务开始
        $transaction = Yii::$app->db->beginTransaction();
        $type = $info['withdraw_type'];

        try {
            switch ($type) {
                   case WithdrawTypeStatus::getValueByName('用户'):

                            loggingHelper::writeLog('diandi_hub', 'MemberService/notAuditWithdraw', '店铺提现驳回写入成功');

                            $account_ype = AccountTypeStatus::getValueByName('分享可提现');

                            // 资金明细写入
                            $Res = logAccount::addorderMoneyLog($member_id, 0, $money, 0, $change_type, $account_ype, $order_type, 0, 0, 0, 0);

                            ErrorsHelper::throwError($Res, '用户资金明细写入错误');

                            loggingHelper::writeLog('diandi_hub', 'MemberService/notAuditWithdraw', '店铺提现驳回日志写入结果', $Res);

                            // 被驳回 可提现资金增加
                            $Res = MemberService::updateAccountBymid($member_id, 'self_money', $money);

                            ErrorsHelper::throwError($Res, '更新用户资金错误');

                       break;
                   case WithdrawTypeStatus::getValueByName('团队'):

                            loggingHelper::writeLog('diandi_hub', 'MemberService/notAuditWithdraw', '团队提现驳回处理记录写入');

                            $account_ype = AccountTypeStatus::getValueByName('团队可提现');

                            // 资金明细写入
                            $Res = logAccount::addorderMoneyLog($member_id, 0, $money, 0, $change_type, $account_ype, $order_type, 0, 0, 0, 0);

                            ErrorsHelper::throwError($Res, '写入团队资金明细错误');

                            loggingHelper::writeLog('diandi_hub', 'MemberService/notAuditWithdraw', '团队提现驳回日志写入结果', $Res);

                            //  可提现资金减少，成功后增加已提现
                            $Res = MemberService::updateAccountBymid($member_id, 'team_money', $money);
                            ErrorsHelper::throwError($Res, '更新团队资金错误');

                            loggingHelper::writeLog('diandi_hub', 'MemberService/notAuditWithdraw', '团队提现驳回用户资金修改结果', $Res);

                       break;

                   case WithdrawTypeStatus::getValueByName('店铺'):

                            loggingHelper::writeLog('diandi_hub', 'MemberService/notAuditWithdraw', '店铺提现驳回保存成功');

                            $account_ype = AccountTypeStatus::getValueByName('店铺可提现');

                            // 资金明细写入
                            $Res = logAccount::addorderMoneyLog($member_id, 0, $money, 0, $change_type, $account_ype, $order_type, 0, 0, 0, 0);
                            loggingHelper::writeLog('diandi_hub', 'MemberService/notAuditWithdraw', '店铺提现驳回日志写入结果', $Res);
                            ErrorsHelper::throwError($Res, '写入店铺资金明细错误');

                            //  可提现资金减少，成功后增加已提现
                            $Res = MemberService::updateAccountBymid($member_id, 'store_money', $money);

                            ErrorsHelper::throwError($Res, '更新资金明细错误');

                       break;

                   case WithdrawTypeStatus::getValueByName('代理'):

                       break;
               }

            HubWithdrawLog::updateAll([
                    'pay_status' => PayStatus::getValueByName('已退款'),
                ], [
                    'id' => $id,
                ]);

            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            loggingHelper::writeLog('diandi_hub', 'MemberService/notAuditWithdraw', '驳回提现错误Exception', $e);
            //    throw $e;
        } catch (\Throwable $e) {
            $transaction->rollBack();
            loggingHelper::writeLog('diandi_hub', 'MemberService/notAuditWithdraw', '驳回提现错误Throwable', $e);

            //    throw $e;
        }
    }

    public static function Collect($member_id)
    {
        $list = HubGoodsBaseCollect::find()->where(['member_id' => $member_id])->with(['goods'])->asArray()->all();
        foreach ($list as $key => &$value) {
            if (!empty($value['goods']['thumb'])) {
                $value['goods']['thumb'] = ImageHelper::tomedia($value['goods']['thumb']);
            }
        }

        return array_chunk($list, 2);
    }

    public static function wechatWithdraw($partner_trade_no, $openid, $amount, $desc, $re_user_name = '', $check_name = 'NO_CHECK')
    {
        return [
            'status' => 0,
            'msg' => '提现申请成功',
        ];

        $wechat = Yii::$app->wechat->payment;

        loggingHelper::writeLog('diandi_hub', 'MemberService/wechatWithdraw', '退款开始', [
            'partner_trade_no' => $partner_trade_no, // 商户订单号，需保持唯一性(只能是字母或者数字，不能包含有符号)
            'openid' => $openid,
            'check_name' => $check_name, // NO_CHECK：不校验真实姓名, FORCE_CHECK：强校验真实姓名
            're_user_name' => $re_user_name, // 如果 check_name 设置为FORCE_CHECK，则必填用户真实姓名
            'amount' => $amount * 100, // 企业付款金额，单位为分
            'desc' => $desc, // 企业付款操作说明信息。必填
        ]);

        if ($check_name == 'FORCE_CHECK' && empty($re_user_name)) {
            loggingHelper::writeLog('diandi_hub', 'MemberService/wechatWithdraw', '检验姓名，必须输入名称');

            return [
                'status' => 1,
                'msg' => '检验姓名，必须输入名称',
            ];
        }

        // 参数分别为：微信订单号、商户退款单号、订单金额、退款金额、其他参数
        $result = $wechat->transfer->toBalance([
            'partner_trade_no' => $partner_trade_no, // 商户订单号，需保持唯一性(只能是字母或者数字，不能包含有符号)
            'openid' => $openid,
            'check_name' => $check_name, // NO_CHECK：不校验真实姓名, FORCE_CHECK：强校验真实姓名
            're_user_name' => $re_user_name, // 如果 check_name 设置为FORCE_CHECK，则必填用户真实姓名
            'amount' => $amount * 100, // 企业付款金额，单位为分
            'desc' => $desc, // 企业付款操作说明信息。必填
        ]);

        loggingHelper::writeLog('diandi_hub', 'MemberService/wechatWithdraw', '付款结果', $result);

        if ($result['return_code'] != 'SUCCESS' || $result['result_code'] != 'SUCCESS') {
            return [
                'status' => 1,
                'msg' => $result['err_code_des'],
            ];
        }

        return $result;
    }

    public static function Withdrawlist($member_id, $withdraw_status, $withdraw_type, $page, $pageSize = 10)
    {
        $where = [];
        $where['member_id'] = $member_id;

        if (in_array($withdraw_status, WithdrawStatus::getConstantsByName())) {
            $where['withdraw_status'] = $withdraw_status;
        }

        $where['withdraw_type'] = $withdraw_type;

        // 创建一个 DB 查询来获得所有
        $query = HubWithdrawLog::find()->where($where)
        ->orderBy(['create_time' => SORT_DESC]);

        loggingHelper::writeLog('diandi_hub', 'MemberService/Withdrawlist', '查询提现记录sql', $query->createCommand()->getRawSql());

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
            $value['withdraw_status'] = WithdrawStatus::getLabel($value['withdraw_status']);
            $withdraw_type = WithdrawTypeStatus::getLabel($value['withdraw_type']);
            $value['withdraw_type'] = $withdraw_type;

            if ($withdraw_type == '用户') {
                $value['withdraw_type'] = '分享';
            } elseif ($withdraw_type == '团队') {
                $value['withdraw_type'] = '管理';
            }

            $value['create_time'] = date('Y-m-d H:i', $value['create_time']);
        }

        return $list;
    }

    public static function editbankApply($member_id)
    {
        $HubUserBank = new HubUserBank();

        $Res = $HubUserBank::updateAll([
            'is_apply' => 1, //默认未申请,修改为申请
        ], ['member_id' => $member_id]);

        return $Res;
    }

    public static function Addpayset($member_id, $name, $bank_no, $mobile, $address, $province, $city, $area, $thumb, $card_front, $card_reverse, $alipay)
    {
        $HubUserBank = new HubUserBank();
        $isHave = $HubUserBank->find()->where(['member_id' => $member_id])->select(['id'])->one();

        $data = [
            'member_id' => $member_id,
            'name' => $name,
            'bank_no' => $bank_no,
            'mobile' => $mobile,
            'address' => $address,
            'province' => $province,
            'city' => $city,
            'area' => $area,
            'is_apply' => 0, //默认未申请
            'editor_status' => 1, //默认不可编辑
            'thumb' => $thumb,
            'card_front' => $card_front,
            'card_reverse' => $card_reverse,
            'alipay' => $alipay,
        ];

        if (!empty($isHave)) {
            $HubUserBank->updateAll($data, ['member_id' => $member_id]);

            return [
                'status' => 0,
                'msg' => '修改成功',
            ];
        } else {
            $HubUserBank->load($data, '');
            if ($HubUserBank->save()) {
                return [
                    'status' => 0,
                    'msg' => '添加成功',
                ];
            } else {
                return [
                    'status' => 0,
                    'msg' => '添加失败',
                ];
            }
        }
    }

    public static function Getpayset($member_id)
    {
        $HubUserBank = new HubUserBank();

        $payInfo = $HubUserBank->find()->where(['member_id' => $member_id])->with('provinces', 'regions', 'citys')->asArray()->one();

        $payInfo['is_alipay'] = false;
        $payInfo['is_bank'] = false;

        if (!empty($payInfo)) {
            if (!empty($payInfo['thumb']) && strpos($payInfo['thumb'], '/') !== false) {
                $payInfo['thumb'] = ImageHelper::tomedia($payInfo['thumb']);
            } else {
                $payInfo['thumb'] = '';
            }

            if (!empty($payInfo['card_front']) && strpos($payInfo['card_front'], '/') !== false) {
                $payInfo['card_front'] = ImageHelper::tomedia($payInfo['card_front']);
            } else {
                $payInfo['card_front'] = '';
            }

            if (!empty($payInfo['card_reverse']) && strpos($payInfo['card_reverse'], '/') !== false) {
                $payInfo['card_reverse'] = ImageHelper::tomedia($payInfo['card_reverse']);
            } else {
                $payInfo['card_reverse'] = '';
            }

            if (!empty($payInfo['alipay'])) {
                $payInfo['is_alipay'] = true;
            }

            if (!empty($payInfo['bank_no'])) {
                $payInfo['is_bank'] = true;
            }

            if (!empty($payInfo['regions'])) {
                $merger_name = $payInfo['regions']['merger_name'];

                $payInfo['regions']['merger_name'] = str_replace('中国,', '', $merger_name);
            }
        }

        return $payInfo;
    }

    // 生成订单编号
    public static function CreateOrderno()
    {
        return 'T'.date('Ymd').substr(implode('', array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }
}
