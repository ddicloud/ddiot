<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2017-11-25 17:20:18
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-07-05 17:06:09
 */


namespace common\components\SenangPay;

use common\helpers\ResultHelper;
use GuzzleHttp\Client;

class SenangPay
{
    /**
     * 支付正式域名.
     *
     * @var string
     */
    private static $senangPayUrl = 'https://api.senangpay.my';


    /**
     * 沙盒接口域名
     * @var string
     * @date 2023-07-05
     * @example
     * @author Wang Chunsheng
     * @since
     */
    private static $testPayUrl = 'https://sandbox.senangpay.my';


    /**
     * 当前环境 0代表测试环境1代表正式环境
     * @var [number]
     * @date 2023-07-05
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public static $env;

    /**
     * senangPay Merchant ID.
     *
     * @var string
     */
    private static $merchantId;

    /**
     * senangPay Secret Key.
     *
     * @var string
     */
    private static $secretKey;

    /**
     * 请求头部
     * @var [type]
     * @date 2023-07-05
     * @example
     * @author Wang Chunsheng
     * @since
     */
    private static $header = [];

    const    PREAUTH_BY_TOKEN = '/apiv1/preauth_by_token'; //预授权接口
    const    PREAUTH_CAPTURE  =  '/apiv1/preauth_capture'; //预授权 – 捕获
    const    QUERY_ORDER_STATUS  = '/apiv1/query_order_status'; //查看订单状态
    const    GET_TRANSACTION_LIST  = '/apiv1/get_transaction_list'; //获取交易列表
    const    PAY_CC  = '/apiv1/pay_cc'; //信用卡支付
    const    UPDATE_TOKEN_STATUS  =  '/apiv1/update_token_status'; // 启用和禁用信用卡
    const    PAYMENT  = '/payment'; //付款接口
    const    FPX_BANK_LIST  = '/fpx_bank_list'; //银行列表

    /**
     * Construct a new senangPay instance
     *
     * @param string $merchantId
     * @param string $secretKey
     * @param string|null $senangPayUrl
     *
     * @return string
     **/
    public function __construct($merchantId, $secretKey, $env = 0)
    {
        $this->secretKey = $secretKey;
        $this->merchantId = $merchantId;
        $this->env = $env;
        $this->header = [
            'auth' => [$merchantId, $secretKey]
        ];
    }

    /**
     * Get Merchant Id
     *
     * @return string|null
     **/
    public function getMerchantId()
    {
        return $this->merchantId;
    }


    public static function createData($data)
    {
        $merchant_id = self::$merchantId;
        $secret_key = self::$secretKey;
        $string = implode('', $data);
        $hash = hash_hmac('sha256', $merchant_id . $secret_key . $string, $secret_key);
        $data['hash'] = $hash;
        return $data;
    }

    public static function getUrl()
    {
        if ((int) self::$env === 1) {
            return  self::$senangPayUrl;
        } else {
            return  self::$testPayUrl;
        }
    }

    /**
     * 统一请求
     *
     * @param [type] $datas   请求参数
     * @param [type] $url     请求地址
     * @param array  $params  地址栏的参数
     * @param array  $headers 请求头部
     *
     * @return void
     * @date 2022-05-11
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public static function postHttp($url, $data, $headers = [])
    {
        $base_uri = self::getUrl();
        $headers = array_merge(self::$header, $headers);

        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => $base_uri,
            // You can set any number of default request options.
            'timeout' => 10,
        ]);

        $res = $client->request('POST', $url, [
            'form_params' => $data,
            'headers' => $headers,
        ]);
        $body = $res->getBody();
        $remainingBytes = $body->getContents();

        return self::analysisRes(json_decode($remainingBytes, true));
    }


    /**
     * 统一请求
     *
     * @param [type] $datas   请求参数
     * @param [type] $url     请求地址
     * @param array  $params  地址栏的参数
     * @param array  $headers 请求头部
     *
     * @return void
     * @date 2022-05-11
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public static function getHttp($url, $data, $headers = [])
    {
        $base_uri = self::getUrl();

        $headers = array_merge(self::$header, $headers);

        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => $base_uri,
            // You can set any number of default request options.
            'timeout' => 10,
        ]);

        $res = $client->request('GET', $url, [
            'form_params' => $data,
            'headers' => $headers,
        ]);
        $body = $res->getBody();
        $remainingBytes = $body->getContents();

        return self::analysisRes(json_decode($remainingBytes, true));
    }


    // 解析返回的内容
    public static function analysisRes($Res)
    {
        if ((int) $Res['errcode']) {
            return ResultHelper::serverJson($Res['errcode'], $Res['errmsg'], $Res);
        } else {
            $data = [
                'code' => $Res['resultCode'],
                'content' => $Res['reason'],
            ];

            return ResultHelper::serverJson(200, '获取成功', $Res);
        }
    }

    /**
     * 预授权接口 post
     * @return void
     * @date 2023-07-05
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public function preauthByToken()
    {
        $url = self::PREAUTH_BY_TOKEN;
        $data = self::createData([]);
        $Res  =  self::postHttp($url, $data);
        return $Res;
    }

    /**
     * 预授权 – 捕获 post
     * @return void
     * @date 2023-07-05
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public function preauthCapture()
    {
        $url = self::PREAUTH_CAPTURE;
        $data = self::createData([]);
        $Res  =  self::postHttp($url, $data);
        return $Res;
    }

    /**
     * 查看订单状态 GET
     * @return void
     * @date 2023-07-05
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public function queryOrderStatus($order_id)
    {
        // merchant_id:889167583736038
        // order_id:25527336
        // hash:746e8e8382996ebc9259c4f1051ad4edf3854098a53827bddd09b40d6efc1d0c
        $url = self::QUERY_ORDER_STATUS;
        $data = self::createData([
            'merchant_id' => $this->merchantId,
            'order_id' => $order_id
        ]);
        $Res  =  self::getHttp($url, $data);
        return $Res;
    }

    /**
     * 获取交易列表 GET
     * @param [type] $merchant_id
     * @param [type] $timestamp_start
     * @param [type] $timestamp_end
     * @return void
     * @date 2023-07-05
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public function getTransactionList($timestamp_start, $timestamp_end)
    {
        // merchant_id:889167583736038
        // timestamp_start:1685946990
        // timestamp_end:1688538991
        // hash:645f6b627c2395fd15f9d9f2b218143e5a6ed80163bf03de9b4501407be7dbc6
        $url = self::GET_TRANSACTION_LIST;
        $data = self::createData([
            'merchant_id' => $this->merchantId,
            'timestamp_start' => $timestamp_start,
            'timestamp_end' => $timestamp_end
        ]);
        $Res  =  self::getHttp($url, $data);
        return $Res;
    }

    /**
     * 信用卡支付 GET
     * @return void
     * @date 2023-07-05
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public function payCc($name, $email, $detail, $phone, $order_id, $amount)
    {
        $url = self::PAY_CC;
        $data = self::createData([
            'name' => $name,
            'email' => $email,
            'detail' => $detail,
            'phone' => $phone,
            'order_id' => $order_id,
            'amount' => $amount,
        ]);
        $Res  =  self::getHttp($url, $data);
        return $Res;
    }

    /** post
     * 启用和禁用信用卡
     * @return void
     * @date 2023-07-05
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public function updateTokenStatus($token)
    {
        $url = self::UPDATE_TOKEN_STATUS;
        $data = self::createData([
            'token' => $token
        ]);
        $Res  =  self::postHttp($url, $data);
        return $Res;
    }

    /**
     * 付款接口 post
     * @return void
     * @date 2023-07-05
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public function payment($payment_method, $fpx_bank_code, $customer_name, $customer_email, $order_id, $amount, $detail)
    {
        $url = self::PAYMENT;
        $data = self::createData([
            'payment_method' => $payment_method,
            'fpx_bank_code' => $fpx_bank_code,
            'customer_name' => $customer_name,
            'customer_email' => $customer_email,
            'order_id' => $order_id,
            'amount' => $amount,
            'detail' => $detail
        ]);
        $Res  =  self::postHttp($url, $data);
        return $Res;
    }

    /**
     * 银行列表 get
     * @return void
     * @date 2023-07-05
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public function fpxBankList($fpx_bank_list)
    {
        $url = self::FPX_BANK_LIST;
        $data = self::createData([
            'fpx_bank_list' => $fpx_bank_list
        ]);
        $Res  =  self::getHttp($url, $data);
        return $Res;
    }



    /**
     * Create Hash for senangPay Payment URL
     *
     * @param string $detail
     * @param float $amount
     * @param string $orderId
     *
     * @return string|null
     **/
    public function createHash($detail, $amount, $orderId, $status_id, $transaction_id, $msg)
    {
        // Construct string from data
        $stringData = $this->secretKey .  urldecode($status_id) . urldecode($orderId) . urldecode($transaction_id) . urldecode($msg);


        // generate md5 hash for stringData
        $hashString = md5($stringData);

        return $hashString;
    }

    /**
     * callback function for callback url
     *
     * @param Type $var Description
     * @return bool
     **/
    public function callback(array $data = [])
    {
        $statusId = urldecode($data['status_id']);
        $orderId = urldecode($data['order_id']);
        $msg = urldecode($data['msg']);
        $transactionId = urldecode($data['transaction_id']);
        $hash = urldecode($data['hash']);

        $hashString = md5($this->secretKey . $statusId . $orderId . $transactionId . $msg);

        if ($hashString == $hash) {
            unset($data['hash']);
            return $data;
        } else {
            return [];
        }
    }
}
