<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2023-07-05 10:10:04
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-07-05 10:11:23
 */


require_once 'vendor/autoload.php';

$config = require __DIR__.'/common/config/easyswoole.php';

$http = new Swoole\Http\Server($config['host'], $config['port']);

$http->on("start", function(Swoole\Http\Server $server) {
    echo "EasySwoole server is running at http://{$server->host}:{$server->port}\n";
});

$http->on("request", function($request, $response) {
    $app = new yii\console\Application(require __DIR__.'/common/config/main.php');
    $app->runAction('swoole/index');

    $content = ob_get_clean();

    $response->end($content);
});

$http->start();
