<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-08-30 18:16:03
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-09-26 10:21:47
 */

namespace ddswoole\pool;

use RuntimeException;
use Swoole\Coroutine\Redis;
use Swoole\Database\RedisConfig;
use Swoole\Database\RedisPool as DatabaseRedisPool;
use yii\base\Component;
use yii\db\Exception;

class RedisPool extends Component
{
    /**
     * @var array
     */
    protected $_config = [
        'hostname' => 'localhost',
        'port' => 3306,
        'database' => 1,
        'timeout' => 1000,
        'size' => 500,
        'sleep' => 0.01,
        'maxSleepTimes' => 10,
        'count' => 10,
    ];

    public $_pools;

    protected $_poolName;

    protected $_instance;

    public $connected = false;

    /**
     * @var \SplQueue
     */
    protected $poolQueue;

    public function __construct($config, $poolName = '')
    {
        //设置一个容量为1的通道
        $this->setConfig($config);
        //执行mysql相关 操作
        $return = $this->init();
    }

    public function init()
    {
        parent::init();
        if (empty($this->getPools())) {
            $config = $this->getConfig();
            $pools = new DatabaseRedisPool((new RedisConfig())
                ->withHost($config['hostname'])
                ->withPort($config['port'])
                ->withAuth('')
                ->withDbIndex($config['database'])
                ->withTimeout(1)
            );
            $this->setPools($pools);
        }
    }

    public function getInstance()
    {
        $instance = $this->_instance;
        $config = $this->getConfig();
        if (empty($instance)) {
            if (empty($config)) {
                throw new RuntimeException('pdo config empty');
            }
            if (empty($config['size'])) {
                throw new RuntimeException('the size of database connection pools cannot be empty');
            }

            $instance = new static($config);
        }

        return $instance;
    }

    public function setInstance($value)
    {
        $this->_instance = $value;
    }

    public function getPoolName()
    {
        return $this->_poolName;
    }

    public function setPoolName($value)
    {
        $this->_poolName = $value;
    }

    private static $instance;

    public function getConnection()
    {
        return $this->_pools->get();
    }

    public function close($connection = null)
    {
        $this->_pools->put($connection);
    }

    protected function openOneConnect()
    {
        $connect = new Redis();
        $isS = $connect->connect($this->hostname, $this->port, $this->timeout);
        if ($isS === false) {
            throw new Exception($connect->errMsg, [], $connect->errCode);
        }
        if ($this->password && false === $connect->auth($this->password)) {
            throw new Exception('error password for redis', [], 500);
        }
        if ($this->database !== null && false === $connect->select($this->database)) {
            throw new Exception('error when select database for redis', [], 500);
        }
        ++$this->count;

        return $connect;
    }

    public function getPools()
    {
        return $this->_pools;
    }

    public function setPools($value)
    {
        $this->_pools = $value;
    }

    public function getConfig()
    {
        return $this->_config;
    }

    public function setConfig($value)
    {
        $this->_config = $value;
    }

    protected function releaseConnect(Redis $connect)
    {
        if (empty($connect)) {
            return;
        }
        $this->poolQueue->enqueue($connect);
    }

    /**
     * @param $redisCommand
     * @param array $params
     *
     * @return RedisResultData
     *
     * @throws \Exception
     */
    public function executeCommand($redisCommand, ...$params)
    {
        $connect = null;
        try {
            $connect = $this->getConnection();
            print_r([$redisCommand, $params]);
            $res = $connect->{$redisCommand}(...$params);
            $resultData = new RedisResultData([
                'result' => $res,
                'errCode' => $connect->errCode,
                'errMsg' => $connect->errMsg,
            ]);

            return $resultData;
        } catch (\Exception $exception) {
            throw $exception;
        } finally {
            $this->releaseConnect($connect);
        }
    }
}
