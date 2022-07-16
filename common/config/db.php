<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-18 16:51:31
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-07-15 14:45:30
 */

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=82.156.131.85;dbname=dev.hopes;port=3306',
    'tablePrefix' => 'dd_',
    'username' => 'dev.hopes',
    'password' => 'ceJ2ydXti5FjjMGb',
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
];
