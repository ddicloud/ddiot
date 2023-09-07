<?php

namespace Qiniu\Processing;

use Qiniu\Config;
use Qiniu\Http\Client;
use Qiniu\Http\Error;
use Qiniu\Processing\Operation;

/**
 * 持久化处理类,该类用于主动触发异步持久化操作.
 *
 * @link http://developer.qiniu.com/docs/v6/api/reference/fop/pfop/pfop.html
 */
final class PersistentFop
{
    /**
     * 账号管理密钥对，Auth对象
     * @var
     */
    private mixed $auth;

    /**
     * 操作资源所在空间
     * @var
     */
    private mixed $bucket;

    /**
     * 多媒体处理队列，详见
     * @var  https://portal.qiniu.com/mps/pipeline
     */
    private mixed $pipeline;

    /**
     * 持久化处理结果通知URL
     * @var
     */
    private mixed $notify_url;

    /**
     * 是否强制覆盖已有的重名文件
     * @var boolean
     */
    private mixed $force;


    public function __construct($auth, $bucket, $pipeline = null, $notify_url = null, $force = false)
    {
        $this->auth = $auth;
        $this->bucket = $bucket;
        $this->pipeline = $pipeline;
        $this->notify_url = $notify_url;
        $this->force = $force;
    }

    /**
     * 对资源文件进行异步持久化处理
     *
     * @param $key  string  待处理的源文件
     * @param $fops  array|string  待处理的pfop操作，多个pfop操作以array的形式传入。
     *                eg. avthumb/mp3/ab/192k, vframe/jpg/offset/7/w/480/h/360
     *
     * @return array 返回持久化处理的persistentId, 和返回的错误。
     *
     * @link http://developer.qiniu.com/docs/v6/api/reference/fop/
     */
    public function execute(string $key, array|string $fops): array
    {
        if (is_array($fops)) {
            $fops = implode(';', $fops);
        }
        $params = array('bucket' => $this->bucket, 'key' => $key, 'fops' => $fops);
        \Qiniu\setWithoutEmpty($params, 'pipeline', $this->pipeline);
        \Qiniu\setWithoutEmpty($params, 'notifyURL', $this->notify_url);
        if ($this->force) {
            $params['force'] = 1;
        }
        $data = http_build_query($params);
        $url = Config::API_HOST . '/pfop/';
        $headers = $this->auth->authorization($url, $data, 'application/x-www-form-urlencoded');
        $headers['Content-Type'] = 'application/x-www-form-urlencoded';
        $response = Client::post($url, $data, $headers);
        if (!$response->ok()) {
            return array(null, new Error($url, $response));
        }
        $r = $response->json();
        $id = $r['persistentId'];
        return array($id, null);
    }

    public static function status($id): array
    {
        $url = Config::API_HOST . "/status/get/prefop?id=$id";
        $response = Client::get($url);
        if (!$response->ok()) {
            return array(null, new Error($url, $response));
        }
        return array($response->json(), null);
    }
}
