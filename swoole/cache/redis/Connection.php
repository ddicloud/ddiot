<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-09-24 11:56:17
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-09-26 15:13:56
 */

namespace ddswoole\cache\redis;

use ddswoole\pool\DbPool;
use ddswoole\pool\RedisPool;
use Swoole\Coroutine\Redis;
use yii\base\Exception;

class Connection extends \yii\redis\Connection
{
    /**
     * @var string redis pool key
     */
    public $poolKey;
    /**
     * @var Redis
     */
    private $_socket;
    /**
     * @var DbPool
     */
    private $pool;
    /**
     * @var array https://wiki.swoole.com/wiki/page/590.html
     */
    const NotSupportCMD = ['SCAN', 'OBJECT', 'SORT', 'MIGRATE', 'HSCAN', 'SSCAN', 'ZSCAN'];

    /**
     * Returns a value indicating whether the DB connection is established.
     *
     * @return bool whether the DB connection is established
     */
    public function getIsActive()
    {
        return $this->_socket !== null;
    }

    /**
     * Establishes a DB connection.
     * It does nothing if a DB connection has already been established.
     *
     * @throws Exception if connection fails
     */
    public function open()
    {
        if ($this->_socket !== null) {
            return;
        }
        $connection = ($this->unixSocket ?: $this->hostname.':'.$this->port).', database='.$this->database;
        \Yii::trace('Opening redis DB connection: '.$connection, __METHOD__);
        $this->_socket = $this->getConnectionFormPool();
        $this->initConnection();
    }

    /**
     * Executes a redis command.
     * For a list of available commands and their parameters see http://redis.io/commands.
     *
     * @return array|bool|string|null Dependent on the executed command this method
     *                                will return different data types:
     *
     * - `true` for commands that return "status reply" with the message `'OK'` or `'PONG'`.
     * - `string` for commands that return "status reply" that does not have the message `OK` (since version 2.0.1).
     * - `string` for commands that return "integer reply"
     *   as the value is in the range of a signed 64 bit integer.
     * - `string` or `null` for commands that return "bulk reply".
     * - `array` for commands that return "Multi-bulk replies".
     *
     * See [redis protocol description](http://redis.io/topics/protocol)
     * for details on the mentioned reply types.
     * @trows Exception for commands that return [error reply](http://redis.io/topics/protocol#error-reply).
     */
    public function executeCommand($name, $params = [], $reconnect = 0)
    {
        if (in_array($name, self::NotSupportCMD)) {
            throw new Exception('Swoole Coroutine Redis does no support Redis command : '.$name);
        }
        $this->open();
        // backup the params for try again when execute fail
        try {
            \Yii::trace("Executing Redis Command: {$name}", __METHOD__);
            print_r($this->_socket->getPools());
            $ret = $this->_socket->getPools()->get()->{$name}(...$params);
            if ($this->_socket->errCode) {
                throw new Exception("Redis error: {$this->_socket->errMsg} \nRedis command was: ".$name);
            }

            return $ret;
        } finally {
            $this->releaseConnect();
        }
    }

    /**
     * Closes the currently active DB connection.
     * It does nothing if the connection is already closed.
     */
    public function releaseConnect()
    {
        /** @var ConnectionManager $cm */
        $cm = \Yii::$app->getConnectionManager();
        $cm->releaseConnection($this->poolKey, $this->_socket);
        $this->_socket = null;
    }

    /**
     * @return Redis
     */
    protected function getConnectionFormPool()
    {
        /** @var ConnectionManager $cm */
        $cm = \Yii::$app->getConnectionManager();
        $poolKey = $this->buildPoolKey();
        $this->pool = $cm->getPool($poolKey);
        if (!$this->pool) {
            // connect_timeout && time in  4.2.10
            $config = [
                'size' => 100,
                'hostname' => $this->hostname,
                'port' => $this->port,
                'database' => $this->database,
                'timeout' => $this->dataTimeout ? $this->dataTimeout : -1, //-1 is swoole default
                'password' => $this->password,
            ];
            $pc = $cm->poolConfig['redis'] ?? [];
            $dbPool = new DbPool($pc);
            $dbPool->createHandle = function () use ($config) {
                $client = new RedisPool([
                    'hostname' => $config['hostname'],
                    'port' => $config['port'],
                    'password' => $config['password'],
                    'database' => $config['database'],
                    'timeout' => $config['timeout'],
                    'size' => $config['size'],
                ], $this->poolKey);
                \Yii::trace('create new mysql connection', __METHOD__);

                return $client;
            };
            $this->pool = $dbPool;
            $cm->addPool($poolKey, $dbPool);
        }

        return $this->pool->getConnect();
    }

    protected function buildPoolKey()
    {
        if (!$this->poolKey) {
            $connection = $this->hostname.':'.$this->port.', database='.$this->database;
            $this->poolKey = md5($connection);
        }

        return $this->poolKey;
    }
}
