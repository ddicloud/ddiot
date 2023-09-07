<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-13 01:22:15
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-13 01:25:03
 */

namespace Qiniu\Http;

use Qiniu\Config;
use Qiniu\Http\Request;
use Qiniu\Http\Response;

final class Client
{
    public static function get($url, array $headers = array()): \Qiniu\Http\Response
    {
        $request = new Request('GET', $url, $headers);
        return self::sendRequest($request);
    }

    public static function post($url, $body, array $headers = array()): \Qiniu\Http\Response
    {
        $request = new Request('POST', $url, $headers, $body);
        return self::sendRequest($request);
    }

    public static function multipartPost(
        $url,
        $fields,
        $name,
        $fileName,
        $fileBody,
        $mimeType = null,
        array $headers = array()
    ): \Qiniu\Http\Response
    {
        $data = array();
        $mimeBoundary = md5(microtime());

        foreach ($fields as $key => $val) {
            $data[] = '--' . $mimeBoundary;
            $data[] = "Content-Disposition: form-data; name=\"$key\"";
            $data[] = '';
            $data[] = $val;
        }

        $data[] = '--' . $mimeBoundary;
        $mimeType = empty($mimeType) ? 'application/octet-stream' : $mimeType;
        $fileName = self::escapeQuotes($fileName);
        $data[] = "Content-Disposition: form-data; name=\"$name\"; filename=\"$fileName\"";
        $data[] = "Content-Type: $mimeType";
        $data[] = '';
        $data[] = $fileBody;

        $data[] = '--' . $mimeBoundary . '--';
        $data[] = '';

        $body = implode("\r\n", $data);
        $contentType = 'multipart/form-data; boundary=' . $mimeBoundary;
        $headers['Content-Type'] = $contentType;
        $request = new Request('POST', $url, $headers, $body);
        return self::sendRequest($request);
    }

    private static function userAgent(): string
    {
        $sdkInfo = "QiniuPHP/" . Config::SDK_VER;

        $systemInfo = php_uname("s");
        $machineInfo = php_uname("m");

        $envInfo = "($systemInfo/$machineInfo)";

        $phpVer = phpversion();

        return "$sdkInfo $envInfo PHP/$phpVer";
    }

    public static function sendRequest($request): \Qiniu\Http\Response
    {
        $t1 = microtime(true);
        $ch = curl_init();
        $options = array(
            CURLOPT_USERAGENT => self::userAgent(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HEADER => true,
            CURLOPT_NOBODY => false,
            CURLOPT_CUSTOMREQUEST  => $request->method,
            CURLOPT_URL => $request->url
        );

        // Handle open_basedir & safe mode
        if (!ini_get('safe_mode') && !ini_get('open_basedir')) {
            $options[CURLOPT_FOLLOWLOCATION] = true;
        }

        if (!empty($request->headers)) {
            $headers = array();
            foreach ($request->headers as $key => $val) {
                $headers[] = "$key: $val";
            }
            $options[CURLOPT_HTTPHEADER] = $headers;
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));

        if (!empty($request->body)) {
            $options[CURLOPT_POSTFIELDS] = $request->body;
        }
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        $t2 = microtime(true);
        $duration = round($t2-$t1, 3);
        $ret = curl_errno($ch);
        if ($ret !== 0) {
            $r = new Response(-1, $duration, array(), null, curl_error($ch));
            curl_close($ch);
            return $r;
        }
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers = self::parseHeaders(substr($result, 0, $header_size));
        $body = substr($result, $header_size);
        curl_close($ch);
        return new Response($code, $duration, $headers, $body, null);
    }

    private static function parseHeaders($raw): array
    {
        $headers = array();
        $headerLines = explode("\r\n", $raw);
        foreach ($headerLines as $line) {
            $headerLine = trim($line);
            $kv = explode(':', $headerLine);
            if (count($kv) >1) {
                $headers[$kv[0]] = trim($kv[1]);
            }
        }
        return $headers;
    }

    private static function escapeQuotes($str): array|string
    {
        $find = array("\\", "\"");
        $replace = array("\\\\", "\\\"");
        return str_replace($find, $replace, $str);
    }
}
