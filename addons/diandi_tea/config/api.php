<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-14 10:56:16
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-27 20:33:53
 */

 return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_tea/index'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'POST,GET top' => 'top',
            'GET sms' => 'sms',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_tea/order'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'POST,GET setmeallist' => 'set-meal-list',
            'POST,GET hoursedetail' => 'hourse-detail',
            'POST,GET refund' => 'refund', // 退款
            'POST,GET couponlist' => 'coupon-list',
            'POST,GET mycoupon' => 'my-coupon',
            'POST,GET rechargeactivity' => 'recharge-activity',
            'POST,GET renewprice' => 'renew-price',
            'POST,GET createorder' => 'create-order',
            'POST,GET createrechargeorder' => 'create-recharge-order',
            'POST,GET createbuycouponorder' => 'create-buy-coupon-order',
            'POST,GET cancelorder' => 'cancel-order',
            'POST,GET charging' => 'charging',
            'POST,GET orderdetail' => 'order-detail',
            'POST,GET invoice' => 'invoice',
            'POST,GET invoicelist' => 'invoice-list',
            'GET opendoor' => 'open-door',
            'GET gethourse' => 'get-hourse',
            'GET info' => 'info',
            'POST choosecoupon' => 'choose-coupon',
            'GET noworder' => 'now-order',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_tea/member'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'POST,GET info' => 'info',
            'POST,GET order' => 'order',
            'POST,GET balance' => 'balance',
            'POST,GET editmember' => 'edit-member',
            'POST,GET integral' => 'integral',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_tea/balance'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'POST,GET orderbalancepay' => 'order-balance-pay',
            'POST,GET couponbalancepay' => 'coupon-balance-pay',
            'POST,GET balance' => 'balance',
            'POST,GET editmember' => 'edit-member',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_tea/notify'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'POST,GET notify' => 'notify',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_tea/marketing'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'POST,GET coupondetail' => 'coupon-detail',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_tea/timing-work'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'POST,GET cancelorder' => 'cancel-order',
            'POST,GET finishorder' => 'finish-order',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_tea/api'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'POST,GET test' => 'test',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_tea/notice'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'POST orderobs' => 'orderobs',
            'POST renewobs' => 'renewobs',
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_tea/meituan'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'POST add' => 'add',
            'POST showcoupon' => 'show-coupon',
            'POST give' => 'give',
            'POST order' => 'order',
            'GET detail' => 'detail',
        ],
    ],
 ];
