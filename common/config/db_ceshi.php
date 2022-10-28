<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-18 16:51:31
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 10:27:07
 */

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=82.156.131.85;dbname=www_wayfirer_com;port=3306',
    'tablePrefix' => 'dd_',
    'username' => 'www_wayfirer_com',
    'password' => 'bkBmPJzbPFzTCn3E',
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
