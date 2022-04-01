<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-09 22:51:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-30 20:28:47
 */

$db = require(__DIR__ . '/../../common/config/db.php');

$config = [
    'components' => [
        'db' => $db,
         /* ------ 缓存 ------ **/
        'cache' => [
            'class' => 'yii\redis\Cache',
        ],
        /* ------ REDIS ------ **/
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 2,
        ],
    ],
    'language' => 'zh-CN',
];



if (YII_ENV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'controllerNamespace' => 'backend\controllers\gii',
        'viewPath'=>'@backend/views/gii',
        /*自定义*/
        'allowedIPs' => ['127.0.0.1'],
        'generators' => [
            'addons' => [
                'class' => 'addonstpl\addons\Generator',
                'templates' => [
                    'default' => '@frontend/web/backend/giitpl/addons/default',
                ],
            ],
            'adminapi'=>[
                'class' => 'addonstpl\adminapi\Generator',
                'templates' => [
                    'default' => '@frontend/web/backend/giitpl/adminapi/default',
                ],
            ],
            'model' => [
                'class' => 'addonstpl\model\Generator',
                'templates' => [
                    'default' => '@frontend/web/backend/giitpl/model/default'
                ],
            ],
            'crud' => [ //生成器名称
                'class' => 'addonstpl\crud\Generator',
                'templates' => [ //设置我们自己的模板
                    //模板名 => 模板路径
                    'myCrud' => '@frontend/web/backend/giitpl/crud/default'
                ],
            ],
            'module' => [
                'class' => 'addonstpl\module\Generator',
                'templates' => [
                    'addons' => '@frontend/web/backend/giitpl/module/default',
                ],
            ],
            'controller' => [
                'class' => 'addonstpl\controller\Generator',
                'templates' => [
                    'default' => '@frontend/web/backend/giitpl/controller/default',
                ],
            ],
            'form' => [
                'class' => 'addonstpl\form\Generator',
                'templates' => [
                    'default' => '@frontend/web/backend/giitpl/form/default',
                ],
            ],
            'extension' => [
                'class' => 'addonstpl\extension\Generator',
                'templates' => [
                    'default' => '@frontend/web/backend/giitpl/extension/default',
                ],
            ],

        ],
    ];
}


return $config;