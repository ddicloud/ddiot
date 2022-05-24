<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-06-08 17:33:49
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-24 11:20:51
 */

return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_example/api'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'POST uptable' => 'uptable', //请求方式 请求方法，映射方法
            'GET event' => 'event', //请求方式 请求方法，映射方法
        ],
    ],
];
