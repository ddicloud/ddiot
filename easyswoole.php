<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2023-07-05 10:10:04
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-07-05 10:18:15
 */

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/vendor/yiisoft/yii2/Yii.php';
require __DIR__ . '/common/config/bootstrap.php';
require __DIR__ . '/console/config/bootstrap.php';

$config = require __DIR__.'/common/config/easyswoole.php';

$http = new Swoole\Http\Server($config['host'], $config['port']);

$http->on("start", function(Swoole\Http\Server $server) {
    echo "EasySwoole server is running at http://{$server->host}:{$server->port}\n";
});

$configYii = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/common/config/main.php',
    require __DIR__ . '/common/config/main-local.php',
    require __DIR__ . '/console/config/main.php',
    require __DIR__ . '/console/config/main-local.php',
);

$http->on("request", function($request, $response) use ($configYii) {
    $app = new yii\console\Application($configYii);
    $app->runAction('swoole/index');

    $content = ob_get_clean();

    $response->end($content);
});

$http->start();
