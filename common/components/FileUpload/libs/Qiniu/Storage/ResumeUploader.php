<?php
namespace Qiniu\Storage;

use Qiniu\Config;
use Qiniu\Http\Client;
use Qiniu\Http\Error;

/**
 * 断点续上传类, 该类主要实现了断点续上传中的分块上传,
 * 以及相应地创建块和创建文件过程.
 *
 * @link http://developer.qiniu.com/docs/v6/api/reference/up/mkblk.html
 * @link http://developer.qiniu.com/docs/v6/api/reference/up/mkfile.html
 */
final class ResumeUploader
{
    private string $upToken;
    private string $key;
    private string $inputStream;
    private int $size;
    private array $params;
    private string $mime;
    private array $contexts;
    private string $host;
    private string $currentUrl;
    private array $config;

    /**
     * 上传二进制流到七牛
     *
     * @param $upToken  string  上传凭证
     * @param $key       string 上传文件名
     * @param $inputStream string 上传二进制流
     * @param $size      int 上传流的大小
     * @param $params    array 自定义变量
     * @param $mime      string 上传数据的mimeType
     * @param $config
     * @throws \Exception
     * @link http://developer.qiniu.com/docs/v6/api/overview/up/response/vars.html#xvar
     */
    public function __construct(
        string $upToken,
        string $key,
        string $inputStream,
        int    $size,
        array  $params,
        string $mime,
               $config
    ) {
        $this->upToken = $upToken;
        $this->key = $key;
        $this->inputStream = $inputStream;
        $this->size = $size;
        $this->params = $params;
        $this->mime = $mime;
        $this->contexts = array();
        $this->config = $config;

        list($upHost, $err) = $config->zone->getUpHostByToken($upToken);
        if ($err != null) {
            throw new \Exception($err, 1);
        }
        $this->host = $upHost;
    }

    /**
     * 上传操作
     * @throws \Exception
     */
    public function upload(): array
    {
        $uploaded = 0;
        while ($uploaded < $this->size) {
            $blockSize = $this->blockSize($uploaded);
            $data = fread($this->inputStream, $blockSize);
            if ($data === false) {
                throw new \Exception("file read failed", 1);
            }
            $crc = \Qiniu\crc32_data($data);
            $response = $this->makeBlock($data, $blockSize);
            $ret = null;
            if ($response->ok() && $response->json() != null) {
                $ret = $response->json();
            }
            if ($response->statusCode < 0) {
                list($bakHost, $err) = $this->config->zone->getBackupUpHostByToken($this->upToken);
                if ($err != null) {
                    return array(null, $err);
                }
                $this->host = $bakHost;
            }
            if ($response->needRetry() || !isset($ret['crc32']) || $crc != $ret['crc32']) {
                $response = $this->makeBlock($data, $blockSize);
                $ret = $response->json();
            }

            if (! $response->ok() || !isset($ret['crc32'])|| $crc != $ret['crc32']) {
                return array(null, new Error($this->currentUrl, $response));
            }
            $this->contexts[] = $ret['ctx'];
            $uploaded += $blockSize;
        }
        return $this->makeFile();
    }

    /**
     * 创建块
     */
    private function makeBlock($block, $blockSize): \Qiniu\Http\Response
    {
        $url = $this->host . '/mkblk/' . $blockSize;
        return $this->post($url, $block);
    }

    private function fileUrl(): string
    {
        $url = $this->host . '/mkfile/' . $this->size;
        $url .= '/mimeType/' . \Qiniu\base64_urlSafeEncode($this->mime);
        if ($this->key != null) {
            $url .= '/key/' . \Qiniu\base64_urlSafeEncode($this->key);
        }
        if (!empty($this->params)) {
            foreach ($this->params as $key => $value) {
                $val =  \Qiniu\base64_urlSafeEncode($value);
                $url .= "/$key/$val";
            }
        }
        return $url;
    }

    /**
     * 创建文件
     */
    private function makeFile(): array
    {
        $url = $this->fileUrl();
        $body = implode(',', $this->contexts);
        $response = $this->post($url, $body);
        if ($response->needRetry()) {
            $response = $this->post($url, $body);
        }
        if (! $response->ok()) {
            return array(null, new Error($this->currentUrl, $response));
        }
        return array($response->json(), null);
    }

    private function post($url, $data): \Qiniu\Http\Response
    {
        $this->currentUrl = $url;
        $headers = array('Authorization' => 'UpToken ' . $this->upToken);
        return Client::post($url, $data, $headers);
    }

    private function blockSize($uploaded): int
    {
        if ($this->size < $uploaded + Config::BLOCK_SIZE) {
            return $this->size - $uploaded;
        }
        return  Config::BLOCK_SIZE;
    }
}
