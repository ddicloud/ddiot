<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-09 22:51:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-29 09:33:46
 */
$db = require __DIR__.'/db.php';
$sqlServer = require __DIR__.'/sqlServer.php';
$mongodb = require __DIR__.'/mongodb.php';

return [
    'components' => [
        'db' => $db,
        'sqlServer' => $sqlServer,
        'mongodb' => $mongodb,
         /* ------ 缓存 ------ **/
        'cache' => [
            'class' => 'yii\redis\Cache',
        ],
        /* ------ REDIS ------ **/
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 2,
        ],
    ],
    'language' => 'zh-CN',
];
