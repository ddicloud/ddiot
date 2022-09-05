<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-08-30 17:04:49
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-09-05 15:27:44
 */


namespace ddswoole\db;

use common\helpers\StringHelper;
use ddswoole\pool\PdoPool;
use ddswoole\servers\DebugService;
use Yii;

/**
 * Class Command.
 */
class Command extends \yii\db\Command
{
    private $pool;

    /**
     * @var array pending parameters to be bound to the current PDO statement.
     */
    protected $_pendingParams = [];
    /**
     * @var string the SQL statement that this command represents
     */
    private $_sql;
    /**
     * @var string name of the table, which schema, should be refreshed after command execution.
     */
    private $_refreshTableName;
    protected $errorCount = 0;
    public $maxErrorTimes = 2;
    /**
     * Returns the SQL statement for this command.
     * @return string the SQL statement to be executed
     */
    public function getSql()
    {
        return $this->_sql;
    }
    /**
     * Specifies the SQL statement to be executed.
     * The previous SQL execution (if any) will be cancelled, and [[params]] will be cleared as well.
     * @param string $sql the SQL statement to be set.
     * @return $this this command instance
     */
    public function setSql($sql)
    {
        if ($sql !== $this->_sql) {
            $this->cancel();
            $this->_sql              = $this->db->quoteSql($sql);
            $this->_pendingParams    = [];
            $this->params            = [];
            $this->_refreshTableName = null;
        }
        return $this;
    }
    /**
     * Specifies the SQL statement to be executed. The SQL statement will not be modified in any way.
     * The previous SQL (if any) will be discarded, and [[params]] will be cleared as well. See [[reset()]]
     * for details.
     *
     * @param string $sql the SQL statement to be set.
     * @return $this this command instance
     * @since 2.0.13
     * @see reset()
     * @see cancel()
     */
    public function setRawSql($sql)
    {
        if ($sql !== $this->_sql) {
            $this->cancel();
            $this->reset();
            $this->_sql = $sql;
        }
        return $this;
    }
    /**
     * Returns the raw SQL by inserting parameter values into the corresponding placeholders in [[sql]].
     * Note that the return value of this method should mainly be used for logging purpose.
     * It is likely that this method returns an invalid SQL due to improper replacement of parameter placeholders.
     * @return string the raw SQL with parameter values inserted into the corresponding placeholders in [[sql]].
     */
    public function getRawSql()
    {
        if (empty($this->params)) {
            return $this->_sql;
        }
        $params = [];
        foreach ($this->params as $name => $value) {
            if (is_string($name) && strncmp(':', $name, 1)) {
                $name = ':' . $name;
            }
            if (is_string($value)) {
                $params[$name] = $this->db->quoteValue($value);
            } elseif (is_bool($value)) {
                $params[$name] = ($value ? 'TRUE' : 'FALSE');
            } elseif ($value === null) {
                $params[$name] = 'NULL';
            } elseif (!is_object($value) && !is_resource($value)) {
                $params[$name] = $value;
            }
        }
        if (!isset($params[1])) {
            return strtr($this->_sql, $params);
        }
        $sql = '';
        foreach (explode('?', $this->_sql) as $i => $part) {
            $sql .= (isset($params[$i]) ? $params[$i] : '') . $part;
        }
        return $sql;
    }
    /**
     * Binds pending parameters that were registered via [[bindValue()]] and [[bindValues()]].
     * Note that this method requires an active [[pdoStatement]].
     */
    protected function bindPendingParams()
    {
        foreach ($this->_pendingParams as $name => $value) {
            $this->pdoStatement->bindValue($name, $value[0], $value[1]);
        }
        $this->_pendingParams = [];
    }
    /**
     * Binds a value to a parameter.
     * @param string|integer $name Parameter identifier. For a prepared statement
     * using named placeholders, this will be a parameter name of
     * the form `:name`. For a prepared statement using question mark
     * placeholders, this will be the 1-indexed position of the parameter.
     * @param mixed $value The value to bind to the parameter
     * @param integer $dataType SQL data type of the parameter. If null, the type is determined by the PHP type of the value.
     * @return $this the current command being executed
     * @see http://www.php.net/manual/en/function.PDOStatement-bindValue.php
     */
    public function bindValue($name, $value, $dataType = null)
    {
        if ($dataType === null) {
            $dataType = $this->db->getSchema()->getPdoType($value);
        }
        $this->_pendingParams[$name] = [$value, $dataType];
        $this->params[$name]         = $value;
        return $this;
    }
    /**
     * Binds a list of values to the corresponding parameters.
     * This is similar to [[bindValue()]] except that it binds multiple values at a time.
     * Note that the SQL data type of each value is determined by its PHP type.
     * @param array $values the values to be bound. This must be given in terms of an associative
     * array with array keys being the parameter names, and array values the corresponding parameter values,
     * e.g. `[':name' => 'John', ':age' => 25]`. By default, the PDO type of each value is determined
     * by its PHP type. You may explicitly specify the PDO type by using an array: `[value, type]`,
     * e.g. `[':name' => 'John', ':profile' => [$profile, \PDO::PARAM_LOB]]`.
     * @return $this the current command being executed
     */
    public function bindValues($values)
    {
        if (empty($values)) {
            return $this;
        }
        $schema = $this->db->getSchema();
        foreach ($values as $name => $value) {
            if (is_array($value)) {
                $this->_pendingParams[$name] = $value;
                $this->params[$name]         = $value[0];
            } else {
                $type                        = $schema->getPdoType($value);
                $this->_pendingParams[$name] = [$value, $type];
                $this->params[$name]         = $value;
            }
        }
        return $this;
    }

    public function __construct()
    {
        $config = require yii::getAlias('@common/config/db.php');
        // mysql:host=127.0.0.1;dbname=20220628;port=3306
        list($dri, $dsn) = explode(':', $config['dsn']);
        $requestParam = StringHelper::parseAttr($dsn);
        foreach ($requestParam as $key => $value) {
            list($k, $v) = explode('=', $value);
            $dsnArr[$k] = $v;
        }

        $this->pool = new PdoPool([
            'host' => $dsnArr['host'],
            'port' => $dsnArr['port'],
            'database' => $dsnArr['dbname'],
            'username' => $config['username'],
            'password' => $config['password'],
            'charset' => 'utf8mb4',
            'unixSocket' => null,
            'options' => [],
            'size' => 64,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        $sql = $this->getSql();
        $rawSql = $this->getRawSql();
        Yii::info($rawSql, __METHOD__);
        if ($sql == '') {
            return 0;
        }
        $token = $rawSql;
        try {
            Yii::beginProfile($token, __METHOD__);
            $n = $this->doQuery($rawSql, true, '');
            Yii::endProfile($token, __METHOD__);
            $this->refreshTableSchema();

            return $n;
        } catch (\Exception $e) {
            Yii::endProfile($token, __METHOD__);
            DebugService::backtrace();
            throw $this->db->getSchema()->convertException($e, $rawSql);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function queryInternal($method, $fetchMode = [])
    {
        $rawSql = $this->getRawSql();
        Yii::info($rawSql, 'yii\db\Command::query');
        if ($method !== '') {
            $info = $this->db->getQueryCacheInfo($this->queryCacheDuration, $this->queryCacheDependency);
            if (is_array($info)) {
                /* @var $cache \yii\caching\Cache */
                $cache = $info[0];
                $cacheKey = [
                    __CLASS__,
                    $method,
                    $fetchMode,
                    $this->db->dsn,
                    $this->db->username,
                    $rawSql,
                ];
                $result = $cache->get($cacheKey);
                if (is_array($result) && isset($result[0])) {
                    Yii::trace('Query result served from cache', 'yii\db\Command::query');

                    return $result[0];
                }
            }
        }
        $token = $rawSql;
        $result = null;
        try {
            Yii::beginProfile($token, 'yii\db\Command::query');
            if ($fetchMode === null) {
                $fetchMode = $this->fetchMode;
            }
            $result = $this->doQuery($rawSql, false, $method, $fetchMode);
            Yii::endProfile($token, 'yii\db\Command::query');
        } catch (\Throwable $e) {
            DebugService::backtrace();
            Yii::endProfile($token, 'yii\db\Command::query');
            throw $e;
        }
        if (isset($cache, $cacheKey, $info)) {
            $cache->set($cacheKey, [$result], $info[1], $info[2]);
            Yii::trace('Saved query result in cache', 'yii\db\Command::query');
        }

        return $result;
    }

    /**
     * Execute sql by mysql pool.
     *
     * @TODO support slave
     * @TODO support transaction
     *
     * @param $sql
     * @param bool   $isExecute
     * @param string $method
     * @param null   $fetchMode
     * @param null   $forRead
     *
     * @return mixed
     */
    public function doQuery($sql, $isExecute = false, $method = 'fetch', $fetchMode = null, $forRead = null)
    {
        if ($method) {
            $Res = $this->pool->$method($sql, []);
        } else {
            $Res = $this->pool->fetch($sql, []);
        }

        return $Res;
    }
}
