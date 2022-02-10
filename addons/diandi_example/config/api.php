<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-06-08 17:33:49
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-11-15 11:32:34
 */


return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_task/task'], //模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'POST uptable' => 'uptable', //请求方式 请求方法，映射方法
        ],
    ]
];
