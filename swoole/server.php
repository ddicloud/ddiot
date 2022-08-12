<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-19 20:26:00
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-12 15:49:34
 */
defined('COROUTINE_ENV') or define('COROUTINE_ENV', true);

use diandi\swoole\server\BaseServer;
use Swoole\Runtime;

Runtime::enableCoroutine(false);
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', getenv('PHP_ENV') === 'development' ? 'dev' : 'prod');

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../vendor/yiisoft/yii2/Yii.php';

// $config = require __DIR__.'/config/base.php';


$config = yii\helpers\ArrayHelper::merge(
    [
        'app'=>[
            'params'=> yii\helpers\ArrayHelper::merge(
                require(__DIR__ . '/../common/config/params.php'),
                require(__DIR__ . '/../common/config/params-local.php'),
            )
        ]
    ],
    require __DIR__ . '/config/base.php'
);

$server = new BaseServer($config);
$server->run();
