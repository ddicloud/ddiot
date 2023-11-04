<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-04-05 12:09:17
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-06-16 16:50:21
 */

return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_integral/member'],
        'pluralize' => false,
        'extraPatterns' => [
            'GET info' => 'info',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_integral/index'],
        'pluralize' => false,
        'extraPatterns' => [
            'POST index' => 'index',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_integral/store'],
        'pluralize' => false,
        'extraPatterns' => [
            'GET info' => 'info',
            'GET distance' => 'distance',
        ],
    ],
    // 帮助中心
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_integral/help'],
        'pluralize' => false,
        'extraPatterns' => [
            'POST detail' => 'detail',
            'GET lists' => 'lists',
        ],
    ],
    // 订单
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_integral/order'],
        'pluralize' => false,
        'extraPatterns' => [
            'POST  createorder' => 'createorder',
            'POST  list' => 'list',
            'POST  detail' => 'detail',
            'GET   orderdetail' => 'orderdetail',
            'POST  confirm' => 'confirm',
            'POST  creategoodsorder' => 'creategoodsorder',
            'POST  exchange' => 'exchange',
            'GET,POST  exchangelist' => 'exchangelist',
        ],
    ],
    // 商品
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_integral/goods'],
        'pluralize' => false,
        'extraPatterns' => [
            'GET lists' => 'lists',
            'GET search' => 'search',
            'GET detail' => 'detail',
            'GET getslide' => 'getslide',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_integral/category'],
        'pluralize' => false,
        'extraPatterns' => [
            'GET list' => 'list',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_integral/comment'],
        'pluralize' => false,
        'extraPatterns' => [
            'POST comment' => 'comment',
            'GET list' => 'list',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_integral/areas'],
        'pluralize' => false,
        'extraPatterns' => [
            'POST list' => 'list',
        ],
    ],
    // 收货地址start
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_integral/address'],
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
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_integral/cart'],
        'pluralize' => false,
        'extraPatterns' => [
            'POST add' => 'add',
            'POST list' => 'list',
            'POST clear' => 'clear',
            'POST deletecart' => 'deletecart',
        ],
    ],
];
