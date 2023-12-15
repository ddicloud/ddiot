<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-04-27 03:17:29
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-07-18 15:58:01
 */
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-admin',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        // 初始化模块依赖的扩展
        'diandi\addons\loader',
        'queue',
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
    'controllerNamespace' => 'admin\controllers',
    'modules' => [
        'settings' => [
            'class' => 'yii2mod\settings\Module',
        ]
    ],
    'language' => 'zh-CN',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-admin',
            'cookieValidationKey' => 'a2JT39LPV_JRdgCv4HchqUzCgefuAQUT',
        ],
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'admin\models\DdApiAccessToken',
            'enableAutoLogin' => true,
            'enableSession' => true,
            'loginUrl' => null,
            'identityCookie' => ['name' => '_identity-admin', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-admin',
            'class' => 'yii\redis\Session',
            'keyPrefix' => 'session.',
            'redis' => 'redis',
        ],
        /* ------ 微信业务组件 ------ **/
        'wechat' => [
            'class' => 'common\components\wechat\Wechat',
            'userOptions' => [], // 用户身份类参数
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
        'authManager' => [
            'class' => 'diandi\admin\components\DbManager', // 使用数据库管理配置文件
            'defaultRoles' => ['基础权限组'], //默认角色，该角色有最高权限
        ],
        'i18n' => [
            'translations' => [
                'yii' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
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
                'admin' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@admin/messages',
                ],
            ],
        ],
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
                    'controller' => ['user'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST,GET       info' => 'info',
                        'POST,OPTIONS   login' => 'login',
                        'POST,OPTIONS   signup' => 'signup',
                        'POST,OPTIONS   repassword' => 'repassword',
                        'POST,GET       userinfo' => 'userinfo',
                        'POST,OPTIONS   edituserinfo' => 'edituserinfo',
                        'POST,OPTIONS   sendcode' => 'sendcode',
                        'POST,OPTIONS   forgetpass' => 'forgetpass',
                        'POST,OPTIONS   feedback' => 'feedback',
                        'POST,OPTIONS   bindmobile' => 'bindmobile',
                        'POST,OPTIONS   refresh' => 'refresh',
                        'POST   addons' => 'addons',
                        'GET   userlist' => 'userlist',
                        'DELETE   delete/<id>' => 'delete',
                        'POST   activate/<id>' => 'activate',
                        'POST   upstatus' => 'upstatus',
                        'POST create' => 'create',
                        'POST update' => 'update',
                        'POST setinfo' => 'setinfo',
                        'POST default' => 'default',
                        'POST config' => 'config',
                        'POST log' => 'log',
                        'POST defaultinfo' => 'default-info',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['wechat'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST signup' => 'signup',
                        'POST authurl' => 'auth-url',
                        'POST bind' => 'bind',
                        'POST unbind' => 'unbind',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['enums'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET storesbloc' => 'storesbloc',
                        'GET blocs' => 'blocs',
                        'GET stores' => 'stores'
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['auth/assignment'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET view/<id>' => 'view',
                        'POST assign/<id>' => 'assign',
                        'POST revoke/<id>' => 'revoke',
                        'POST change' => 'change',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['auth/admin-user'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST,GET index' => 'index',
                        'POST create' => 'create',
                        'POST update' => 'update',
                        'GET view/<id>' => 'view',
                        'POST assign/<id>' => 'assign',
                        'POST remove/<id>' => 'remove',
                        'POST change' => 'change',
                    ],
                ],
                // 地图
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['map'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET citylist' => 'citylist',
                    ],
                ],
                // admin-api
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['site'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST signup' => 'signup',
                        'POST ceshi' => 'ceshi',
                        'POST logout' => 'logout',
                        'POST xiufu' => 'xiufu',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['store'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST,GET,OPTIONS index' => 'index',
                        'POST list' => 'list',
                        'POST blocs' => 'blocs',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['article/dd-article'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST,GET,OPTIONS index' => 'index',
                        'POST ceshi' => 'ceshi',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['messages/messages-category'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET index' => 'index',
                        'POST create' => 'create',
                        'POST,PUT update/<id>' => 'update',
                        'POST,GET,DELETE delete/<id>' => 'delete',
                        'GET view/<id>' => 'view',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['messages/messages'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET index' => 'index',
                        'GET list' => 'list',
                        'POST create' => 'create',
                        'POST,PUT update/<id>' => 'update',
                        'POST,GET,DELETE delete/<id>' => 'delete',
                        'GET view/<id>' => 'view',
                        'GET user-view/<id>' => 'user-view',
                        'GET unread' => 'unread',
                        'GET read/<id>' => 'read',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['system/index'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST,GET index' => 'index',
                        'POST ceshi' => 'ceshi',
                        'POST,GET menus' => 'menus',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['system/settings'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST set-cache' => 'set-cache',
                        'POST clear-cache' => 'clear-cache',
                        'GET,POST ueditor' => 'ueditor',
                        'GET store' => 'store',
                        'POST conf' => 'conf',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['system/config'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST,GET weburl' => 'weburl',
                        'POST,GET baidu' => 'baidu',
                        'POST,GET wechatpay' => 'wechatpay',
                        'POST,GET sms' => 'sms',
                        'POST,GET email' => 'email',
                        'POST,GET wxapp' => 'wxapp',
                        'POST,GET wechat' => 'wechat',
                        'POST,GET microapp' => 'microapp',
                        'POST,GET app' => 'app',
                        'POST,GET map' => 'map',
                        'POST,GET oss' => 'oss',
                        'POST,GET api' => 'api',
                    ],
                ],
                // 扩展模块
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['addons/addons'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST,GET list' => 'list',
                        'POST child' => 'child',
                        'POST,GET info' => 'info',
                        'POST create' => 'create',
                        'POST update' => 'update',
                        'POST auth' => 'auth',
                        'POST uninstalled' => 'uninstalled',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['addons/manage'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST install' => 'install',
                        'POST uninstall' => 'uninstall',
                        'POST auth' => 'auth',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['website/dd-website-slide'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST,GET index' => 'index',
                        'POST create' => 'create',
                        'POST update' => 'update',
                        'POST updateitem' => 'updateitem',
                        'POST deleteitem' => 'deleteitem',
                    ],
                ],
                // 站点设置
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['website/setting'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET info' => 'info',
                        'POST config' => 'config',
                    ],
                ],
                // 上传
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['file/upload'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST,PUT images' => 'images',
                        'POST,PUT file' => 'file',
                        'POST,PUT merge' => 'merge',
                    ],
                ],
                // 权限
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['auth/permission'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET index' => 'index',
                        'GET rule' => 'rule',
                        'GET levels' => 'levels',
                        'GET addons' => 'addons',
                        'POST create' => 'create',
                        'POST update' => 'update',
                        'GET  route' => 'route',
                        'POST updateitem' => 'updateitem',
                        'POST,GET,DELETE delete/<id>' => 'delete',
                        'GET view/<id>' => 'view',
                        'POST assign/<id>' => 'assign',
                        'POST remove/<id>' => 'remove',
                        'POST change' => 'change',
                    ],
                ],
                // 路由
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['auth/route'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET index' => 'index',
                        'GET rule' => 'rule',
                        'GET levels' => 'levels',
                        'GET addons' => 'addons',
                        'POST create' => 'create',
                        'POST,PUT update/<id>' => 'update',
                        'POST,GET,DELETE delete/<id>' => 'delete',
                        'GET view/<id>' => 'view',
                        'POST assign' => 'assign',
                        'POST remove' => 'remove',
                        'POST refresh' => 'refresh',
                    ],
                ],
                // 左侧菜单
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['auth/menu'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET index' => 'index',
                        'GET rule' => 'rule',
                        'GET levels' => 'levels',
                        'GET addons' => 'addons',
                        'POST create' => 'create',
                        'POST  route' => 'route',
                        'POST,PUT update/<id>' => 'update',
                        'POST,GET,DELETE,OPTIONS,PUT delete/<id>' => 'delete',
                        'GET view/<id>' => 'view',
                    ],
                ],
                // 顶部菜单
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['auth/menutop'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET index' => 'index',
                        'POST create' => 'create',
                        'POST,PUT update/<id>' => 'update',
                        'POST,GET,DELETE delete/<id>' => 'delete',
                        'GET view/<id>' => 'view',
                    ],
                ],
                // 角色
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['auth/group'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET index' => 'index',
                        'GET rule' => 'rule',
                        'GET levels' => 'levels',
                        'GET addons' => 'addons',
                        'POST create' => 'create',
                        'POST  route' => 'route',
                        'POST,PUT update/<id>' => 'update',
                        'POST,GET,DELETE delete/<id>' => 'delete',
                        'GET view/<id>' => 'view',
                        'POST assign/<id>' => 'assign',
                        'POST remove/<id>' => 'remove',
                        'POST change' => 'change',
                    ],
                ],
                // 集团
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['addons/bloc'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET index' => 'index',
                        'POST create' => 'create',
                        'POST  route' => 'route',
                        'GET  storeGroup' => 'storeGroup',
                        'POST,PUT update/<id>' => 'update',
                        'POST,GET,DELETE delete/<id>' => 'delete',
                        'GET view/<id>' => 'view',
                        'GET stores' => 'stores',
                        'GET storelist' => 'store-list',
                        'GET levels' => 'levels',
                        'GET blocstatus' => 'blocstatus',
                        'GET parentbloc' => 'parentbloc',
                        'POST childbloc' => 'childbloc',
                        'GET reglevel' => 'reglevel',
                        'GET bloc-store' => 'bloc-store',
                        'POST assign/<id>' => 'assign',
                        'POST remove/<id>' => 'remove',
                    ],
                ],
                // 公司等级
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['addons/bloclevel'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET index' => 'index',
                        'POST create' => 'create',
                        'POST  route' => 'route',
                        'POST,PUT update/<id>' => 'update',
                        'POST,GET,DELETE delete/<id>' => 'delete',
                        'GET view/<id>' => 'view',
                        'GET stores' => 'stores',
                        'GET levels' => 'levels',
                        'GET blocstatus' => 'blocstatus',
                        'GET parentbloc' => 'parentbloc',
                        'GET reglevel' => 'reglevel',
                        'POST assign/<id>' => 'assign',
                        'POST remove/<id>' => 'remove',
                    ],
                ],
                // 商户
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['addons/store'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET index' => 'index',
                        'GET category' => 'category',
                        'GET storestatus' => 'storestatus',
                        'GET storelabel' => 'storelabel',
                        'GET blocs' => 'blocs',
                        'POST create' => 'create',
                        'POST  route' => 'route',
                        'POST,PUT update/<id>' => 'update',
                        'POST,GET,DELETE delete/<id>' => 'delete',
                        'GET view/<id>' => 'view',
                        'POST store-create' => 'store-create',
                    ],
                ],
                // 商户标签
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['addons/storelabel'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET index' => 'index',
                        'GET category' => 'category',
                        'POST create' => 'create',
                        'POST,PUT update/<id>' => 'update',
                        'POST,GET,DELETE delete/<id>' => 'delete',
                        'GET view/<id>' => 'view',
                    ],
                ],
                // 商户分类
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['addons/category'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET index' => 'index',
                        'GET category' => 'category',
                        'POST create' => 'create',
                        'POST,PUT update/<id>' => 'update',
                        'POST,GET,DELETE delete/<id>' => 'delete',
                        'GET view/<id>' => 'view',
                    ],
                ],
                // 会员组织架构
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['member/organization'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET index' => 'index',
                        'POST create' => 'create',
                        'POST,PUT update/<id>' => 'update',
                        'POST,GET,DELETE delete/<id>' => 'delete',
                        'GET view/<id>' => 'view',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['member/dd-member-group'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET index' => 'index',
                        'POST create' => 'create',
                        'POST,PUT update/<id>' => 'update',
                        'POST,GET,DELETE delete/<id>' => 'delete',
                        'GET view/<id>' => 'view',
                    ],
                ],
                // 会员管理
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['member/dd-member'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET index' => 'index',
                        'POST create' => 'create',
                        'POST,PUT update/<id>' => 'update',
                        'POST,GET,DELETE delete/<id>' => 'delete',
                        'GET view/<id>' => 'view',
                    ],
                ],
                // 公众号接口
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['officialaccount/basics'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST,HEAD signup' => 'signup',
                        'GET,POST,HEAD auth' => 'auth',
                        'GET,POST,HEAD userinfo' => 'userinfo',
                        'POST,HEAD payparameters' => 'payparameters',
                        'POST,HEAD payappparameters' => 'payappparameters',
                        'POST,HEAD,GET,PUT notify' => 'notify',
                    ],
                ],
                // 激活公众号开发模式
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['officialaccount/msg'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET,POST index' => 'index',
                        'GET,POST event' => 'event',
                        'GET,POST open' => 'open',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['officialaccount/jssdk'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST  config' => 'config',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['officialaccount/qrcode'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST,GET getqrcode' => 'qrcode',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['officialaccount/receive'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET list' => 'list',
                        'POST add' => 'create',
                        'POST update/<id>' => 'update',
                        'POST delete/<id>' => 'delete',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['officialaccount/subscribe'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET list' => 'list',
                        'POST add' => 'create',
                        'POST update/<id>' => 'update',
                        'POST delete/<id>' => 'delete',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['officialaccount/fans'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET list' => 'list',
                        'POST add' => 'create',
                        'POST syncAccountFans' => 'syncAccountFans',
                        'POST sendMsg' => 'sendMsg',
                        'POST update/<id>' => 'update',
                        'POST delete/<id>' => 'delete',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['officialaccount/account'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET list' => 'list',
                        'POST add' => 'create',
                        'POST listAll' => 'listAll',
                        'POST generateQRUrl' => 'generateQRUrl',
                        'POST listTreeWxAccount' => 'listTreeWxAccount',
                        'POST update/<id>' => 'update',
                        'POST delete/<id>' => 'delete',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['officialaccount/msg'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET list' => 'list',
                        'POST add' => 'create',
                        'POST updateResContent' => 'updateResContent',
                        'POST update/<id>' => 'update',
                        'POST delete/<id>' => 'delete',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['officialaccount/menu'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET list' => 'list',
                        'POST add' => 'create',
                        'POST listTreeMenu' => 'listTreeMenu',
                        'POST validateData' => 'validateData',
                        'POST syncAccountMenu' => 'syncAccountMenu',
                        'POST update/<id>' => 'update',
                        'POST delete/<id>' => 'delete',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['officialaccount/news'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET list' => 'list',
                        'POST add' => 'create',
                        'POST addNews' => 'addNews',
                        'POST getNews' => 'getNews',
                        'POST uploadNews' => 'uploadNews',
                        'POST listAll' => 'listAll',
                        'POST listAll2' => 'listAll2',
                        'POST filterFans' => 'filterFans',
                        'POST sendNewsPreview' => 'sendNewsPreview',
                        'POST update/<id>' => 'update',
                        'POST delete/<id>' => 'delete',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['officialaccount/text'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET list' => 'list',
                        'POST add' => 'create',
                        'POST listAll' => 'listAll',
                        'POST update/<id>' => 'update',
                        'POST delete/<id>' => 'delete',
                    ],
                ],
            ],
        ],
    ],
    'params' => $params,
];
