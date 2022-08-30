<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-08-30 17:04:49
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-30 19:49:17
 */

namespace swooleService\db\mysql;

use PDOException;
use swooleService\pool\ConnectionManager;
use swooleService\pool\PdoPool as PoolPdoPool;
use Swoole\Coroutine;
use Swoole\Coroutine\Mysql;
use Yii;

/**
 * mysql的pdo类
 * @package swooleService\db\mysql
 */
class PDO extends \PDO
{
    private $poolKey;

    private $dsn;

    private $config;

    /**
     * @var Mysql
     */
    private $client;

    public $options = [];

    /**
     * @var bool 是否在事务中
     */
    private $inTransaction;

    public function __construct($dsn, $username, $passwd, $options)
    {
        $this->dsn = $dsn;
        $this->config = self::parseDsn($dsn, ['host', 'port', 'dbname', 'charset']);
        $this->config['database'] = $this->config['dbname'];
        unset($this->config['dbname']);
        $this->config['user'] = $username;
        $this->config['password'] = $passwd;
        $this->options = $options;
        $this->poolKey = $this->buildPoolKey();
    }

    #[\ReturnTypeWillChange]
    public function prepare($statement, $driver_options = null)
    {
        $pdoStatement = new PDOStatement($this);
        $pdoStatement->setQueryString($statement);
        return $pdoStatement;
    }

    /**
     * Parses a DSN string according to the rules in the PHP manual
     *
     * See also the PDO_User::parseDSN method in pecl/pdo_user. This method
     * mimics the functionality provided by that method.
     *
     * @param string $dsn
     *
     * @return array
     * @link http://www.php.net/manual/en/pdo.construct.php
     */
    public static function parseDsn($dsn)
    {
        if (strpos($dsn, ':') !== false) {
            $driver = substr($dsn, 0, strpos($dsn, ':'));
            $vars = substr($dsn, strpos($dsn, ':') + 1);
            if ($driver == 'uri') {
                throw new \PDOException('dsn by uri is not support');
            } else {
                $val = [];
                foreach (explode(';', $vars) as $var) {
                    $param = explode('=', $var, 2);
                    if ($param[0] === 'host' && $pos = strpos($param[1], ':')) {
                        list($host, $port) = explode(':', $param[1]);
                        $val['host'] = $host;
                        $val['port'] = $port;
                    } else {
                        $val[$param[0]] = $param[1];
                    }
                }
                return $val;
            }
        } else {
            if (strlen(trim($dsn)) > 0) {
                // The DSN passed in must be an alias set in php.ini
                return self::parseDsn(ini_get("pdo.dsn.{$dsn}"));
            }
        }
        return [];
    }

    public function getClient()
    {
        if ($this->client === null) {
            $this->client = $this->getConnectionFromPool();
        }
        if ($this->client->connected == false) {
            $this->client->connect($this->config);
            //TODO SWoole 可能有重连机制,导致connect在已连情况下,重新连接返回False,对Connected状态也是不对的.无法优雅判断是否正常连接.
        }
        return $this->client;
    }

    /**
     * swoole coroutine mysqlClient 不支持属性设置
     * @param int $attribute
     * @param mixed $value
     * @return bool
     */
    #[\ReturnTypeWillChange]
    public function setAttribute($attribute, $value)
    {
        $this->options[$attribute] = $value;
        return true;
    }

    #[\ReturnTypeWillChange]
    public function getAttribute($attribute)
    {
        if ($attribute == PDO::ATTR_CASE) {
            return PDO::CASE_NATURAL;
        }
        return $this->options[$attribute] ?? null;
    }

    /**
     * @inheritdoc
     */
    #[\ReturnTypeWillChange]
    public function quote($string, $parameter_type = PDO::PARAM_STR)
    {
        if ($parameter_type !== PDO::PARAM_STR) {
            throw new PDOException('Only PDO::PARAM_STR is currently implemented for the $parameter_type of MysqlPoolPdo::quote()');
        }
        return "'" . str_replace("'", "''", $string) . "'";
    }

    /**
     * @inheritdoc
     */
    #[\ReturnTypeWillChange]
    public function exec($statement)
    {
        return $this->getClient()->query($statement);
    }

    /**
     * @inheritdoc
     */
    #[\ReturnTypeWillChange]
    public function lastInsertId($name = null)
    {
        return $this->getClient()->insert_id;
    }

    /**
     * @inheritdoc
     */
    #[\ReturnTypeWillChange]
    public function beginTransaction()
    {
        if (!$this->getClient()->query("begin;")) {
            return false;
        }
        $this->inTransaction = true;
        return (string) $this->getClient()->sock;
    }

    /**
     * @inheritdoc
     */
    #[\ReturnTypeWillChange]
    public function commit()
    {
        $res = false;
        try {
            $res = $this->client->query("commit;");
        } catch (\Exception $exception) {
            throw $exception;
        } finally {
            $this->releaseConnect();
        }
        return $res;
    }

    /**
     * @inheritdoc
     */
    #[\ReturnTypeWillChange]
    public function rollBack()
    {
        $res = false;
        try {
            $res = $this->client->query("rollback;");
        } catch (\Exception $exception) {
            throw $exception;
        } finally {
            $this->releaseConnect();
        }
        return $res;
    }

    /**
     * @return bool
     */
    #[\ReturnTypeWillChange]
    public function inTransaction()
    {
        return $this->inTransaction;
    }

    /**
     * 释放链接
     */
    public function releaseConnect()
    {
        /** @var ConnectionManager $cm */
        $cm = \Yii::$app->getConnectionManager();
        $cm->releaseConnection($this->poolKey, $this->client);
        $this->client = null;
    }

    /**
     * 从链接池中获取一个链接
     * @return null|object
     */
    protected function getConnectionFromPool()
    {
        $PoolPdoPool = new PoolPdoPool();
        $PoolPdoPool->setConfig([
            'host' => $this->config['host'],
            'port' => $this->config['port'],
            'database' => $this->config['database'],
            'username' => $this->config['user'],
            'password' => $this->config['password'],
            'charset' => 'utf8mb4',
            'unixSocket' => null,
            'options' => [],
            'size' => 64,
        ]);

        return $PoolPdoPool->getConnection();
    }

    protected function buildPoolKey()
    {
        if (!$this->poolKey) {
            $this->poolKey = md5($this->dsn);
        }
        return $this->poolKey;
    }

}
