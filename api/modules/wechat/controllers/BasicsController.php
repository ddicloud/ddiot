<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-09 01:32:28
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-07-11 14:31:32
 */

namespace api\modules\wechat\controllers;

use api\controllers\AController;
use common\helpers\ArrayHelper;
use common\helpers\FileHelper;
use common\helpers\ResultHelper;
use common\helpers\StringHelper;
use common\models\DdCorePaylog;
use common\models\PayRefundLog;
use Yii;
use yii\helpers\Json;

/**
 * Default controller for the `WeChat` module.
 */
class BasicsController extends AController
{
    protected array $authOptional = ['signup', 'notify'];
    public $modelClass = 'api\modules\wechat\models\DdWxappFans';


    public function actionSignup(): array
    {
        $users = Yii::$app->request->post();
        $code = $users['code'];

        unset($users['code']);
        $logPath = Yii::getAlias('@runtime/wechat/signup/' . date('ymd') . '.log');

        FileHelper::writeLog($logPath, '登录日志：请求code的用户数据' . json_encode($users));

        $miniProgram = Yii::$app->wechat->miniProgram;
        if (empty($users['openid'])) { // 当openid有值的时候为app登录
            $user = $miniProgram->auth->session($code);
            FileHelper::writeLog($logPath, '登录日志：获取信息' . json_encode($user));

            if (key_exists('errcode', $user)) {
                FileHelper::writeLog($logPath, '登录日志：请求错误信息' . json_encode($user));

                return ResultHelper::json(401, $user['errmsg']);
            }
            $users['session_key'] = $user['session_key'];
            $users['openid'] = $user['openid'];
            $users['unionid'] = key_exists('unionid', $user) ? $user['unionid'] : '';
        }
        // 查询该openID是否存在
        $res = Yii::$app->fans->signup($users);
        FileHelper::writeLog($logPath, '登录成功：' . json_encode($res));

        return ResultHelper::json(200, '登录成功', $res);
    }


    public function actionPayparameters(): array
    {
        $data = Yii::$app->request->post();
        if (empty(Yii::$app->params['wechatPaymentConfig']['mch_id'])) {
            return ResultHelper::json(401, '请检查商户号配置');
        }

        if (empty(Yii::$app->params['wechatPaymentConfig']['key'])) {
            return ResultHelper::json(401, '请检查支付秘钥配置');
        }

        // 生成订单
        $orderData = [
            'openid' => $data['openid'],
            'spbill_create_ip' => Yii::$app->request->userIP,
            'fee_type' => 'CNY',
            'body' => StringHelper::msubstr($data['body'], 0, 10), // 内容
            'out_trade_no' => $data['out_trade_no'], // 订单号
            'total_fee' => floatval($data['total_fee']) * 100,
            'trade_type' => $data['trade_type'], //支付类型
            'notify_url' => Yii::$app->params['wechatPaymentConfig']['notify_url'], // 回调地址
            // 'open_id' => 'okFAZ0-',  //JS支付必填
            // 'auth_code' => 'ojPztwJ5bRWRt_Ipg',  刷卡支付必填
        ];
        $logPath = Yii::getAlias('@runtime/wechat/payparameters' . date('ymd') . '.log');
        FileHelper::writeLog($logPath, '订单数据' . json_encode(ArrayHelper::toArray($orderData)));

        // 生成支付配置
        $payment = Yii::$app->wechat->payment;
        // return $payment->order;
        $result = $payment->order->unify($orderData);
        if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS') {
            $prepayId = $result['prepay_id'];
            $config = $payment->jssdk->sdkConfig($prepayId);

            return ResultHelper::json(200, '支付参数获取成功', $config);
        } else {
            return ResultHelper::json(401, $result['err_code_des'], $result);
        }
    }

    /**
     * 支付回调.
     */
    public function actionNotify(): void
    {
        $logPath = Yii::getAlias('@runtime/wechat/notify/' . date('ymd') . '.log');
        FileHelper::writeLog($logPath, '开始回调1' . json_encode(Yii::$app->wechat->payment));

        $input = file_get_contents('php://input');

        FileHelper::writeLog($logPath, '开始回调2' . json_encode($input));

        $response = Yii::$app->wechat->payment->handlePaidNotify(function ($message, $fail) {
            $logPath = Yii::getAlias('@runtime/wechat/notify/' . date('ymd') . '.log');

            FileHelper::writeLog($logPath, Json::encode(ArrayHelper::toArray($message)));
            /////////////  建议在这里调用微信的【订单查询】接口查一下该笔订单的情况，确认是已经支付 /////////////

            // return_code 表示通信状态，不代表支付状态
            if ($message['return_code'] === 'SUCCESS') {
                FileHelper::writeLog($logPath, '成功回调' . $message['out_trade_no']);
                $orderInfo = DdCorePaylog::findOne(['uniontid' => $message['out_trade_no']]);
                FileHelper::writeLog($logPath, '订单信息' . json_encode($orderInfo));

                $module = $orderInfo['module'];

                FileHelper::writeLog($logPath, '下单模块' . $module);

                $notify = Yii::$app->getModule($module)->Notify($message);

                FileHelper::writeLog($logPath, '下单模块处理数据结构' . json_decode($notify));

                if ($notify) {
                    return true;
                }
            }

            return $fail('处理失败，请稍后再通知我');
        });
        FileHelper::writeLog($logPath, '回调完毕' . json_encode($response));

        $response->send();
    }

    // 退款回调
    public function actionRefundednotify(): void
    {
        $logPath = Yii::getAlias('@runtime/wechat/refundednotify/' . date('ymd') . '.log');
        FileHelper::writeLog($logPath, '开始回调' . json_encode(Yii::$app->wechat->payment));

        $input = file_get_contents('php://input');

        FileHelper::writeLog($logPath, '退款回调数据' . json_encode($input));

        $response = Yii::$app->wechat->payment->handleRefundedNotify(function ($message, $reqInfo, $fail) {
            $logPath = Yii::getAlias('@runtime/wechat/refundednotify/' . date('ymd') . '.log');

            FileHelper::writeLog($logPath, Json::encode(ArrayHelper::toArray($reqInfo)));
            /////////////  建议在这里调用微信的【订单查询】接口查一下该笔订单的情况，确认是已经支付 /////////////

            // return_code 表示通信状态，不代表支付状态
            if ($reqInfo['refund_status'] === 'SUCCESS') {
                $out_refund_no = $reqInfo['out_refund_no'];

                $refundLog = PayRefundLog::find()->where(['out_refund_no' => $out_refund_no])->asArray()->one();

                $module = $refundLog['module'];

                $refundData = [
                    'return_code' => $reqInfo['return_code'],
                    'out_refund_no' => $reqInfo['out_refund_no'],
                    'out_trade_no' => $reqInfo['out_trade_no'],
                    'refund_account' => $reqInfo['refund_account'],
                    'refund_fee' => $reqInfo['refund_fee'],
                    'refund_id' => $reqInfo['refund_id'],
                    'refund_recv_accout' => $reqInfo['refund_recv_accout'],
                    'refund_request_source' => $reqInfo['refund_request_source'],
                    'refund_status' => $reqInfo['refund_status'],
                    'settlement_refund_fee' => $reqInfo['settlement_refund_fee'],
                    'settlement_total_fee' => $reqInfo['settlement_total_fee'],
                    'success_time' => $reqInfo['success_time'],
                    'total_fee' => $reqInfo['total_fee'],
                    'transaction_id' => $reqInfo['transaction_id'],
                ];

                $Res = PayRefundLog::updateAll($refundData, [
                    'out_refund_no' => $reqInfo['out_refund_no'],
                ]);

                FileHelper::writeLog($logPath, '全局更新日志结果' . json_decode($Res));

                $notify = Yii::$app->getModule($module)->Refundednotify($reqInfo);

                FileHelper::writeLog($logPath, '下单模块处理数据结构' . json_decode($notify));

                if ($notify) {
                    return true;
                }
            }

            return $fail('处理失败，请稍后再通知我');
        });
        FileHelper::writeLog($logPath, '回调完毕' . json_encode($response));

        $response->send();
    }
}
