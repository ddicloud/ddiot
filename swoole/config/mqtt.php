<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-19 20:27:15
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-16 18:51:34
 */
return [
    'host' => '127.0.0.1',
    'port' => 1883,
    'mode' => SWOOLE_BASE,
    'sockType' => SWOOLE_SOCK_TCP,
    'app' => require __DIR__.'/web.php',
    'options' => [
        // mqtt start
        'open_mqtt_protocol' => true,
        'worker_num' => 2,
        'package_max_length' => 2 * 1024 * 1024,
        'connect_timeout' => 5.0,
        'write_timeout' => 5.0,
        'read_timeout' => 5.0,
        // mqtt end
        'task_enable_coroutine' => true,
        'pid_file' => __DIR__.'/../runtime/mqtt.pid',
        'log_file' => __DIR__.'/../runtime/mqtt.log',
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
