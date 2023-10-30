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
        ],
        'diandi_cloud' => [
            'class' => 'common\plugins\diandi_cloud\admin',
        ],
        'diandi_hub' => [
            'class' => 'common\plugins\diandi_hub\admin',
        ]
    ],
    'language' => 'zh-CN',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-admin',
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
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['diandi_hub/messages'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET unread' => 'unread',
                        'GET list' => 'list'
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['diandi_hub/account/agent'],
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
                    'controller' => ['diandi_hub/account/log'],
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
                    'controller' => ['diandi_hub/account/member'],
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
                    'controller' => ['diandi_hub/account/order'],
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
                    'controller' => ['diandi_hub/account/withdrawlog'],
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
                    'controller' => ['diandi_hub/conf/config'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET info' => 'info',
                        'POST,PUT form' => 'form',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['diandi_hub/conf/priceConf'],
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
                    'controller' => ['diandi_hub/conf/slide'],
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
                    'controller' => ['diandi_hub/express/area'],
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
                    'controller' => ['diandi_hub/express/express'],
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
                    'controller' => ['diandi_hub/express/template'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET index' => 'index',
                        'POST create' => 'create',
                        'GET init' => 'init',
                        'GET citylist' => 'citylist',
                        'POST,PUT update/<id>' => 'update',
                        'POST,GET,DELETE delete/<id>' => 'delete',
                        'GET view/<id>' => 'view',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['diandi_hub/goods/dd-category'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET index' => 'index',
                        'POST create' => 'create',
                        'GET init' => 'init',
                        'POST,PUT update/<id>' => 'update',
                        'POST,GET,DELETE delete/<id>' => 'delete',
                        'GET view/<id>' => 'view',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['diandi_hub/goods/dd-goods'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET index' => 'index',
                        'POST create' => 'create',
                        'POST,PUT update/<id>' => 'update',
                        'POST,GET,DELETE delete/<id>' => 'delete',
                        'GET view/<id>' => 'view',
                        'POST getspec' => 'get-spec',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['diandi_hub/goods/gift'],
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
                    'controller' => ['diandi_hub/goods/goods'],
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
                    'controller' => ['diandi_hub/goods/label'],
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
                    'controller' => ['diandi_hub/goods/location'],
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
                    'controller' => ['diandi_hub/goods/location-goods'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET index' => 'index',
                        'POST create' => 'create',
                        'POST,PUT update/<id>' => 'update',
                        'POST,GET,DELETE delete/<id>' => 'delete',
                        'GET view/<id>' => 'view',
                        'POST,GET advlist' => 'advlist',
                        'POST,GET goodslist' => 'goodslist',
                        'POST,GET goodslocation' => 'goodslocation',
                        'POST deletegoods' => 'deletegoods',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['diandi_hub/goods/share'],
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
                    'controller' => ['diandi_hub/level/level'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET index' => 'index',
                        'POST createinit' => 'create-init',
                        'POST create' => 'create',
                        'POST,PUT update/<id>' => 'update',
                        'POST,GET,DELETE delete/<id>' => 'delete',
                        'GET view/<id>' => 'view',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['diandi_hub/level/price-conf'],
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
                    'controller' => ['diandi_hub/member/bank'],
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
                    'controller' => ['diandi_hub/member/baseconf'],
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
                    'controller' => ['diandi_hub/member/condition'],
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
                    'controller' => ['diandi_hub/member/rarningsconf'],
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
                    'controller' => ['diandi_hub/member/memberlevel'],
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
                    'controller' => ['diandi_hub/order/dd-delivery'],
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
                    'controller' => ['diandi_hub/order/dd-delivery-rule'],
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
                    'controller' => ['diandi_hub/order/dd-order'],
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
                    'controller' => ['diandi_hub/order/reason'],
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
                    'controller' => ['diandi_hub/order/refund'],
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
                    'controller' => ['diandi_hub/order/refundlog'],
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
                    'controller' => ['diandi_hub/setting/ad'],
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
                    'controller' => ['diandi_hub/setting/area'],
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
                    'controller' => ['diandi_hub/setting/comment'],
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
                    'controller' => ['diandi_hub/setting/menu'],
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
                    'controller' => ['diandi_hub/setting/store'],
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
                    'controller' => ['diandi_hub/statistics/agent'],
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
                    'controller' => ['diandi_hub/statistics/goods'],
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
                    'controller' => ['diandi_hub/statistics/money'],
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
                    'controller' => ['diandi_hub/statistics/order'],
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
                    'controller' => ['diandi_hub/statistics/team'],
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
                    'controller' => ['diandi_hub/store/paylist'],
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
                    'controller' => ['diandi_hub/store/store'],
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
                    'controller' => ['diandi_hub/store/storepay'],
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
                    'controller' => ['diandi_hub/store/user'],
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
                    'controller' => ['diandi_hub/spec/spec'],
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
                    'controller' => ['diandi_hub/spec/spec-value'],
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
                    'controller' => ['diandi_hub/tickets'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET index' => 'index',
                        'PUT status/<id>' => 'status',
                        // 'POST,GET,DELETE delete/<id>' => 'delete',
                        'GET view/<id>' => 'view',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['diandi_hub/tickets-record'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET index' => 'index',
                        'POST send' => 'send',
                    ],
                ],
                /*
                前台接口移植 - 开始 ------------------------------------------------------------------------------
                 */

                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['diandi_hub/api/api'], //模块名称/控制器方法
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET common-json-base' => 'common-json-base', //请求方式 请求方法，映射方法
                        'GET json-base' => 'json-base', //请求方式 请求方法，映射方法
                        'GET admin-base' => 'admin-base', //请求方式 请求方法，映射方法
                        'GET docs-type' => 'docs-type', //请求方式 请求方法，映射方法
                        'GET test' => 'test', //请求方式 请求方法，映射方法
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['diandi_hub/api/ceshi'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET dongjie' => 'dongjie',
                        'GET sms' => 'sms',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['diandi_hub/api/index'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET slides' => 'slides',
                        'GET goodsadv' => 'goodsadv',
                        'GET pageadv' => 'pageadv',
                        'GET menu' => 'menu',
                    ],
                ],
                // 帮助中心
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['diandi_hub/api/help'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST detail' => 'detail',
                        'GET lists' => 'lists',
                    ],
                ],
                // 订单
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['diandi_hub/api/order'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST  createorder' => 'createorder',
                        'POST  list' => 'list',
                        'POST  detail' => 'detail',
                        'POST  confirm' => 'confirm',
                        'POST  creategoodsorder' => 'creategoodsorder',
                        'GET orderdetail' => 'orderdetail',
                        'GET getexpress' => 'getexpress',
                        'GET,POST,PUT,OPTIONS kdinform' => 'Kdinform',
                        'POST  integralpay' => 'integralpay',
                        'POST,GET  deletebytime' => 'deletebytime',
                        'POST  pay' => 'pay',
                    ],
                ],
                // 商品
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['diandi_hub/api/goods'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET lists' => 'lists',
                        'GET detail' => 'detail',
                        'GET goodgift' => 'goodgift',
                        'GET search' => 'search',
                        'GET orderdetail' => 'orderdetail',
                        'POST painter' => 'painter',
                        'POST collect' => 'collect',
                    ],
                ],
                // 购物车
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['diandi_hub/api/cart'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST add' => 'add',
                        'POST list' => 'list',
                        'POST clear' => 'clear',
                        'POST deletecart' => 'deletecart',
                    ],
                ],
                // 分类
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['diandi_hub/api/category'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET list' => 'list',
                    ],
                ],
                // 收货地址start
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['diandi_hub/api/address'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST getdefault' => 'getdefault',
                        'POST setdefault' => 'setdefault',
                        'POST lists' => 'lists',
                        'POST deletes' => 'deletes',
                        'POST detail' => 'detail',
                        'POST edit' => 'edit',
                        'POST add' => 'add',
                    ],
                ],
                // 评论
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['diandi_hub/api/comment'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST comment' => 'comment',
                        'GET list' => 'list',
                    ],
                ],
                // 区域
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['diandi_hub/api/areas'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST list' => 'list',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['diandi_hub/api/member'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET info' => 'info',
                        'GET   myagent' => 'myagent',
                        'POST   qrcode' => 'qrcode',
                        'POST   addpayset' => 'addpayset',
                        'POST   collect' => 'collect',
                        'GET   getpayset' => 'getpayset',
                        'POST   editbankapply' => 'editbankapply',
                        'GET   withdrawlist' => 'withdrawlist',
                        'POST   wechat-qrcode' => 'wechat-qrcode',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['diandi_hub/api/level'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST link' => 'link',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['diandi_hub/api/account'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET  log' => 'log',
                        'POST order' => 'order',
                        'POST addlog' => 'addlog',
                        'POST withdraw' => 'withdraw',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['diandi_hub/api/store'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST add' => 'add',
                        'POST addpay' => 'addpay',
                        'GET paylist' => 'paylist',
                        'POST memberpaylist' => 'memberpaylist',
                        'GET express' => 'express',
                        'POST paydetail' => 'paydetail',
                        'GET mystore' => 'mystore',
                        'GET conf' => 'conf',
                        'POST list' => 'list',
                        'POST creditpay' => 'creditpay',
                        'POST confirmonline' => 'confirmonline',
                    ],
                ],
                // 售后
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['diandi_hub/api/refund'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST add' => 'add',
                        'POST  list' => 'list',
                        'GET info' => 'info',
                        'POST  detail' => 'detail',
                        'POST  cancel' => 'cancel',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['diandi_hub/api/express'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'POST list' => 'list',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['diandi_hub/api/tickets'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET lists' => 'lists',
                        'POST create' => 'create',
                        'POST,PUT update/<id>' => 'update',
                        'PUT status/<id>' => 'status',
                        'POST,GET,DELETE delete/<id>' => 'delete',
                        'GET view/<id>' => 'view',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['diandi_hub/api/tickets-record'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'GET lists' => 'lists',
                        'POST create' => 'create',
                    ],
                ],
            ],
        ],
    ],
    'params' => $params,
];
