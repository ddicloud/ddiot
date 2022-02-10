<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-09 22:51:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-18 16:52:17
 */
$db = require(__DIR__ . '/db.php');
return [
    'components' => [
        'db' => $db,
        // 'mongodb' => [
        //     'class' => '\yii\mongodb\Connection',
        //     'dsn' => 'mongodb://@localhost:27017/mydatabase',
        //     'options' => [
        //         'username' => 'ceshi',
        //         'password' => 'Password',
        //     ],
        // ],
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
