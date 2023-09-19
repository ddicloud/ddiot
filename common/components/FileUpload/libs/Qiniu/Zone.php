<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-13 01:22:15
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-13 01:25:00
 */

namespace Qiniu;

use Qiniu\Http\Client;
use Qiniu\Http\Error;
use yii\base\ErrorException;

final class Zone
{
    public mixed $ioHost;            // 七牛源站Host
    public $upHost;
    public $upHostBackup;

    //array(
    //    <scheme>:<ak>:<bucket> ==>
    //        array('deadline' => 'xxx', 'upHosts' => array(), 'ioHost' => 'xxx.com')
    //)
    public $hostCache;
    public $scheme = 'Http';

    public function __construct($scheme = null)
    {
        $this->hostCache = array();
        if ($scheme != null) {
            $this->scheme = $scheme;
        }
    }

    public function getUpHostByToken($uptoken): array
    {
        try {
            list($ak, $bucket) = $this->unmarshalUpToken($uptoken);
        } catch (\Exception $e) {
        }
        list($upHosts, $err) = $this->getUpHosts($ak, $bucket);
        return array($upHosts[0], $err);
    }

    public function getBackupUpHostByToken($uptoken): array
    {
        try {
            list($ak, $bucket) = $this->unmarshalUpToken($uptoken);
            list($upHosts, $err) = $this->getUpHosts($ak, $bucket);

            $upHost = $upHosts[1] ?? $upHosts[0];
            return array($upHost, $err);
        } catch (\Exception $e) {
            throw new ErrorException($e->getMessage());
        }

    }

    public function getIoHost($ak, $bucket)
    {
        list($bucketHosts,) = $this->getBucketHosts($ak, $bucket);
        $ioHosts = $bucketHosts['ioHost'];
        return $ioHosts[0];
    }

    public function getUpHosts($ak, $bucket): array
    {
        list($bucketHosts, $err) = $this->getBucketHosts($ak, $bucket);
        if ($err !== null) {
            return array(null, $err);
        }

        $upHosts = $bucketHosts['upHosts'];
        return array($upHosts, null);
    }

    /**
     * @throws \Exception
     */
    private function unmarshalUpToken($uptoken): array
    {
        $token = explode(':', $uptoken);
        if (count($token) !== 3) {
            throw new \Exception("Invalid Uptoken", 1);
        }

        $ak = $token[0];
        $policy = base64_urlSafeDecode($token[2]);
        $policy = json_decode($policy, true);

        $scope = $policy['scope'];
        $bucket = $scope;

        if (strpos($scope, ':')) {
            $scopes = explode(':', $scope);
            $bucket = $scopes[0];
        }

        return array($ak, $bucket);
    }

    public function getBucketHosts($ak, $bucket): array
    {
        $key = $this->scheme . ":$ak:$bucket";

        $bucketHosts = $this->getBucketHostsFromCache($key);
        if (count($bucketHosts) > 0) {
            return array($bucketHosts, null);
        }

        list($hosts, $err) = $this->bucketHosts($ak, $bucket);
        if ($err !== null) {
            return array(null , $err);
        }

        $schemeHosts = $hosts[$this->scheme];
        $bucketHosts = array(
            'upHosts' => $schemeHosts['up'],
            'ioHost' => $schemeHosts['io'],
            'deadline' => time() + $hosts['ttl']
        );

        $this->setBucketHostsToCache($key, $bucketHosts);
        return array($bucketHosts, null);
    }

    private function getBucketHostsFromCache($key)
    {
        $ret = array();
        if (count($this->hostCache) === 0) {
            $this->hostCacheFromFile();
        }

        if (!array_key_exists($key, $this->hostCache)) {
            return $ret;
        }

        if ($this->hostCache[$key]['deadline'] > time()) {
            $ret = $this->hostCache[$key];
        }

        return $ret;
    }

    private function setBucketHostsToCache($key, $val): void
    {
        $this->hostCache[$key] = $val;
        $this->hostCacheToFile();
        return;
    }

    private function hostCacheFromFile(): void
    {

        $path = $this->hostCacheFilePath();
        if (!file_exists($path)) {
            return;
        }

        $bucketHosts = file_get_contents($path);
        $this->hostCache = json_decode($bucketHosts, true);
        return;
    }

    private function hostCacheToFile(): void
    {
        $path = $this->hostCacheFilePath();
        file_put_contents($path, json_encode($this->hostCache), LOCK_EX);
        return;
    }

    private function hostCacheFilePath(): string
    {
        return sys_get_temp_dir() . '/.qiniu_phpsdk_hostscache.json';
    }

    /*  请求包：
     *   GET /v1/query?ak=<ak>&&bucket=<bucket>
     *  返回包：
     *  
     *  200 OK {
     *    "ttl": <ttl>,              // 有效时间
     *    "Http": {
     *      "up": [],
     *      "io": [],                // 当bucket为global时，我们不需要iohost, io缺省
     *    },
     *    "https": {
     *      "up": [],
     *      "io": [],                // 当bucket为global时，我们不需要iohost, io缺省
     *    }
     *  }
     **/
    private function bucketHosts($ak, $bucket): array
    {
        $url = Config::UC_HOST . '/v1/query' . "?ak=$ak&bucket=$bucket";
        $ret = Client::Get($url);
        if (!$ret->ok()) {
            return array(null, new Error($url, $ret));
        }
        $r = ($ret->body === null) ? array() : $ret->json();
        return array($r, null);
    }
}
