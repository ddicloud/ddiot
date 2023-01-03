<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-15 15:28:04
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-12-21 11:44:04
 */
$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'a2JT39LPV_JRdgCv4HchqUzCgefuAQUT',
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // 'controllerNamespace' => 'backend\controllers\gii',
        'viewPath' => '@admin/views/gii',
        /*自定义*/
        'allowedIPs' => ['127.0.0.1'],
        'generators' => [
            'addons' => [
                'class' => 'addonstpl\addons\Generator',
                'templates' => [
                    'default' => '@addonstpl/addons/default',
                ],
            ],
            'adminapi' => [
                'class' => 'addonstpl\adminapi\Generator',
                'templates' => [
                    'default' => '@addonstpl/adminapi/default',
                ],
            ],
            'model' => [
                'class' => 'addonstpl\model\Generator',
                'templates' => [
                    'default' => '@addonstpl/model/default',
                ],
            ],
            'crud' => [ //生成器名称
                'class' => 'addonstpl\crud\Generator',
                'templates' => [ //设置我们自己的模板
                    //模板名 => 模板路径
                    'myCrud' => '@addonstpl/crud/default',
                ],
            ],
            'module' => [
                'class' => 'addonstpl\module\Generator',
                'templates' => [
                    'addons' => '@addonstpl/module/default',
                ],
            ],
            'controller' => [
                'class' => 'addonstpl\controller\Generator',
                'templates' => [
                    'default' => '@addonstpl/controller/default',
                ],
            ],
            'form' => [
                'class' => 'addonstpl\form\Generator',
                'templates' => [
                    'default' => '@addonstpl/form/default',
                ],
            ],
            'extension' => [
                'class' => 'addonstpl\extension\Generator',
                'templates' => [
                    'default' => '@addonstpl/extension/default',
                ],
            ],
        ],
    ];
}

return $config;
