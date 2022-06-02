<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-05-13 17:04:46
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-01 15:54:25
 */

namespace common\helpers\encrypts;

use InvalidArgumentException;

class AesEncrypt
{
    /**
     * 密钥.
     *
     * @var string
     */
    protected $key = '';

    /**
     * 偏移量.
     *
     * @var string
     */
    protected $iv = '';

    /**
     * 加密方式.
     *
     * @var string
     */
    protected $method = '';

    public function __construct(string $key, string $iv, string $method = 'AES-256-CBC')
    {
        $this->key = $key;
        $this->iv = $iv;
        $this->method = $method;
    }

    /**
     * 加密.
     *
     * @param string|array $data
     *
     * @throws
     */
    public function encrypt($data): string
    {
        if (! is_string($data) && ! is_array($data) && ! is_numeric($data)) {
            throw new InvalidArgumentException('The encrypt data must be a string or an array.');
        }

        if (is_array($data)) {
            $data = json_encode($data);
        }

        return base64_encode(openssl_encrypt($data, $this->method, $this->key, OPENSSL_RAW_DATA, $this->iv));
    }

    /**
     * 解密.
     *
     * @return string|array
     */
    public function decrypt(string $data)
    {
        $data = openssl_decrypt(base64_decode($data), $this->method, $this->key, OPENSSL_RAW_DATA, $this->iv);

        $array = json_decode($data, true);

        return is_array($array) ? $array : $data;
    }
}
