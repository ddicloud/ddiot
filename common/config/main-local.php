<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-09 22:51:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-11-23 14:26:55
 */
$db = [];
$sqlServer = [];
$mongodb = [];
if (file_exists(__DIR__ . '/db.php')) {
    $db = require __DIR__ . '/db.php';
}

if (file_exists(__DIR__ . '/sqlServer.php')) {
    $sqlServer = require __DIR__ . '/sqlServer.php';
}
if (file_exists(__DIR__ . '/mongodb.php')) {
    $mongodb = require __DIR__ . '/mongodb.php';
}

$redis = require __DIR__ . '/redis.php';

return [
    'components' => [
        'db' => $db,
        // 'sqlServer' => $sqlServer,
        // 'mongodb' => $mongodb,
        /* ------ 缓存 ------ **/
        'cache' => [
            'class' => 'yii\redis\Cache',
            'defaultDuration' => 60 * 60 * 2, //默认缓存2个小时
        ],
        /* ------ REDIS ------ **/
        'redis' => $redis,
    ],
    'language' => 'zh-CN',
];
