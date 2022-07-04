<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-05 08:27:35
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-07-04 11:32:01
 */
$params = array_merge(
    require __DIR__.'/../../common/config/params.php',
    require __DIR__.'/../../common/config/params-local.php',
    require __DIR__.'/params.php',
    require __DIR__.'/params-local.php'
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        //全局内容协商
        [
            //ContentNegotiator 类可以分析request的header然后指派所需的响应格式给客户端，不需要我们人工指定
            'class' => 'yii\filters\ContentNegotiator',
            'formats' => [
                'application/json' => yii\web\Response::FORMAT_JSON,
                'application/xml' => yii\web\Response::FORMAT_XML,
                //api 端目前只需要json 和 xml
                //还可以增加 yii\web\Response 类内置的响应格式，或者自己增加响应格式
            ],
        ],
    ],
    'controllerNamespace' => 'api\controllers',
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
            'class' => 'api\modules\wechat\module',
        ],
        // 公众号
        'officialaccount' => [
            'class' => 'api\modules\officialaccount\module',
        ],
    ],
    'as behaviors' => 'common\behaviors\ServiceBehavior',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-api',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'text/json' => 'yii\web\JsonParser',
            ],
        ],
        'user' => [
            'identityClass' => 'api\models\DdApiAccessToken',
            'enableAutoLogin' => true,
            'enableSession' => true,
            'loginUrl' => null,
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-api',
        ],
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
        'response' => [
            'class' => 'yii\web\Response',
            //设置 api 返回格式,错误码不在 header 里实现，而是放到 body里
            //            'as resBeforeSend' => [
            //                'class'         => 'api\extensions\ResBeforeSendBehavior',
            //                'defaultCode'   => 500,
            //                'defaultMsg'    => 'error',
            //            ],
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                // $response->data = [
                //     'success' => $response->isSuccessful,
                //     'code' => $response->getStatusCode(),
                //     'message' => $response->statusText,
                //     'data' => $response->data,
                // ];
                $response->statusCode = 200;
            },
            //ps：components 中绑定事件，可以用两种方法
            //'on eventName' => $eventHandler,
            //'as behaviorName' => $behaviorConfig,
            //参考 http://www.yiiframework.com/doc-2.0/guide-concept-configurations.html#configuration-format
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        //        'errorHandler' => [
        //            'errorAction' => 'site/error',
        //        ],
        'urlManager' => [
            //用于表明 urlManager 是否启用 URL 美化功能
            //默认不启用。但实际使用中，特别是产品环境，一般都会启用
            'enablePrettyUrl' => true,
            //是否启用严格解析，如启用严格解析，要求当前请求应至少匹配1个路由规则，否则认为是无效路由。
            //这个选项仅在 enablePrettyUrl 启用后才有效。
            //如果开启，表示只有配置在 rules 里的规则才有效
            //由于项目会将一些 url 进行优化，所以这里需要设置为 true
            'enableStrictParsing' => true,
            //指定是否在URL在保留入口脚本 index.php
            'showScriptName' => false,
            'rules' => [
                //当然，如果自带的路由无法满足需求，可以自己增加规则
                'GET <module:(v)\d+>/<controller:\w+>/search' => '<module>/<controller>/search',
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/goods'],
                    // 由于 resetful 风格规定 URL 保持格式一致并且始终使用复数形式
                    // 所以如果你的 controller 是单数的名称比如 UserController
                    // 设置 pluralize 为 true （默认为 true）的话，url 地址必须是 users 才可访问
                    // 如果 pluralize 设置为 false, url 地址必须是 user 也可访问
                    // 如果你的 controller 本身是复数名称 UsersController ，此参数没用，url 地址必须是 users
                    'pluralize' => false,
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['dingzuo'],
                    // 由于 resetful 风格规定 URL 保持格式一致并且始终使用复数形式
                    // 所以如果你的 controller 是单数的名称比如 UserController
                    // 设置 pluralize 为 true （默认为 true）的话，url 地址必须是 users 才可访问
                    // 如果 pluralize 设置为 false, url 地址必须是 user 也可访问
                    // 如果你的 controller 本身是复数名称 UsersController ，此参数没用，url 地址必须是 users
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET,OPTIONS index' => 'index',
                    ],
                ],
                // 文档
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['doc'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET index' => 'index',
                        'GET admin' => 'admin',
                        'GET json-officialaccount' => 'json-officialaccount',
                        'GET json-wechat' => 'json-wechat',
                        'GET json-inits' => 'json-inits'
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['ceshi'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET,OPTIONS swgdoc' => 'swgdoc',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['map'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET,OPTIONS distance' => 'distance',
                        'GET,OPTIONS citylist' => 'citylist',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['user'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST,OPTIONS   login' => 'login',
                        'POST,OPTIONS   signup' => 'signup',
                        'POST,OPTIONS   repassword' => 'repassword',
                        'POST,OPTIONS   up-repassword' => 'up-repassword',
                        'POST,OPTIONS   userinfo' => 'userinfo',
                        'POST,OPTIONS   edituserinfo' => 'edituserinfo',
                        'POST,OPTIONS   sendcode' => 'sendcode',
                        'POST,OPTIONS   forgetpass' => 'forgetpass',
                        'POST,OPTIONS   feedback' => 'feedback',
                        'POST,OPTIONS   bindmobile' => 'bindmobile',
                        'POST,OPTIONS   refresh' => 'refresh',
                        'GET,OPTIONS   smsconf' => 'smsconf',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['addons'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET,OPTIONS index' => 'index',
                        'POST,OPTIONS   diandishop' => 'diandi-shop',
                    ],
                ],
                // 基础接口
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['upload'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST,OPTIONS   images' => 'images',
                        'POST  baseimg' => 'baseimg',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['store'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET,OPTIONS info' => 'info',
                        'GET,OPTIONS cate' => 'cate',
                        'GET,OPTIONS list' => 'list',
                        'POST,OPTIONS detailinfo' => 'detailinfo',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['address'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST,OPTIONS  lists' => 'lists',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['doc'],
                    'pluralize' => false,
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/user'],
                    'pluralize' => false,
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/category'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST,OPTIONS  list' => 'list',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/ceshi'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET,OPTIONS ccc' => 'ccc',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/goods'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST,OPTIONS  ccc' => 'ccc',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['v1/index'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST,OPTIONS  ccc' => 'ccc',
                    ],
                ],
                // 小程序接口
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['wechat/basics'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST,HEAD,OPTIONS signup' => 'signup',
                        'POST,HEAD,OPTIONS payparameters' => 'payparameters',
                        'POST,HEAD,GET,OPTIONS,PUT refundednotify' => 'refundednotify',
                        'POST,HEAD,GET,OPTIONS,PUT notify' => 'notify',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['wechat/sendmsg'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST,HEAD,OPTIONS send' => 'send',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['wechat/qrcode'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST,OPTIONS  getqrcode' => 'getqrcode',
                    ],
                ],
                // 公众号接口
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['officialaccount/basics'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST,HEAD,OPTIONS signup' => 'signup',
                        'GET,POST,HEAD,OPTIONS auth' => 'auth',
                        'GET,POST,HEAD,OPTIONS userinfo' => 'userinfo',
                        'POST,HEAD,OPTIONS payparameters' => 'payparameters',
                        'POST,HEAD,OPTIONS payappparameters' => 'payappparameters',
                        'POST,HEAD,GET,OPTIONS,PUT notify' => 'notify',
                    ],
                ],
                // 激活公众号开发模式
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['officialaccount/msg'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET,OPTIONS,POST index' => 'index',
                        'GET,OPTIONS,POST event' => 'event',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['officialaccount/jssdk'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST,OPTIONS  config' => 'config',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['officialaccount/qrcode'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST,GET,OPTIONS getqrcode' => 'qrcode',
                    ],
                ],
            ],
        ],
    ],
    'params' => $params,
];
