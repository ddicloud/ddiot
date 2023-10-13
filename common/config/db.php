<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-18 16:51:31
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-07-26 15:23:56
 */

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host='. env('DB_HOST') .';dbname='. env('DB_NAME').';port='. env('DB_PORT'),
    'username' => env('DB_USER'),
    'password' => env('DB_PASS'),
    'tablePrefix' => env('DB_PREFIX'),
    'charset' => 'utf8',
    'attributes' => [
        PDO::ATTR_STRINGIFY_FETCHES => false,
        PDO::ATTR_EMULATE_PREPARES => false,
    ],
    'enableSchemaCache' => true,
    // Duration of schema cache.
    'schemaCacheDuration' => 3600,
    // Name of the cache component used to store schema information
    'schemaCache' => 'cache',
    'slaveConfig' => [
        'username' => 'root',
        'password' => 'root',
        'attributes' => [
            // 从数据库连接参数配置
        ],
    ],
];
