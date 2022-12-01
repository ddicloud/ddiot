<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-19 20:27:15
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-11-30 20:21:39
 */
return [
    'host' => '0.0.0.0',
    'port' => 9501,
    'ssl' => false,
    'app' => require __DIR__ . '/web.php',
    'options' => [
        'task_enable_coroutine' => true,
        'pid_file' => __DIR__ . '/../runtime/swoole.pid',
        'log_file' => __DIR__ . '/../runtime/swoole.log',
        'http_parse_post' => false,
        'debug_mode' => 1,
        'user' => 'www',
        'group' => 'www',
        // 4.0 新增选项
        'worker_num' => 2,
        'daemonize' => 0,
        'task_worker_num' => 4,
    ],
];
