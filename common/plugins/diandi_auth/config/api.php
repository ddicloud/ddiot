<?php

 return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_auth/api'],//模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'GET index' => 'index',//请求方式 请求方法，映射方法
        ],
    ]
 ];
