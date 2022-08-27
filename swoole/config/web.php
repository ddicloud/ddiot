<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-19 20:27:34
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-27 15:47:37
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
    'modules' => [
        'settings' => [
            'class' => 'yii2mod\settings\Module',
        ],
        'v1' => [
            'class' => 'api\modules\v1\Module',
        ],
        // 'diandi_shop' => [
        //     'class' => 'api\modules\diandi_shop\module',
        // ],
        // 小程序
        'wechat' => [
            'class' => 'swooleService\modules\wechat\module',
        ],
        // 公众号
        'officialaccount' => [
            'class' => 'swooleService\modules\officialaccount\module',
        ],
    ],
    'components' => [
        'response' => [
            'class' => Response::class,
            'format' => Response::FORMAT_JSON
        ],
        'request' => [
            'class' => Request::class,
            'cookieValidationKey' => 'KHVLRGNziHXKUiHK'
        ],
        'wechat' => [
            'class' => 'common\components\wechat\Wechat',
            'userOptions' => [],  // 用户身份类参数
            'sessionParam' => 'wechatUser', // 微信用户信息将存储在会话在这个密钥
            'returnUrlParam' => '_wechatReturnUrl', // returnUrl 存储在会话中
            'rebinds' => [ // 自定义服务模块
                // 'cache' => 'common\components\Cache',
            ],
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
            'traceLevel' => YII_DEBUG ? 3 : 0,
            //'flushInterval' => 1,
            'targets' => [
               [
                  'class' => 'yii\log\FileTarget', //默认文件处理类
                  'levels' => ['error', 'warning','info'],
                  'exportInterval' => 1,
                  'categories' => ['ddicms'],
                  //'categories' => ['yii\*'],//$categories the message categories to filter by. If empty, it means all categories are allowed.
                  'logVars' => ['*'], //记录最基本的 []赋值也可以
                  //'logFile' => '@runtime/logs/order.log'.date('Ymd'),//用日期方式记录日志
                  'except' => [
                    'yii\web\HttpException:404',
                    'yii\web\HttpException:403',
                    'yii\web\HttpException:402',
                    'yii\web\HttpException:401',
                  ]
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
