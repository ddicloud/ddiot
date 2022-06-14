<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-14 15:06:16
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-14 15:06:38
 */

namespace console\swoole\servers;

class ProcessPool
{
    private $process;

    /**
     * Worker 进程数组.
     *
     * @var array
     */
    private $process_list = [];

    /**
     * 正在被使用的进程.
     *
     * @var array
     */
    private $process_use = [];

    /**
     * 最少进程数量.
     *
     * @var int
     */
    private $min_worker_num = 3;

    /**
     * 最多进程数量.
     *
     * @var int
     */
    private $max_worker_num = 6;

    /**
     * 当前进程数量.
     *
     * @var int
     */
    private $current_num;

    public function __construct()
    {
        $this->process = new swoole_process([$this, 'run'], false, 2);
        $this->process->start();
        swoole_process::wait();
    }

    public function run()
    {
        $this->current_num = $this->min_worker_num;
        //创建所有的worker进程
        for ($i = 0; $i < $this->current_num; ++$i) {
            $process = new swoole_process([$this, 'task_run'], false, 2);
            $pid = $process->start();
            $this->process_list[$pid] = $process;
            $this->process_use[$pid] = 0;
        }

        foreach ($this->process_list as $process) {
            swoole_event_add($process->pipe, function ($pipe) use ($process) {
                $data = $process->read();
                var_dump($data.'空闲');
                //接收子进程处理完成的信息，并且重置为空闲
                $this->process_use[$data] = 0;
            });
        }

        //每秒定时向worker管道投递任务
        swoole_timer_tick(1000, function ($timer_id) {
            static $index = 0;
            $index = $index + 1;
            $flag = true; //是否新建worker
            foreach ($this->process_use as $pid => $used) {
                if ($used == 0) {
                    $flag = false;
                    //标记为正在使用
                    $this->process_use[$pid] = 1;
                    // 在父进程内调用write，子进程可以调用read接收此数据
                    $this->process_list[$pid]->write($index.'hello');
                    break;
                }
            }

            if ($flag && $this->current_num < $this->max_worker_num) {
                //没有闲置worker，新建worker来处理
                $process = new swoole_process([$this, 'task_run'], false, 2);
                $pid = $process->start();
                $this->process_list[$pid] = $process;
                $this->process_use[$pid] = 1;
                $this->process_list[$pid]->write($index.'hello');
                ++$this->current_num;
            }
            var_dump('第'.$index.'个任务');
            if ($index == 10) {
                foreach ($this->process_list as $process) {
                    $process->write('exit');
                }
                swoole_timer_clear($timer_id);
                $this->process->exit();
            }
        });
    }

    /**
     * 子进程处理.
     *
     * @param $worker
     */
    public function task_run($worker)
    {
        swoole_event_add($worker->pipe, function ($pipe) use ($worker) {
            $data = $worker->read();
            var_dump($worker->pid.':'.$data);
            if ($data == 'exit') {
                $worker->exit();
                exit;
            }
            //模拟耗时任务
            sleep(5);
            //告诉主进程处理完成
            //在子进程内调用write，父进程可以调用read接收此数据
            $worker->write($worker->pid);
        });
    }
}

new ProcessPool();
