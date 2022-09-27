<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-08-30 21:27:46
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-09-27 19:09:44
 */

namespace ddswoole\db\mysql;

use common\helpers\StringHelper;
use ddswoole\pool\DbPool;
use ddswoole\pool\MysqlPool;
use ddswoole\pool\PdoPool;
use ddswoole\servers\DebugService;
use PDOException;
use Swoole\Coroutine\Mysql;
use Yii;
use yii\helpers\ArrayHelper;

class PoolPDO
{
    /**
     * attributes`s key for MysqlPool.
     */
    const POOL_CLASS = 'class';
    const POOL_TIMEOUT = 'timeout';
    const POOL_MAX_SIZE = 'maxSize';
    const POOL_MIN_SIZE = 'minSize';
    const POOL_SLEEP = 'sleep';
    const POOL_MAX_SLEEP_Times = 'maxSleepTimes';

    /**
     * @var MysqlPool
     */
    public $pool;

    /**
     * @var Mysql
     */
    private $client;

    /**
     * 连接池key.
     *
     * @var [type]
     * @date 2022-09-05
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    private $poolKey;

    private $dsn;

    /**
     * @var string
     */
    public $poolClass = 'ddswoole\pool\DbPool';

    protected $_lastInsertId = 0;

    protected $options = [];

    private $methodSupport = ['fetch', 'fetchAll', 'fetchColumn'];

    /**
     * Whether currently in a transaction.
     *
     * @var bool
     */
    protected $_isTransaction = false;

    protected $_bingId = null;

    /**
     * @var bool 是否在事务中
     */
    private $inTransaction = false;

    // 保存使用
    private $columns = ['defef', 'ertert'];

    /**
     * MysqlPoolPdo constructor.
     *
     * @param $dsn
     * @param $username
     * @param $password
     * @param $options
     */
    public function __construct($dsn, $username, $password, $options)
    {
        $this->dsn = $dsn;
        $parsedDsn = static::parseDsn($dsn, ['host', 'port', 'dbname', 'charset']);

        if (!empty($parsedDsn['unix_socket'])) {
            throw new PDOException('dsn by unix_socket is not support');
        }

        $parsedDsn['database'] = $parsedDsn['dbname'];
        $parsedDsn['user'] = $username;
        $parsedDsn['password'] = $password;

        if (!empty($options[static::POOL_TIMEOUT])) {
            $parsedDsn[static::POOL_TIMEOUT] = $options[static::POOL_TIMEOUT];
        }
        unset($parsedDsn['dbname'], $options[static::POOL_TIMEOUT]);
        $options['mysqlConfig'] = $parsedDsn;
        $options['class'] = !empty($options['class']) ? $options['class'] : $this->poolClass;
        $this->options = $options;
        $this->poolKey = $this->buildPoolKey();

        $this->pool = $this->getPool();
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
        print_r($this->client);
        DebugService::consoleWrite('释放连接0',[
            'getClient'=>$this->getClient()
        ]);
        /** @var ConnectionManager $cm */
        $cm = \Yii::$app->getConnectionManager();
        $cm->releaseConnection($this->poolKey, $this->client);
        $pool =  $this->getConnectionFromPool();
        $pool->close($this->client);
        print_r($this->client);
        $this->client = null;
        DebugService::consoleWrite('释放连接1',[
            'getClient'=>$this->getClient()
        ]);
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
            $ManagerConfig = $cm->poolConfig['mysql'] ?? [];
            $dbPool = new DbPool($ManagerConfig);
//            $config = $this->config;

            $config = require yii::getAlias('@common/config/db.php');
            // mysql:host=127.0.0.1;dbname=20220628;port=3306
            list($dri, $dsn) = explode(':', $config['dsn']);
            $requestParam = StringHelper::parseAttr($dsn);
            foreach ($requestParam as $key => $value) {
                list($k, $v) = explode('=', $value);
                $dsnArr[$k] = $v;
            }

            $dbPool->createHandle = function () use ($dsnArr, $config,$ManagerConfig) {
                $client = new PdoPool([
                    'host' => $dsnArr['host'],
                    'port' => $dsnArr['port'],
                    'database' => $dsnArr['dbname'],
                    'username' => $config['username'],
                    'password' => $config['password'],
                    'charset' => 'utf8mb4',
                    'unixSocket' => null,
                    'options' => [
                        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, //开启异常模式
                    ],
                    'size' => $ManagerConfig['maxActive'],
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

    public function prepare($statement, $driver_options = null)
    {
        return new PoolPDOStatement($statement, $this, $driver_options);
    }

    /**
     * @param $sql
     * @param bool $isExecute
     * @param $method
     * @param $fetchMode
     *
     * @return int
     */
    public function doQuery($sql, $method, $fetchMode, $isExecute = false)
    {
        $data = $this->pool->doQuery($sql, $this->_bingId);
        if ($data->result === false && $data->errno) {
            throw new PDOException($data->error, $data->errno);
        }
        $this->_lastInsertId = $data->insert_id;
        if ($isExecute) {
            return $data->affected_rows;
        }
        if (!in_array($method, $this->methodSupport)) {
            throw new PDOException("$method is not support");
        }

        return $this->{$method}($data, $fetchMode);
    }

    /**
     * @param $data
     * @param $fetchMode
     *
     * @deprecated it instead by PDOStatement
     *
     * @return bool
     */
    protected function fetch($data, $fetchMode)
    {
        if (empty($data->result)) {
            return false;
        } elseif ($fetchMode == \PDO::FETCH_CLASS) {
            throw new PDOException('PDO::FETCH_CLASS is not support');
        }

        return $data->result[0];
    }

    /**
     * @param $data
     * @param $fetchMode
     *
     * @deprecated it instead by PDOStatement
     *
     * @return array
     */
    protected function fetchAll($data, $fetchMode)
    {
        if (empty($data->result)) {
            return [];
        }
        if ($fetchMode == \PDO::FETCH_COLUMN) {
            $keys = array_keys($data->result[0]);
            $key = array_shift($keys);

            return ArrayHelper::getColumn($data->result, $key);
        }

        return $data->result;
    }

    /**
     * @param $data
     * @param $fetchMode
     *
     * @deprecated it instead by PDOStatement
     *
     * @return mixed|null
     */
    protected function fetchColumn($data, $fetchMode)
    {
        if (empty($data->result[0])) {
            return null;
        }
        return array_shift($data->result[0]);
    }

    /**
     * @param null $name
     *
     * @return int
     */
    public function lastInsertId($name = null)
    {
        return $this->_lastInsertId;
    }

    public function setLastInsertId($value)
    {
        return $this->_lastInsertId = $value;
    }

    /**
     * @param int $attribute
     *
     * @return mixed|null
     */
    public function getAttribute($attribute)
    {
        if (isset($this->options[$attribute])) {
            return $this->options[$attribute];
        }

        return null;
    }

    /**
     * @param int   $attribute
     * @param mixed $value
     *
     * @return bool
     */
    public function setAttribute($attribute, $value)
    {
        $this->options[$attribute] = $value;

        return true;
    }

    public function quote($string, $parameter_type = \PDO::PARAM_STR)
    {
        if ($parameter_type !== \PDO::PARAM_STR) {
            throw new PDOException('Only PDO::PARAM_STR is currently implemented for the $parameter_type of MysqlPoolPdo::quote()');
        }

        return "'".str_replace("'", "''", $string)."'";
    }

    /**
     * @return null
     */
    public function getBingId()
    {
        return $this->_bingId;
    }

    /**
     * @return bool
     */
    public function inTransaction()
    {
        return $this->inTransaction;
    }

    public function beginTransaction()
    {
        if ($this->isTransaction()) {
            throw new PDOException('There is already an active transaction');
        }
        $sock = $this->pool->begin();
        if ($sock === false) {
            return false;
        }
        Yii::$app->on('afterRequest', [$this, 'onError']);
        $this->_bingId = $sock;

        return $this->_isTransaction = true;
    }

    /**
     * Returns true if the current process is in a transaction.
     *
     * @return bool
     */
    public function isTransaction()
    {
        return $this->_isTransaction;
    }

    /**
     * Commits all statements issued during a transaction and ends the transaction.
     *
     * @return bool
     */
    public function commit()
    {
        if (!$this->isTransaction()) {
            throw new PDOException('There is no active transaction');
        }
        $ret = $this->pool->commit($this->_bingId);
        $this->_bingId = null;
        $this->_isTransaction = false;

        return $ret;
    }

    /**
     * Rolls back a transaction.
     *
     * @return bool
     */
    public function rollBack()
    {
        if (!$this->isTransaction()) {
            throw new PDOException('There is no active transaction');
        }
        $ret = $this->pool->rollBack($this->_bingId);
        $this->_bingId = null;
        $this->_isTransaction = false;

        return $ret;
    }

    public function onError($event)
    {
        if ($this->_bingId === null) {
            return;
        }
        $this->rollBack();
    }

    /**
     * Parses a DSN string according to the rules in the PHP manual.
     *
     * See also the PDO_User::parseDSN method in pecl/pdo_user. This method
     * mimics the functionality provided by that method.
     *
     * @param string $dsn
     *
     * @return array
     *
     * @see http://www.php.net/manual/en/pdo.construct.php
     */
    public static function parseDsn($dsn, array $params)
    {
        if (strpos($dsn, ':') !== false) {
            $driver = substr($dsn, 0, strpos($dsn, ':'));
            $vars = substr($dsn, strpos($dsn, ':') + 1);
            if ($driver == 'uri') {
                throw new PDOException('dsn by uri is not support');
            } else {
                $returnParams = [];
                foreach (explode(';', $vars) as $var) {
                    $param = explode('=', $var,
                        2); //limiting explode to 2 to enable full connection strings
                    if (in_array($param[0], $params)) {
                        $returnParams[$param[0]] = $param[1];
                    }
                }

                return $returnParams;
            }
        } else {
            if (strlen(trim($dsn)) > 0) {
                // The DSN passed in must be an alias set in php.ini
                return self::parseDsn(self::iniGet("pdo.dsn.{$dsn}"), $params);
            }
        }

        return [];
    }

    /**
     * Wraps ini_get().
     *
     * This is primarily done so that we can easily stub this method in a
     * unit test.
     *
     * @param string $varname
     *
     * @return string
     */
    public static function iniGet($varname)
    {
        return ini_get($varname);
    }
}
