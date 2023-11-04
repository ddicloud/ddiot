<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-14 10:56:16
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-30 17:53:32
 */
 
 return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_integral/goods/dd-category'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET index' => 'index',
            'POST create' => 'create',
            'POST,PUT update/<id>' => 'update',
            'POST,GET,DELETE delete/<id>' => 'delete',
            'GET view/<id>' => 'view',
            'GET goodslist' => 'goodslist',
            'GET childcate' => 'childcate',
            'GET init' => 'init',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_integral/goods/dd-goods'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET index' => 'index',
            'POST create' => 'create',
            'POST,PUT update/<id>' => 'update',
            'POST,GET,DELETE delete/<id>' => 'delete',
            'GET view/<id>' => 'view',
            'POST specitem' => 'specitem',
            'GET param' => 'param',
            'POST spec' => 'spec',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_integral/order/dd-delivery'], //模块名称/控制器方法
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
        'controller' => ['diandi_integral/order/dd-delivery-rule'], //模块名称/控制器方法
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
        'controller' => ['diandi_integral/order/dd-order'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET index' => 'index',
            'POST create' => 'create',
            'POST,PUT update/<id>' => 'update',
            'POST,GET,DELETE delete/<id>' => 'delete',
            'GET view/<id>' => 'view',
            'POST upaddress' => 'upaddress',
            'POST expresscode' => 'expresscode',
            'GET exportdatalist' => 'exportdatalist',
            'POST confirm' => 'confirm',
            'GET exportdata' => 'exportdata',
            'POST printsip' => 'printsip',
            'POST printcloud' => 'printcloud',
            'POST Prints' => 'Prints',
            'POST deletes' => 'deletes',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_integral/order/integral-company'], //模块名称/控制器方法
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
        'controller' => ['diandi_integral/goods/integral-slide'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET index' => 'index',
            'POST create' => 'create',
            'POST,PUT update/<id>' => 'update',
            'POST,GET,DELETE delete/<id>' => 'delete',
            'GET view/<id>' => 'view',
        ],
    ],
    
 ];
