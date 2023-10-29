<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-04-05 12:09:17
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-09-22 15:50:28
 */

return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_hub/api'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET common-json-base' => 'common-json-base', //请求方式 请求方法，映射方法
            'GET json-base' => 'json-base', //请求方式 请求方法，映射方法
            'GET admin-base' => 'admin-base', //请求方式 请求方法，映射方法
            'GET docs-type' => 'docs-type', //请求方式 请求方法，映射方法
            'GET test' => 'test', //请求方式 请求方法，映射方法
        ],
    ],
    // [
    //     'class' => 'yii\rest\UrlRule',
    //     'controller' => ['diandi_hub/ceshi'],
    //     'pluralize' => false,
    //     'extraPatterns' => [
    //         'GET dongjie' => 'dongjie',
    //         'GET sms' => 'sms',
    //     ],
    // ],
    // [
    //     'class' => 'yii\rest\UrlRule',
    //     'controller' => ['diandi_hub/index'],
    //     'pluralize' => false,
    //     'extraPatterns' => [
    //         'GET slides' => 'slides',
    //         'GET goodsadv' => 'goodsadv',
    //         'GET pageadv' => 'pageadv',
    //         'GET menu' => 'menu',
    //     ],
    // ],
    // // 帮助中心
    // [
    //     'class' => 'yii\rest\UrlRule',
    //     'controller' => ['diandi_hub/help'],
    //     'pluralize' => false,
    //     'extraPatterns' => [
    //         'POST detail' => 'detail',
    //         'GET lists' => 'lists',
    //     ],
    // ],
    // // 订单
    // [
    //     'class' => 'yii\rest\UrlRule',
    //     'controller' => ['diandi_hub/order'],
    //     'pluralize' => false,
    //     'extraPatterns' => [
    //         'POST  createorder' => 'createorder',
    //         'POST  list' => 'list',
    //         'POST  detail' => 'detail',
    //         'POST  confirm' => 'confirm',
    //         'POST  creategoodsorder' => 'creategoodsorder',
    //         'GET orderdetail' => 'orderdetail',
    //         'GET getexpress' => 'getexpress',
    //         'GET,POST,PUT,OPTIONS kdinform' => 'Kdinform',
    //         'POST  integralpay' => 'integralpay',
    //         'POST,GET  deletebytime' => 'deletebytime',
    //     ],
    // ],
    // // 商品
    // [
    //     'class' => 'yii\rest\UrlRule',
    //     'controller' => ['diandi_hub/goods'],
    //     'pluralize' => false,
    //     'extraPatterns' => [
    //         'GET lists' => 'lists',
    //         'GET detail' => 'detail',
    //         'GET goodgift' => 'goodgift',
    //         'GET search' => 'search',
    //         'GET orderdetail' => 'orderdetail',
    //         'POST painter' => 'painter',
    //         'POST collect' => 'collect',
    //     ],
    // ],
    // // 购物车
    // [
    //     'class' => 'yii\rest\UrlRule',
    //     'controller' => ['diandi_hub/cart'],
    //     'pluralize' => false,
    //     'extraPatterns' => [
    //         'POST add' => 'add',
    //         'POST list' => 'list',
    //         'POST clear' => 'clear',
    //         'POST deletecart' => 'deletecart',
    //     ],
    // ],
    // // 分类
    // [
    //     'class' => 'yii\rest\UrlRule',
    //     'controller' => ['diandi_hub/category'],
    //     'pluralize' => false,
    //     'extraPatterns' => [
    //         'GET list' => 'list',
    //     ],
    // ],
    // // 收货地址start
    // [
    //     'class' => 'yii\rest\UrlRule',
    //     'controller' => ['diandi_hub/address'],
    //     'pluralize' => false,
    //     'extraPatterns' => [
    //         'POST getdefault' => 'getdefault',
    //         'POST setdefault' => 'setdefault',
    //         'POST lists' => 'lists',
    //         'POST deletes' => 'deletes',
    //         'POST detail' => 'detail',
    //         'POST edit' => 'edit',
    //         'POST add' => 'add',
    //     ],
    // ],
    // // 评论
    // [
    //     'class' => 'yii\rest\UrlRule',
    //     'controller' => ['diandi_hub/comment'],
    //     'pluralize' => false,
    //     'extraPatterns' => [
    //         'POST comment' => 'comment',
    //         'GET list' => 'list',
    //     ],
    // ],
    // // 区域
    // [
    //     'class' => 'yii\rest\UrlRule',
    //     'controller' => ['diandi_hub/areas'],
    //     'pluralize' => false,
    //     'extraPatterns' => [
    //         'POST list' => 'list',
    //     ],
    // ],
    // [
    //     'class' => 'yii\rest\UrlRule',
    //     'controller' => ['diandi_hub/member'],
    //     'pluralize' => false,
    //     'extraPatterns' => [
    //         'GET info' => 'info',
    //         'GET   myagent' => 'myagent',
    //         'POST   qrcode' => 'qrcode',
    //         'POST   addpayset' => 'addpayset',
    //         'POST   collect' => 'collect',
    //         'GET   getpayset' => 'getpayset',
    //         'POST   editbankapply' => 'editbankapply',
    //         'GET   withdrawlist' => 'withdrawlist',
    //         'POST   wechat-qrcode' => 'wechat-qrcode',
    //     ],
    // ],
    // [
    //     'class' => 'yii\rest\UrlRule',
    //     'controller' => ['diandi_hub/level'],
    //     'pluralize' => false,
    //     'extraPatterns' => [
    //         'POST link' => 'link',
    //     ],
    // ],
    // [
    //     'class' => 'yii\rest\UrlRule',
    //     'controller' => ['diandi_hub/account'],
    //     'pluralize' => false,
    //     'extraPatterns' => [
    //         'GET  log' => 'log',
    //         'POST order' => 'order',
    //         'POST addlog' => 'addlog',
    //         'POST withdraw' => 'withdraw',
    //     ],
    // ],
    // [
    //     'class' => 'yii\rest\UrlRule',
    //     'controller' => ['diandi_hub/store'],
    //     'pluralize' => false,
    //     'extraPatterns' => [
    //         'POST add' => 'add',
    //         'POST addpay' => 'addpay',
    //         'GET paylist' => 'paylist',
    //         'POST memberpaylist' => 'memberpaylist',
    //         'GET express' => 'express',
    //         'POST paydetail' => 'paydetail',
    //         'GET mystore' => 'mystore',
    //         'GET conf' => 'conf',
    //         'POST list' => 'list',
    //         'POST creditpay' => 'creditpay',
    //         'POST confirmonline' => 'confirmonline',
    //     ],
    // ],
    // // 售后
    // [
    //     'class' => 'yii\rest\UrlRule',
    //     'controller' => ['diandi_hub/refund'],
    //     'pluralize' => false,
    //     'extraPatterns' => [
    //         'POST add' => 'add',
    //         'POST  list' => 'list',
    //         'GET info' => 'info',
    //         'POST  detail' => 'detail',
    //         'POST  cancel' => 'cancel',
    //     ],
    // ],
    // [
    //     'class' => 'yii\rest\UrlRule',
    //     'controller' => ['diandi_hub/express'],
    //     'pluralize' => false,
    //     'extraPatterns' => [
    //         'POST list' => 'list',
    //     ],
    // ],
    // [
    //     'class' => 'yii\rest\UrlRule',
    //     'controller' => ['diandi_hub/tickets'],
    //     'pluralize' => false,
    //     'extraPatterns' => [
    //         'GET lists' => 'lists',
    //         'POST create' => 'create',
    //         'POST,PUT update/<id>' => 'update',
    //         'PUT status/<id>' => 'status',
    //         'POST,GET,DELETE delete/<id>' => 'delete',
    //         'GET view/<id>' => 'view',
    //     ],
    // ],
    // [
    //     'class' => 'yii\rest\UrlRule',
    //     'controller' => ['diandi_hub/tickets-record'],
    //     'pluralize' => false,
    //     'extraPatterns' => [
    //         'GET lists' => 'lists',
    //         'POST create' => 'create',
    //     ],
    // ],
];
