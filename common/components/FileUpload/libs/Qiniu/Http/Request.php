<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-13 01:22:15
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-25 17:39:14
 */

namespace Qiniu\Http;

final class Request
{
    public string  $url;
    public array $headers;
    public mixed $body;
    public string $method;

    public function __construct($method, $url, array $headers = [], $body = null)
    {
        $this->method = strtoupper($method);
        $this->url = $url;
        $this->headers = $headers;
        $this->body = $body;
    }
}
