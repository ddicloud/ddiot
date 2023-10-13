<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-23 20:21:49
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-09-14 20:38:11
 */
$params = array_merge(
    require __DIR__.'/../../common/config/params.php',
    require __DIR__.'/../../common/config/params-local.php',
    require __DIR__.'/params.php',
    require __DIR__.'/params-local.php'
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'queue'],
    'controllerNamespace' => 'console\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'controllerMap' => [
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
        ],
        /* ------ 数据库命令行备份 ------ **/
        'migrate' => [
            'class' => 'diandi\migration\ConsoleController',
        ],
    ],
    'components' => [
        'request' => [
            'class' => 'console\services\request',
        ],
        'response' => [
            'class' => 'console\services\response',
        ],
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'common\models\Users',
            'enableSession' => false,
            'enableAutoLogin' => false,
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
        'session' => [
            'class' => 'yii\web\Session',
        ],
        'context' => [
            'class' => 'diandi\swoole\coroutine\Context',
        ],
        'authManager' => [
            'class' => 'diandi\\admin\\components\\DbManager', // 使用数据库管理配置文件
            'defaultRoles' => ['基础权限组'], //默认角色
        ],
    ],
    'params' => $params,
];
