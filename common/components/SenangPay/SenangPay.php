<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2017-11-25 17:20:18
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-06-27 18:41:37
 */


namespace common\components\SenangPay;

class SenangPay
{
    /**
     * senangPay Url.
     *
     * @var string
     */
    private $senangPayUrl;

    /**
     * senangPay Merchant ID.
     *
     * @var string
     */
    private $merchantId;

    /**
     * senangPay Secret Key.
     *
     * @var string
     */
    private $secretKey;

    /**
     * Construct a new senangPay instance
     *
     * @param string $merchantId
     * @param string $secretKey
     * @param string|null $senangPayUrl
     *
     * @return string
     **/
    public function __construct($merchantId, $secretKey, $senangPayUrl = null)
    {
        $this->senangPayUrl = $senangPayUrl ? $senangPayUrl : 'https://app.senangpay.my';
        $this->secretKey = $secretKey;
        $this->merchantId = $merchantId;
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

    /**
     * Generate senangPay Payment URL
     *
     * @param Object $params Parameters for senangPay Payment URL
     *
     * @return string
     **/
    public function createPayment($detail, $amount, $orderId, $status_id, $transaction_id, $msg)
    {
        // Construct params
        $params = [
            'detail' => $detail,
            'amount' => $amount,
            'order_id' => $orderId,
            'status_id' => $status_id,
            'transaction_id' => $transaction_id,
            'msg' => $msg,
            'hash' => $this->createHash($detail, $amount, $orderId, $status_id, $transaction_id, $msg)
        ];


        // Create senangPay payment URL
        $url = $this->senangPayUrl . '/payment/' . $this->merchantId . '?' . http_build_query($params);

        return $url;
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
