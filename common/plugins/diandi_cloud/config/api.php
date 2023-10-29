<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-04-12 14:08:05
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-09-20 11:13:37
 */

return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_cloud/api'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET json-base' => 'json-base', //请求方式 请求方法，映射方法
            'GET admin-base' => 'admin-base', //请求方式 请求方法，映射方法
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_cloud/auth-addons'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'POST checkauth' => 'check-auth', //请求方式 请求方法，映射方法
            'POST check-domain' => 'check-domain', //请求方式 请求方法，映射方法
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_cloud/addons'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET lists' => 'lists', //请求方式 请求方法，映射方法
            'GET detail/<id>' => 'detail', //请求方式 请求方法，映射方法
            'POST authlist' => 'auth-list', //请求方式 请求方法，映射方法
        ],
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_cloud/member'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'POST register-developer' => 'register-developer', //请求方式 请求方法，映射方法
            'POST pay' => 'pay', //请求方式 请求方法，映射方法
            'POST submit-audit' => 'submit-audit', //请求方式 请求方法，映射方法
            'GET detail' => 'detail', //请求方式 请求方法，映射方法
        ],
    ],
];
