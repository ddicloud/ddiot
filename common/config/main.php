<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-02-29 16:57:27
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-07-05 11:36:39
 */

use yii\mutex\MysqlMutex;
use yii\queue\db\Queue;

return [
    'name' => '店滴云CMS',
    'version' => '1.0.1',
    'aliases' => [
        '@bower' => dirname(__DIR__, 2) . '/frontend/resource/lib',
        '@npm' => dirname(__DIR__, 2) . '/frontend/node_modules',
        // '@bower' => '@vendor/bower-asset',
        '@vue' => '@common/widgets/firevue',
        // 本地上传文件处理
        '@Local' => '@common/components/FileUpload/libs/Local',
        // 阿里云对象存储
        '@Alioss' => '@common/components/FileUpload/libs/alioss',
        // 腾讯云对象存储
        '@Qcloud' => '@common/components/FileUpload/libs/Qcloud',
        // 七牛云对象存储
        '@Qiniu' => '@common/components/FileUpload/libs/Qiniu',
        '@TencentYoutuyun' => '@vendor/youtu/TencentYoutuyun',
        '@diandi' => '@vendor/yii-diandi',
        '@addonstpl' => '@console/gii/giitpl',
    ],
    'vendorPath' => dirname(__DIR__, 2) . '/vendor',
    'modules' => [
        'settings' => [
            'class' => 'yii2mod\settings\Module',
        ]
    ],
    'bootstrap' => [
        // 初始化模块依赖的扩展
        'diandi\addons\loader',
        'queue',
    ],
    'components' => [
        'request' => [
            'class' => 'common\components\ExtendedRequest'
        ],
        // 服务定位器
        // 'ServiceLocator'=>'yii\di\ServiceLocator',
        /* ------ 微信业务组件 ------ **/
        'wechat' => [
            'class' => 'common\components\wechat\Wechat',
            'userOptions' => [],  // 用户身份类参数
            'sessionParam' => 'wechatUser', // 微信用户信息将存储在会话在这个密钥
            'returnUrlParam' => '_wechatReturnUrl', // returnUrl 存储在会话中
            'rebinds' => [ // 自定义服务模块
                // 'cache' => 'common\components\Cache',
            ],
        ],
        // 缓存组件
        'cachehelper' => [
            'class' => 'common\helpers\CacheHelper',
        ],
        /* ------ 队列设置 ------ **/
        'queue' => [
            'class' => Queue::class,
            'redis' => 'redis'
        ],
        'settings' => [
            'class' => 'yii2mod\settings\components\Settings',
            'modelClass' => 'common\models\Setting',
        ],
        'helper' => [
            'class' => 'common\components\helpers\helper',
        ],
        'service' => [
            'class' => 'common\services\BaseService',
        ],
        'Aliyunoss' => [
            'class' => 'common\components\oss\Aliyunoss',
        ],
        'i18n' => [
            'translations' => [
                'yii2mod.settings' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
                'yii2-admin' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@diandi/admin/messages',
                ],
                'App' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            //'flushInterval' => 1,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget', //默认文件处理类
                    'levels' => ['error', 'warning', 'info'],
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
    ]
];
