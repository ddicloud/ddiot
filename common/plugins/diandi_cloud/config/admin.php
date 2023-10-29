<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-04-12 14:08:05
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-02-20 10:28:03
 */

return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_cloud/addons-cate'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET index' => 'index', //请求方式 请求方法，映射方法
            'GET list' => 'list', //请求方式 请求方法，映射方法
            'POST create' => 'create',
            'POST,PUT update/<id>' => 'update',
            'POST,GET,DELETE delete/<id>' => 'delete',
            'GET view/<id>' => 'view',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_cloud/addons'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET index' => 'index', //请求方式 请求方法，映射方法
            'GET list' => 'list', //请求方式 请求方法，映射方法
            'POST create' => 'create',
            'POST,PUT update/<id>' => 'update',
            'POST,GET,DELETE delete/<id>' => 'delete',
            'GET view/<id>' => 'view',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_cloud/auth-user'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET index' => 'index', //请求方式 请求方法，映射方法
            'POST create' => 'create',
            'POST,PUT update/<id>' => 'update',
            'POST,GET,DELETE delete/<id>' => 'delete',
            'GET view/<id>' => 'view',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_cloud/auth-domain'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET index' => 'index', //请求方式 请求方法，映射方法
            'POST create' => 'create',
            'POST,PUT update/<id>' => 'update',
            'POST,GET,DELETE delete/<id>' => 'delete',
            'GET view/<id>' => 'view',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_cloud/auth-addons'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET index' => 'index', //请求方式 请求方法，映射方法
            'POST create' => 'create',
            'POST,PUT update/<id>' => 'update',
            'POST,GET,DELETE delete/<id>' => 'delete',
            'GET view/<id>' => 'view',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_cloud/member-expand'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET index' => 'index', //请求方式 请求方法，映射方法
            // 'POST create' => 'create',
            // 'POST,PUT update/<id>' => 'update',
            'GET view/<id>' => 'view',
            'POST audit/<id>' => 'audit',
        ],
    ],
];
