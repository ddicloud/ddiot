<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-09-24 09:42:16
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-09-24 11:38:36
 */

namespace ddswoole\cache\redis;

use ddswoole\pool\DbPool;
use ddswoole\pool\RedisPool;
use Yii;

class Connection extends \yii\redis\Connection
{
    public $hostname = '127.0.0.1';

    public $port = 6379;

    public $connectionTimeout;

    public $password;

    public $database;

    public $maxSize = 500;

    public $minSize = 10;

    public $sleep = 0.01;

    public $maxSleepTimes = 10;

    public $redisPoolClass = 'ddswoole\pool\RedisPool';

    /**
     * @var RedisPool
     */
    private $_redisPool;

    private $poolKey;

    private $client = null;

    public function getIsActive()
    {
        return true;
    }

    public function open()
    {
        $config = [
            'class' => $this->redisPoolClass,
            'hostname' => $this->hostname,
            'port' => $this->port,
            'timeout' => $this->connectionTimeout,
            'password' => $this->password,
            'database' => $this->database,
            'maxSize' => $this->maxSize,
            'minSize' => $this->minSize,
            'sleep' => $this->sleep,
            'maxSleepTimes' => $this->maxSleepTimes,
        ];

        try {
            $this->_redisPool = $this->getPool();
        } catch (\Throwable $throwable) {
            $connection = ($this->hostname.':'.$this->port).', database='.$this->database;
            Yii::error("Failed to open redis DB connection ($connection): {$throwable->getMessage()}", __CLASS__);
            throw $throwable;
        }
        $this->trigger(self::EVENT_AFTER_OPEN);
    }

    public function __call($name, $params)
    {
        $redisCommand = strtoupper($name);
        if (in_array($redisCommand, $this->redisCommands)) {
            return $this->executeCommand($redisCommand, $params);
        } else {
            return parent::__call($name, $params);
        }
    }

    public function getPool()
    {
        if ($this->client === null) {
            $this->client = $this->getConnectionFromPool();
        }
        // if (!$this->client->connected) {
        //     $this->client->connect($this->config);
        //     //TODO SWoole 可能有重连机制,导致connect在已连情况下,重新连接返回False,对Connected状态也是不对的.无法优雅判断是否正常连接.
        // }

        return $this->client->getPools();
    }

    /**
     * 获取数据库连接.
     *
     * @return object
     * @date 2022-09-05
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public function getClient()
    {
        if ($this->client === null) {
            $this->client = $this->getConnectionFromPool();
        }
        // if ($this->client->connected == false) {
        //     $this->client->connect($this->config);
        //     //TODO SWoole 可能有重连机制,导致connect在已连情况下,重新连接返回False,对Connected状态也是不对的.无法优雅判断是否正常连接.
        // }
        return $this->client->getPools()->get();
    }

    /**
     * 释放链接.
     */
    public function releaseConnect()
    {
        /** @var ConnectionManager $cm */
        $cm = \Yii::$app->getConnectionManager();
        $cm->releaseConnection($this->poolKey, $this->client);
        $this->client = null;
    }

    /**
     * 从链接池中获取一个链接.
     *
     * @return object|null
     */
    protected function getConnectionFromPool()
    {
        /** @var ConnectionManager $cm */
        $cm = \Yii::$app->getConnectionManager();
        if (!$cm->hasPool($this->poolKey)) {
            $ManagerConfig = $cm->poolConfig['redis'] ?? [];
            $dbPool = new DbPool($ManagerConfig);
//            $config = $this->config;

            $config = require yii::getAlias('@common/config/redis.php');

            // 'class' => 'yii\redis\Connection',
            // 'hostname' => 'localhost',
            // 'port' => 6379,
            // 'database' => 2,

            $dbPool->createHandle = function () use ($config) {
                $client = new RedisPool([
                    'hostname' => $config['hostname'],
                    'port' => $config['port'],
                    'database' => $config['database'],
                    'timeout' => 1000,
                    'maxSize' => 500,
                    'minSize' => 10,
                    'sleep' => 0.01,
                    'maxSleepTimes' => 10,
                    'count' => 10,
                ]);
                \Yii::trace('create new mysql connection', __METHOD__);

                return $client;
            };
            $cm->addPool($this->poolKey, $dbPool);
        }

        return $cm->get($this->poolKey);
    }

    protected function buildPoolKey()
    {
        if (!$this->poolKey) {
            $this->poolKey = md5($this->dsn);
        }

        return $this->poolKey;
    }

    public function executeCommand($name, $params = [])
    {
        $this->open();
        $data = $this->_redisPool->executeCommand($name, ...$params);
        if ($data->errCode !== 0) {
            $message = ($this->hostname.':'.$this->port).', database='.$this->database.', command: '.$name.', errorMsg:'.$data->errMsg.', data:'.json_encode($params);
            Yii::error($message);

            return null;
        }

        return $data->result;
    }
}
