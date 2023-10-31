<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-04-05 12:09:17
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-03-14 16:25:40
 */

return [
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
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_hub/messages-category'],
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
    /*
前台接口移植 - 结束 ------------------------------------------------------------------------------
 */
];
