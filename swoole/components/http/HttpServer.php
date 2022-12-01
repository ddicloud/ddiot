<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-08-17 09:25:45
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-12-01 16:42:45
 */
namespace ddswoole\components\http;

use diandi\swoole\web\server\WebServer;
use Swoole\Http\Request;
use Swoole\Http\Response;

class HttpServer extends WebServer
{
    
    public function checkUpgrade(Request $request, Response $ws)
    {
        return true;
    }
}

?>