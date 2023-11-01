<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-09-16 14:45:22
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-07-12 11:35:03
 */

return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_website/api'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET json-base' => 'json-base', //请求方式 请求方法，映射方法
            'GET admin-base' => 'admin-base', //请求方式 请求方法，映射方法
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_website/sys'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET nav' => 'nav',
            'GET slide' => 'slide',
            'GET base' => 'base',
            'GET page' => 'page',
            'GET link' => 'link',
            'GET ad' => 'ad',
            'GET fun' => 'fun',
            'GET worth' => 'worth',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_website/article'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET cate' => 'cate',
            'GET list' => 'list',
            'GET detail' => 'detail',
            'GET pagelist' => 'page-list',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_website/product'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET slide' => 'slide',
            'GET version' => 'version',
            'GET plug' => 'plug',
            'GET customer-list' => 'customer-list',
            'GET customer-view/<id>' => 'customer-view',
            'GET selling-list' => 'selling-list',
            'GET selling-view/<id>' => 'selling-view',
            'GET core-list' => 'core-list',
            'GET core-view/<id>' => 'core-view',
            'GET App-list' => 'App-list',
            'GET App-view/<id>' => 'App-view',
            'GET config' => 'config',
            'GET price' => 'price',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_website/product-h'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET body-list' => 'h5-body-list',
            'GET body-view/<id>' => 'h5-body-view',
            'GET top-list' => 'h5-top-list',
            'GET top-view/<id>' => 'h5-top-view',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_website/solution'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'POST cate-list' => 'cate-list',
            'POST list' => 'list',
            'GET bac-exhibit' => 'bac-exhibit',
        ],
    ],
];
