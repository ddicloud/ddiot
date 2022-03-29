<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-09 22:51:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-25 20:00:36
 */
$db = require __DIR__.'/db.php';

return [
    'components' => [
        'db' => $db,
        'db2' => [
            'class' => 'yii\db\Connection',
            'driverName' => 'sqlsrv',
            'dsn' => 'sqlsrv:Server=125.72.69.150,1433;Database=测试库',
            'username' => 'sa',
            'password' => 'pqhuatong@BH',
            'charset' => 'utf8',
        ],
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
