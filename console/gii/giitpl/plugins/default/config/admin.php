<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-26 00:09:42
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-03-24 20:00:59
 */
echo "<?php\n";
?>

 return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['diandi_task/task'],//模块名称/控制器方法
        'pluralize' => false,
        'extraPatterns' => [
            'POST uptable' => 'uptable',//请求方式 请求方法，映射方法
        ],
    ]
 ];
