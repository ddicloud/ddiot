<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2017-11-25 17:20:18
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-07-06 09:09:15
 */


namespace common\components\SenangPay;

use common\helpers\ResultHelper;
use ErrorException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class SenangPay
{
    /**
     * 支付正式域名.
     *
     * @var string
     */
    private static string $senangPayUrl = 'https://api.senangpay.my/';


    /**
     * 沙盒接口域名
     * @var string
     * @date 2023-07-05
     * @example
     * @author Wang Chunsheng
     * @since
     */
    private static string $testPayUrl = 'https://sandbox.senangpay.my/';


    /**
     * 当前环境 0代表测试环境1代表正式环境
     * @var int
     * @date 2023-07-05
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public static int $env;

    /**
     * senangPay Merchant ID.
     *
     * @var string
     */
    private static string $merchantId;

    /**
     * senangPay Secret Key.
     *
     * @var string
     */
    private static string $secretKey;

    /**
     * 请求头部
     * @var array
     * @date 2023-07-05
     * @example
     * @author Wang Chunsheng
     * @since
     */
    private static array $header = [];

    const    PREAUTH_BY_TOKEN = 'apiv1/preauth_by_token'; //预授权接口
    const    PREAUTH_CAPTURE  =  'apiv1/preauth_capture'; //预授权 – 捕获
    const    QUERY_ORDER_STATUS  = 'apiv1/query_order_status'; //查看订单状态
    const    GET_TRANSACTION_LIST  = 'apiv1/get_transaction_list'; //获取交易列表
    const    PAY_CC  = 'apiv1/pay_cc'; //信用卡支付
    const    UPDATE_TOKEN_STATUS  =  'apiv1/update_token_status'; // 启用和禁用信用卡
    const    PAYMENT  = 'payment'; //付款接口
    const    FPX_BANK_LIST  = 'fpx_bank_list'; //银行列表
    const    QUERY_TRANSACTION_STATUS = '/apiv1/query_transaction_status'; //查询交易状态


    /**
     * Construct a new senangPay instance
     *
     * @param string $merchantId
     * @param string $secretKey
     * @param int $env
     */
    public function __construct(string $merchantId, string $secretKey, int $env = 0)
    {
        self::$secretKey = $secretKey;
        self::$merchantId = $merchantId;
        $this->setEnv($env);
        $this->setHeader($merchantId, $secretKey);
    }

    public function setHeader($merchantId, $secretKey): void
    {
        self::$header =  [
            'auth' => [$merchantId, $secretKey]
        ];
    }

    public function setEnv($env): void
    {
        self::$env = $env;
    }

    public function getEnv($env): int
    {
        return self::$env;
    }

    /**
     * Get Merchant Id
     *
     * @return string|null
     **/
    public function getMerchantId(): ?string
    {
        return self::$merchantId;
    }


    public static function createData($data)
    {
        $merchant_id = self::$merchantId;
        $secret_key = self::$secretKey;
        // unset($data['merchant_id']);
        $string = implode('', $data);
        $string = str_replace($merchant_id, '', $string);
        $hash = hash_hmac('sha256', $merchant_id . $secret_key . $string, $secret_key);
        $data['hash'] = $hash;

        return $data;
    }

    public static function getUrl(): string
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
     * @param $url
     * @param $data
     * @param array $headers 请求头部
     *
     * @return array
     * @throws GuzzleException
     * @date 2022-05-11
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public static function postHttp($url, $data, array $headers = []): array
    {
        $base_uri = self::getUrl();
        $headers = array_merge(self::$header, $headers);

        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => $base_uri,
            // You can set any number of default request options.
            'timeout' => 10,
            'verify' => false
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
     * @param $url
     * @param $data
     * @param array $headers 请求头部
     *
     * @return array
     * @throws GuzzleException
     * @date 2022-05-11
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public static function getHttp($url, $data, array $headers = []): array
    {
        $base_uri = self::getUrl();

        $headers = array_merge(self::$header, $headers);

        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => $base_uri,
            // You can set any number of default request options.
            'timeout' => 10,
            // 'verify' => false,
            'headers' => $headers,
        ]);

        $res = $client->request('GET', $url, [
            'query' => $data,
            // 'auth' => [
            //     self::$merchantId, self::$secretKey
            // ],

        ]);

        $body = $res->getBody();
        $remainingBytes = $body->getContents();

        return self::analysisRes(json_decode($remainingBytes, true));
    }


    // 解析返回的内容
    public static function analysisRes($Res)
    {
        if ((int) $Res['status'] != 1) {
            return ResultHelper::json(400, $Res['msg'], $Res['data']);
        } else {
            return ResultHelper::json(200, '获取成功', $Res['data']);
        }
    }

    /**
     * 预授权接口 post
     * @return array
     * @throws ErrorException
     * @date 2023-07-05
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public function preauthByToken(): array
    {
        $url = self::PREAUTH_BY_TOKEN;
        $data = self::createData([]);
        try {
            return self::postHttp($url, $data);
        } catch (GuzzleException $e) {
            throw new ErrorException($e->getMessage());
        }
    }

    /**
     * 预授权 – 捕获 post
     * @return array
     * @date 2023-07-05
     * @throws ErrorException
     * @author Wang Chunsheng
     * @since
     * @example
     */
    public function preauthCapture(): array
    {
        $url = self::PREAUTH_CAPTURE;
        $data = self::createData([]);
        try {
            return self::postHttp($url, $data);
        } catch (GuzzleException $e) {
            throw new ErrorException($e->getMessage());
        }
    }

    /**
     * 查询交易状态
     * @param [type] $transaction_reference
     * @return array
     * @throws GuzzleException
     * @date 2023-07-06
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public function queryTransactionStatus($transaction_reference): array
    {
        // merchant_id:889167583736038
        // order_id:25527336
        // hash:746e8e8382996ebc9259c4f1051ad4edf3854098a53827bddd09b40d6efc1d0c
        $url = self::QUERY_TRANSACTION_STATUS;
        $data = self::createData([
            'merchant_id' => self::$merchantId,
            'transaction_reference' => $transaction_reference
        ]);
        return self::getHttp($url, $data);
    }

    /**
     * 查看订单状态 GET
     * @param $order_id
     * @return array
     * @throws GuzzleException
     * @date 2023-07-05
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public function queryOrderStatus($order_id): array
    {
        // merchant_id:889167583736038
        // order_id:25527336
        // hash:746e8e8382996ebc9259c4f1051ad4edf3854098a53827bddd09b40d6efc1d0c
        $url = self::QUERY_ORDER_STATUS;
        $data = self::createData([
            'merchant_id' => self::$merchantId,
            'order_id' => $order_id
        ]);
        return self::getHttp($url, $data);
    }

    /**
     * 获取交易列表 GET
     * @param $timestamp_start
     * @param $timestamp_end
     * @return array
     * @throws GuzzleException
     * @date 2023-07-05
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public function getTransactionList($timestamp_start, $timestamp_end): array
    {
        // merchant_id:889167583736038
        // timestamp_start:1685946990
        // timestamp_end:1688538991
        // hash:645f6b627c2395fd15f9d9f2b218143e5a6ed80163bf03de9b4501407be7dbc6
        $url = self::GET_TRANSACTION_LIST;
        $url = 'https://app.senangpay.my/apiv1/get_transaction_list';
        $data = self::createData([
            'merchant_id' => self::$merchantId,
            'timestamp_start' => $timestamp_start,
            'timestamp_end' => $timestamp_end
        ]);
        return self::getHttp($url, $data);
    }

    /**
     * 信用卡支付 GET
     * @param $name
     * @param $email
     * @param $detail
     * @param $phone
     * @param $order_id
     * @param $amount
     * @return array
     * @throws GuzzleException
     * @date 2023-07-05
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public function payCc($name, $email, $detail, $phone, $order_id, $amount): array
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
     * @param $token
     * @return array
     * @throws GuzzleException
     * @date 2023-07-05
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public function updateTokenStatus($token): array
    {
        $url = self::UPDATE_TOKEN_STATUS;
        $data = self::createData([
            'token' => $token
        ]);
        return self::postHttp($url, $data);
    }

    /**
     * 付款接口 post
     * @param $payment_method
     * @param $fpx_bank_code
     * @param $customer_name
     * @param $customer_email
     * @param $order_id
     * @param $amount
     * @param $detail
     * @return array|null
     * @throws GuzzleException
     * @date 2023-07-05
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public function payment($payment_method, $fpx_bank_code, $customer_name, $customer_email, $order_id, $amount, $detail): ?array
    {
        $url = self::PAYMENT;
        $url = 'https://sandbox.senangpay.my/apiv1/get_transaction_list' . $url;

        $data = self::createData([
            'payment_method' => $payment_method,
            'fpx_bank_code' => $fpx_bank_code,
            'customer_name' => $customer_name,
            'customer_email' => $customer_email,
            'order_id' => $order_id,
            'amount' => $amount,
            'detail' => $detail
        ]);
        return self::postHttp($url, $data);
    }

    /**
     * 银行列表 get
     * @param $fpx_bank_list
     * @return array
     * @throws GuzzleException
     * @date 2023-07-05
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public function fpxBankList($fpx_bank_list): array
    {
        $url = self::FPX_BANK_LIST;
        $data = self::createData([
            'fpx_bank_list' => $fpx_bank_list
        ]);
        return self::getHttp($url, $data);
    }


    /**
     * Create Hash for senangPay Payment URL
     *
     * @param string $detail
     * @param float $amount
     * @param string $orderId
     * @param $status_id
     * @param $transaction_id
     * @param $msg
     * @return string|null
     */
    public function createHash(string $detail, float $amount, string $orderId, $status_id, $transaction_id, $msg): ?string
    {
        // Construct string from data
        $stringData = self::$secretKey .  urldecode($status_id) . urldecode($orderId) . urldecode($transaction_id) . urldecode($msg);


        // generate md5 hash for stringData
        return md5($stringData);
    }

    /**
     * callback function for callback url
     *
     * @param array $data
     * @return bool|array
     */
    public function callback(array $data = []): bool|array
    {
        $statusId = urldecode($data['status_id']);
        $orderId = urldecode($data['order_id']);
        $msg = urldecode($data['msg']);
        $transactionId = urldecode($data['transaction_id']);
        $hash = urldecode($data['hash']);

        $hashString = md5(self::$secretKey . $statusId . $orderId . $transactionId . $msg);

        if ($hashString == $hash) {
            unset($data['hash']);
            return $data;
        } else {
            return [];
        }
    }
}
