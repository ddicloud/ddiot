<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-19 20:27:15
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-12 18:26:18
 */
return [
    'host' => '127.0.0.1',
    'port' => 9527,
    'mode' => SWOOLE_PROCESS,
    'sockType' => SWOOLE_SOCK_TCP,
    'app' => require __DIR__.'/web.php',
    'options' => [
        'task_enable_coroutine' => true,
        'pid_file' => __DIR__.'/../runtime/baseserver.pid',
        'log_file' => __DIR__.'/../runtime/baseserver.log',
        'debug_mode' => 1,
        'user' => 'www',
        'group' => 'www',
        // 4.0 新增选项
        'worker_num' => 2,
        'daemonize' => 0,
        'task_worker_num' => 4,
    ],
];
