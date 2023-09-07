<?php
namespace Qiniu\Storage;

use Qiniu\Http\Client;
use Qiniu\Http\Error;
use function Qiniu\crc32_data;

final class FormUploader
{

    /**
     * 上传二进制流到七牛, 内部使用
     *
     * @param $upToken  string  上传凭证
     * @param string $key string|null  上传文件名
     * @param $data     string  上传二进制流
     * @param $config
     * @param $params   array  自定义变量，规格参考
     *                    http://developer.qiniu.com/docs/v6/api/overview/up/response/vars.html#xvar
     * @param $mime     string  上传数据的mimeType
     * @param $checkCrc  bool 是否校验crc32
     *
     * @return array    包含已上传文件的信息，类似：
     *                                              [
     *                                                  "hash" => "<Hash string>",
     *                                                  "key" => "<Key string>"
     *                                              ]
     */
    public static function put(
        string $upToken,
        string $key,
        string $data,
        $config,
        array  $params,
        string $mime,
        bool $checkCrc
    ): array
    {
        $fields = array('token' => $upToken);
        if (empty($key)) {
            $fname = 'filename';
        } else {
            $fname = $key;
            $fields['key'] = $key;
        }
        if ($checkCrc) {
            $fields['crc32'] = crc32_data($data);
        }
        if ($params) {
            foreach ($params as $k => $v) {
                $fields[$k] = $v;
            }
        }

        list($upHost, $err) = $config->zone->getUpHostByToken($upToken);
        if ($err != null) {
            return array(null, $err);
        }

        $response = Client::multipartPost($upHost, $fields, 'file', $fname, $data, $mime);
        if (!$response->ok()) {
            return array(null, new Error($upHost, $response));
        }
        return array($response->json(), null);
    }

    /**
     * 上传文件到七牛，内部使用
     *
     * @param $upToken   string 上传凭证
     * @param $key       string 上传文件名
     * @param $filePath  string 上传文件的路径
     * @param $params    array 自定义变量，规格参考
     *                    http://developer.qiniu.com/docs/v6/api/overview/up/response/vars.html#xvar
     * @param $mime      string 上传数据的mimeType
     * @param $checkCrc  bool 是否校验crc32
     *
     * @return array    包含已上传文件的信息，类似：
     *                                              [
     *                                                  "hash" => "<Hash string>",
     *                                                  "key" => "<Key string>"
     *                                              ]
     */
    public static function putFile(
        string $upToken,
        string $key,
        string $filePath,
        $config,
        array  $params,
        string $mime,
        bool $checkCrc
    ): array
    {

        $fields = array('token' => $upToken, 'file' => self::createFile($filePath, $mime));

        if ($checkCrc) {
            $fields['crc32'] = \Qiniu\crc32_file($filePath);
        }
        if ($params) {
            foreach ($params as $k => $v) {
                $fields[$k] = $v;
            }
        }
        $fields['key'] = $key;
        $headers =array('Content-Type' => 'multipart/form-data');

        list($upHost, $err) = $config->zone->getUpHostByToken($upToken);
        if ($err != null) {
            return array(null, $err);
        }
        
        $response = client::post($upHost, $fields, $headers);
        if (!$response->ok()) {
            return array(null, new Error($upHost, $response));
        }
        return array($response->json(), null);
    }

    private static function createFile($filename, $mime): \CURLFile|string
    {
        // PHP 5.5 introduced a CurlFile object that deprecates the old @filename syntax
        // See: https://wiki.php.net/rfc/curl-file-upload
        if (function_exists('curl_file_create')) {
            return curl_file_create($filename, $mime);
        }

        // Use the old style if using an older version of PHP
        $value = "@{$filename}";
        if (!empty($mime)) {
            $value .= ';type=' . $mime;
        }

        return $value;
    }
}
