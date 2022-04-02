<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-09 22:51:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-30 22:15:34
 */
$db = require __DIR__.'/db.php';
$sqlServer = require __DIR__.'/sqlServer.php';
$mongodb = require __DIR__.'/mongodb.php';
$redis = require __DIR__.'/redis.php';

return [
    'components' => [
        'db' => $db,
        // 'sqlServer' => $sqlServer,
        // 'mongodb' => $mongodb,
         /* ------ 缓存 ------ **/
        'cache' => [
            'class' => 'yii\redis\Cache',
        ],
        /* ------ REDIS ------ **/
        'redis' => $redis,
    ],
    'language' => 'zh-CN',
];
