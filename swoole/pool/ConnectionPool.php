<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-08-30 16:43:08
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-09-28 09:23:31
 */

namespace ddswoole\pool;

use ddswoole\servers\DebugService;
use yii\base\Component;
use yii\base\Exception;

abstract class ConnectionPool extends Component
{
    /**
     * @var int max active connections
     */
    public $maxActive = 100;
    /**
     * @var float 当链接数满时,重新获取的等待时间,秒为单位
     */
    public $waitTime = 0.01;
    /**
     * the nubmer of current connections
     *
     * @var int
     */
    protected $currentCount = 0;

    /**
     * the queque of connection
     *
     * @var \SplQueue
     */
    protected $queue = null;

    /**
     * 连接池中取一个连接
     *
     * @return object|null
     */
    public function getConnect($retry = 0)
    {
        // if ($this->queue == null) {
        //     $this->queue = new \SplQueue();
        // }
        $connect = null;
        DebugService::consoleWrite('从连接池拿连接',[
            'currentCount'=>$this->currentCount,
            'maxActive'=>$this->maxActive,
        ]);

        $connect = $this->createConnect();
        if(!$connect){
            $a = 0;
            while ($a <= 3) {
                $connect = $this->createConnect();
                $a++;
            }
        }
       

        // if (!$this->queue->isEmpty()) {
        //     $connect = $this->queue->shift();
        // } elseif ($this->currentCount < $this->maxActive) {
        //     $connect = $this->createConnect();

        // } elseif ($retry < 3) {
        //     //重试3次
        //     \Swoole\Coroutine::sleep($this->waitTime);
        //     $connect = $this->getConnect(++$retry);
        // }


        if ($connect === null) {
            throw new Exception('connection pool is full');
        }
      
        return $connect;
    }

    /**
     * 释放一个连接到连接池
     *
     * @param object $connect 连接
     */
    public function release($connect)
    {
        // print_r($connect);
         // 释放连接
        //  $pool = $this->getConnectionFromPool();
        //  $pool->close($this->client);
        
        // DebugService::consoleWrite('从连接池释放连接开始',[
        //     'currentCount'=>$this->currentCount,
        //     'maxActive'=>$this->maxActive,
        // ]);
        // $currentCount = $this->currentCount;
        // if ($this->queue->count() < $this->maxActive) {
        //     $this->queue->push($connect);
        //     $currentCount--;
        // }
        
        // $this->currentCount = $currentCount;
        // DebugService::consoleWrite('从连接池释放连接结束',[
        //     'currentCount'=>$this->currentCount,
        //     'maxActive'=>$this->maxActive,
        // ]);
    }

    abstract public function createConnect();

    abstract public function reConnect($client);
}
