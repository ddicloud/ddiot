<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2023-04-25 16:02:31
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-04-25 16:08:06
 */

/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/5/24
 * Time: 下午4:12
 */

namespace EasySwoole\Component;

use \Swoole\Process;

class Invoker
{
    /*
     * 以下方法进攻同步方法使用
     */
    public static function exec(callable $callable, $timeOut = 100 * 1000, ...$params)
    {
        pcntl_async_signals(true);
        pcntl_signal(SIGALRM, function () {
            Process::alarm(-1);
            throw new \RuntimeException('func timeout');
        });
        try {
            Process::alarm($timeOut);
            $ret = call_user_func($callable, ...$params);
            Process::alarm(-1);
            return $ret;
        } catch (\Throwable $throwable) {
            throw $throwable;
        }
    }
}
