<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-14 10:56:16
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-30 16:16:20
 */

return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_tea/admin/member'], //模块名称/控制器方法
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
        'controller' => ['diandi_tea/config/hourse'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET index' => 'index',
            'GET view' => 'view',
            'POST create' => 'create',
            'POST,PUT update/<id>' => 'update',
            'POST,GET,DELETE delete/<id>' => 'delete',
            'GET view/<id>' => 'view',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_tea/config/template'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET index' => 'index',
            'GET view' => 'view',
            'POST create' => 'create',
            'POST,PUT update/<id>' => 'update',
            'POST,GET,DELETE delete/<id>' => 'delete',
            'GET view/<id>' => 'view',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_tea/config/meal'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET index' => 'index',
            'GET view' => 'view',
            'POST create' => 'create',
            'POST,PUT update/<id>' => 'update',
            'POST,GET,DELETE delete/<id>' => 'delete',
            'GET view/<id>' => 'view',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_tea/order/meituan'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET index' => 'index',
            'GET view' => 'view',
            'POST create' => 'create',
            'POST,PUT update/<id>' => 'update',
            'POST,GET,DELETE delete/<id>' => 'delete',
            'GET view/<id>' => 'view',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_tea/config/global-config'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET index' => 'index',
            'GET view' => 'view',
            'POST create' => 'create',
            'POST,PUT update/<id>' => 'update',
            'POST,GET,DELETE delete/<id>' => 'delete',
            'GET view/<id>' => 'view',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_tea/config/slide'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET index' => 'index',
            'GET view' => 'view',
            'POST create' => 'create',
            'POST,PUT update/<id>' => 'update',
            'POST,GET,DELETE delete/<id>' => 'delete',
            'GET view/<id>' => 'view',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_tea/marketing/coupon'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET index' => 'index',
            'GET view' => 'view',
            'POST create' => 'create',
            'POST,PUT update/<id>' => 'update',
            'POST,GET,DELETE delete/<id>' => 'delete',
            'GET view/<id>' => 'view',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_tea/marketing/set-meal'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET index' => 'index',
            'GET view' => 'view',
            'POST create' => 'create',
            'POST,PUT update/<id>' => 'update',
            'POST,GET,DELETE delete/<id>' => 'delete',
            'GET view/<id>' => 'view',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_tea/marketing/member-coupon'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET index' => 'index',
            'GET view' => 'view',
            'POST create' => 'create',
            'POST,PUT update/<id>' => 'update',
            'POST,GET,DELETE delete/<id>' => 'delete',
            'GET view/<id>' => 'view',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_tea/order/coupon-list'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET index' => 'index',
            'GET view' => 'view',
            'POST create' => 'create',
            'GET view/<id>' => 'view',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_tea/order/coupon-buy-list'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET index' => 'index',
            'GET view' => 'view',
            'POST create' => 'create',
            'GET view/<id>' => 'view',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_tea/order/order'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET index' => 'index',
            'GET view' => 'view',
            'POST,GET,DELETE delete/<id>' => 'delete',
            'GET view/<id>' => 'view',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_tea/order/recharge-list'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET index' => 'index',
            'GET view' => 'view',
            'POST,GET,DELETE delete/<id>' => 'delete',
            'GET view/<id>' => 'view',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_tea/marketing/recharge'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET index' => 'index',
            'GET view' => 'view',
            'POST create' => 'create',
            'POST,GET,DELETE delete/<id>' => 'delete',
            'GET view/<id>' => 'view',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_tea/order/coupon-buy-list'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET index' => 'index',
            'GET view' => 'view',
            'POST,GET,DELETE delete/<id>' => 'delete',
            'GET view/<id>' => 'view',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_tea/order/coupon-list'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET index' => 'index',
            'GET view' => 'view',
            'POST,GET,DELETE delete/<id>' => 'delete',
            'GET view/<id>' => 'view',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_tea/order/order-list'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET index' => 'index',
            'GET view' => 'view',
            'POST,GET,DELETE delete/<id>' => 'delete',
            'GET view/<id>' => 'view',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_tea/order/set-meal-list'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET index' => 'index',
            'GET view' => 'view',
            'POST,GET,DELETE delete/<id>' => 'delete',
            'GET view/<id>' => 'view',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_tea/order/invoice'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET index' => 'index',
            'GET view' => 'view',
            'POST,PUT update/<id>' => 'update',
            'POST,GET,DELETE delete/<id>' => 'delete',
            'GET view/<id>' => 'view',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_tea/marketing/statistical'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET index' => 'index',
        ],
    ],
];
