<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-08-30 16:43:08
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-11-18 15:29:49
 */

namespace ddswoole\pool;

use Swoole\Database\PDOPool;
use Swoole\Database\RedisPool;
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
     * 连接池中取一个连接
     *
     * @return object|null
     */
    public function getConnect($retry = 0)
    {
        $connect = null;
        $connect = $this->createConnect();
        // 重试3次
        if (!$connect) {
            $a = 0;
            while ($a <= 3) {
                $connect = $this->createConnect();
                $a++;
            }
        }

        if (!$connect) {
            //创新创建3次
            sleep($this->waitTime);
            while ($retry <= 3) {
                $connect = $this->getConnect(++$retry);
                $retry++;
            }
        }

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
    public function release($pool, $client)
    {
        if ($pool instanceof PDOPool) {
            $pool->put($client);
        }else if($pool instanceof RedisPool){
            $pool->put($client);
        }
    }

    abstract public function createConnect();

    abstract public function reConnect($client);
}
