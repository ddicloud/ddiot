<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-19 20:27:34
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-22 14:25:22
 */



use diandi\swoole\web\ErrorHandler;
use diandi\swoole\web\Request;
use diandi\swoole\web\Response;
use yii\caching\FileCache;

require(__DIR__ . '/../../common/config/bootstrap.php');
$db = require(__DIR__ . '/../../common/config/db.php');

return [
    'id' => 'app-swoole',
    'name' => '店滴Swoole',
    'basePath' => dirname(__DIR__),
    'language' => 'zh-CN',
    'bootstrap' => [
        'diandi\addons\loader',
        'log'
    ],
    'controllerNamespace' => 'swooleService\controllers',
    'taskNamespace' => 'swooleService\tasks',
    'aliases' => [
        '@swooleService' => dirname(__DIR__),
        '@diandi' => '@vendor/yii-diandi',
    ],
    'modules' => [],
    'components' => [
        'response' => [
            'class' => Response::class,
            'format' => Response::FORMAT_JSON
        ],
        'request' => [
            'class' => Request::class,
            'cookieValidationKey' => 'KHVLRGNziHXKUiHK'
        ],
        'user' => [
            'identityClass' => 'swooleService\models\SwooleAccessToken',
            'enableAutoLogin' => true,
            'enableSession' => true,
            'loginUrl' => null,
        ],
        // 缓存组件
        'cachehelper' => [
            'class' => 'common\helpers\CacheHelper',
        ],
        /* ------ 队列设置 ------ **/
        'queue' => [
            'class' => 'yii\queue\redis\Queue',
            'redis' => 'redis', // 连接组件或它的配置
            'channel' => 'queue', // Queue channel key
            'as log' => 'yii\queue\LogBehavior', // 日志
        ],
        'settings' => [
            'class' => 'yii2mod\settings\components\Settings',
            'modelClass' => 'common\models\Setting',
        ],
        'helper' => [
            'class' => 'common\components\helpers\helper',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => []
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'service' => [
            'class' => 'common\services\BaseService',
        ],
        'errorHandler' => [
            'class' => ErrorHandler::class
        ],
        'db' => $db,
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 2
        ],
        'cache' => [
            'class' => 'yii\redis\Cache',
        ],
    ],
    'params' => require __DIR__ . '/params.php'
];
