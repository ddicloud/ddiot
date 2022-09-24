<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-09-24 09:42:16
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-09-24 09:45:38
 */

namespace ddswoole\cache\redis;

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

    public $redisPoolClass = 'deepziyu\yii\swoole\pool\RedisPool';

    /**
     * @var RedisPool
     */
    private $_redisPool;

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
            $this->_redisPool = Yii::createObject($config);
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
