<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-09 22:51:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-03 16:03:16
 */
$db = require __DIR__.'/db.php';
if (file_exists(__DIR__.'/sqlServer.php')) {
    $sqlServer = require __DIR__.'/sqlServer.php';
}
if (file_exists(__DIR__.'/mongodb.php')) {
    $mongodb = require __DIR__.'/mongodb.php';
}

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
