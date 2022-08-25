<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-09 01:32:28
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-25 11:33:25
 */

namespace swooleService\modules\wechat\controllers;

use swooleService\controllers\AController;
use common\helpers\ArrayHelper;
use common\helpers\FileHelper;
use common\helpers\loggingHelper;
use common\helpers\ResultHelper;
use common\helpers\StringHelper;
use common\models\DdCorePaylog;
use common\models\PayRefundLog;
use Yii;
use yii\helpers\Json;
use yii\web\YiiAsset;

/**
 * Default controller for the `wechat` module.
 */
class BasicsController extends AController
{
    protected $authOptional = ['signup', 'notify'];
    public $modelClass = 'api\modules\wechat\models\DdWxappFans';

    /**
     * @SWG\Post(path="/wechat/basics/signup",
     *     tags={"微信基础接口"},
     *     summary="微信接口测试",
     *     @SWG\Response(
     *         response = 200,
     *         description = "微信接口测试"
     *     ),
     *     @SWG\Parameter(
     *      in="query",
     *      name="code",
     *      type="string",
     *      description="微信授权code",
     *      required=true,
     *    ),
     *    @SWG\Parameter(
     *      name="user_id",
     *      type="string",
     *      in="query",
     *      description="用户id",
     *      required=false
     *    ),
     *    @SWG\Parameter(
     *      name="avatarUrl",
     *      type="string",
     *      in="query",
     *      description="头像",
     *      required=false
     *    ),
     *    @SWG\Parameter(
     *      name="nickname",
     *      type="string",
     *      in="query",
     *      description="昵称",
     *      required=false
     *    ),
     *    @SWG\Parameter(
     *      name="gender",
     *      type="string",
     *      in="query",
     *      description="性别",
     *      required=false
     *    ),
     *    @SWG\Parameter(
     *      name="country",
     *      type="string",
     *      in="query",
     *      description="国家",
     *      required=false
     *    ),
     *    @SWG\Parameter(
     *      name="city",
     *      type="string",
     *      in="query",
     *      description="城市",
     *      required=false
     *    ),
     *    @SWG\Parameter(
     *      name="province",
     *      type="string",
     *      in="query",
     *      description="省份",
     *      required=false
     *    ),
     *    @SWG\Parameter(
     *      name="openid",
     *      type="string",
     *      in="query",
     *      description="openId",
     *      required=false
     *    ),
     *    @SWG\Parameter(
     *      name="unionid",
     *      type="string",
     *      in="query",
     *      description="unionId",
     *      required=false
     *    ),
     *
     * )
     */
    public function actionSignup()
    {
        global $_GPC;
        $code = $_GPC['code'];

        loggingHelper::writeLog('wechat','signup','授权登录参数',$_GPC);

        $miniProgram = Yii::$app->wechat->miniProgram;
        if (empty($users['openid'])) { // 当openid有值的时候为app登录
            $user = $miniProgram->auth->session($code);
            loggingHelper::writeLog('wechat','signup','用户数据',$user);

            if (key_exists('errcode', $user)) {
                loggingHelper::writeLog('wechat','signup','登录日志：请求错误信息',$user);

                return ResultHelper::json(401, $user['errmsg'], []);
            }
            $users['openid'] = $user['openid'];
            $users['unionid'] = key_exists('unionid', $user) ? $user['unionid'] : '';
        }
        // 查询该openID是否存在
        $res = Yii::$app->fans->signup($users);
        loggingHelper::writeLog('wechat','signup','登录日志：请求错误信息',$res);
        

        return ResultHelper::json(200, '登录成功', $res);
    }

    /**
     * @SWG\Post(path="/wechat/basics/payparameters",
     *     tags={"微信支付"},
     *     summary="获取支付参数",
     *     @SWG\Response(
     *         response = 200,
     *         description = "获取支付参数"
     *     ),
     *     @SWG\Parameter(
     *      in="query",
     *      name="access-token",
     *      type="string",
     *      description="access-token",
     *      required=true,
     *    ),
     *    @SWG\Parameter(
     *      name="openid",
     *      type="string",
     *      in="formData",
     *      description="openid",
     *      required=false
     *    ),
     *    @SWG\Parameter(
     *      name="trade_type",
     *      type="string",
     *      in="formData",
     *      default="JSAPI",
     *      enum={"JSAPI","NATIVE","APP","MWEB","MICROPAY"},
     *      description="支付类型:JSAPI-js支付/NATIVE-Native支付/APP--app支付/MWEB--h5支付/MICROPAY--付款码支付",
     *      required=true
     *    ),
     *   @SWG\Parameter(
     *      name="body",
     *      type="string",
     *      in="formData",
     *      description="订单名称",
     *      required=true
     *    ),
     *    @SWG\Parameter(
     *      name="out_trade_no",
     *      type="string",
     *      in="formData",
     *      description="订单编号",
     *      required=true
     *    ),
     *    @SWG\Parameter(
     *      name="total_fee",
     *      type="string",
     *      in="formData",
     *      description="支付总金额",
     *      required=true
     *    ),
     * )
     */
    public function actionPayparameters()
    {
        global $_GPC;

        $bloc_id = Yii::$app->params['bloc_id'];
        $store_id = Yii::$app->params['store_id'];
        $data = Yii::$app->request->post();
        if (empty(Yii::$app->params['wechatPaymentConfig']['mch_id'])) {
            return ResultHelper::json(401, '请检查商户号配置');
        }

        if (empty(Yii::$app->params['wechatPaymentConfig']['key'])) {
            return ResultHelper::json(401, '请检查支付秘钥配置');
        }

        // 生成订单
        $domain = Yii::$app->request->hostInfo;
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
        $logPath = Yii::getAlias('@runtime/wechat/payparameters'.date('ymd').'.log');
        FileHelper::writeLog($logPath, '订单数据'.json_encode(ArrayHelper::toArray($orderData)));

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
    public function actionNotify()
    {
        $logPath = Yii::getAlias('@runtime/wechat/notify/'.date('ymd').'.log');
        FileHelper::writeLog($logPath, '开始回调'.json_encode(Yii::$app->wechat->payment));

        $input = file_get_contents('php://input');

        FileHelper::writeLog($logPath, '开始回调'.json_encode($input));

        $response = Yii::$app->wechat->payment->handlePaidNotify(function ($message, $fail) {
            $logPath = Yii::getAlias('@runtime/wechat/notify/'.date('ymd').'.log');

            FileHelper::writeLog($logPath, Json::encode(ArrayHelper::toArray($message)));
            /////////////  建议在这里调用微信的【订单查询】接口查一下该笔订单的情况，确认是已经支付 /////////////

            // return_code 表示通信状态，不代表支付状态
            if ($message['return_code'] === 'SUCCESS') {
                FileHelper::writeLog($logPath, '成功回调'.$message['out_trade_no']);
                $orderInfo = DdCorePaylog::findOne(['uniontid' => $message['out_trade_no']]);
                FileHelper::writeLog($logPath, '订单信息'.json_encode($orderInfo));

                $module = $orderInfo['module'];

                FileHelper::writeLog($logPath, '下单模块'.$module);

                $notify = Yii::$app->getModule($module)->Notify($message);

                FileHelper::writeLog($logPath, '下单模块处理数据结构'.json_decode($notify));

                if ($notify) {
                    return true;
                }
            }

            return $fail('处理失败，请稍后再通知我');
        });
        FileHelper::writeLog($logPath, '回调完毕'.json_encode($response));

        $response->send();
    }

    // 退款回调
    public function actionRefundednotify()
    {
        $logPath = Yii::getAlias('@runtime/wechat/refundednotify/'.date('ymd').'.log');
        FileHelper::writeLog($logPath, '开始回调'.json_encode(Yii::$app->wechat->payment));

        $input = file_get_contents('php://input');

        FileHelper::writeLog($logPath, '退款回调数据'.json_encode($input));

        $response = Yii::$app->wechat->payment->handleRefundedNotify(function ($message, $reqInfo, $fail) {
            $logPath = Yii::getAlias('@runtime/wechat/refundednotify/'.date('ymd').'.log');

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

                FileHelper::writeLog($logPath, '全局更新日志结果'.json_decode($Res));

                $notify = Yii::$app->getModule($module)->Refundednotify($reqInfo);

                FileHelper::writeLog($logPath, '下单模块处理数据结构'.json_decode($notify));

                if ($notify) {
                    return true;
                }
            }

            return $fail('处理失败，请稍后再通知我');
        });
        FileHelper::writeLog($logPath, '回调完毕'.json_encode($response));

        $response->send();
    }
}
