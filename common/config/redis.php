<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-18 16:51:31
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-30 22:15:17
 */

return [
  'class' => 'yii\redis\Connection',
  'hostname' => env('REDIS_HOST'),
  'port' => env('REDIS_PORT'),
  'database' => env('REDIS_DB'),
];
