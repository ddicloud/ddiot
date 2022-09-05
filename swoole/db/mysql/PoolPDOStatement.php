<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-08-30 21:27:46
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-09-05 21:02:18
 */

namespace ddswoole\db\mysql;

use common\helpers\ArrayHelper;
use ddswoole\pool\ResultData;
use PDO;
use PDOException;
use PDOStatement;

/**
 *
 *
 * This class extends PDOStatement but overrides all of its methods. It does
 * this so that instanceof check and type-hinting of existing code will work
 * seamlessly.
 */
class PoolPDOStatement extends \PDOStatement
{
    protected $statement;

    /**
     * PDO Oci8 driver
     *
     * @var PoolPDO
     */
    protected $pdo;

    /**
     * Statement options
     *
     * @var array
     */
    protected $options = array();

    /**
     * Default fetch mode for this statement
     * @var integer
     */
    private $_fetchMode = null;

    /**
     * @var ResultData
     */
    private $_resultData = null;

    private $_boundColumns = [];

    private $_index = 0;

    /**
     * PoolPDOStatement constructor.
     * @param string $statement the SQL statement
     * @param PoolPDO $pdo
     * @param array $options Options for the statement handle
     */
    public function __construct(string $statement, PoolPDO $pdo, $options)
    {
        $this->statement = $statement;
        $this->pdo = $pdo;
        $this->options = $options;
    }

    /**
     * @inheritdoc
     */
    public function __destruct()
    {
        unset($this->_resultData, $this->_boundColumns, $this->statement);
    }

    public function setQueryString($queryString)
    {
        $this->sql = $queryString;
    }

    public function bindValue($parameter, $value, $data_type = PDO::PARAM_STR)
    {
        $this->params[$parameter] = $value;
    }

    public function execute($input_parameters = null)
    {
        try {
            $client = $this->pdo->getClient();
            $this->data = $client->query($this->getRawSql());
            $this->affected_rows = $client->affected_rows;
            if ($this->data === false && $client->error != null) {
                throw new \PDOException($client->error, $client->errno);
            }
        } finally {
            if (!$this->pdo->inTransaction()) {
                $this->pdo->releaseConnect();
            }
        }
        return is_array($this->data);
    }

    /**
     * swoole并不支持select返回影响数据行
     * Returns the number of rows affected by the last SQL statement
     * @link https://php.net/manual/en/pdostatement.rowcount.php
     * @return int the number of rows.
     */
    public function rowCount()
    {
        if (is_array($this->data)) {
            return count($this->data);
        }
        return $this->affected_rows;
    }

    public function closeCursor()
    {
        return true;
    }

    public function bindParam($parameter, &$variable, $data_type = PDO::PARAM_STR, $length = null, $driver_options = null)
    {
        parent::bindParam($parameter, $variable, $data_type, $length, $driver_options); // TODO: Change the autogenerated stub
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
            return $this->sql;
        }
        $params = [];
        foreach ($this->params as $name => $value) {
            if (is_string($name) && strncmp(':', $name, 1)) {
                $name = ':' . $name;
            }
            if (is_string($value)) {
                $params[$name] = $this->pdo->quote($value);
            } elseif (is_bool($value)) {
                $params[$name] = ($value ? 'TRUE' : 'FALSE');
            } elseif ($value === null) {
                $params[$name] = 'NULL';
            } elseif (!is_object($value) && !is_resource($value)) {
                $params[$name] = $value;
            }
        }
        if (!isset($params[1])) {
            return strtr($this->sql, $params);
        }
        $sql = '';
        foreach (explode('?', $this->sql) as $i => $part) {
            $sql .= (isset($params[$i]) ? $params[$i] : '') . $part;
        }

        return $sql;
    }

    /**
     * 生效于queryOne
     * @param null $fetch_style
     * @param int $cursor_orientation
     * @param int $cursor_offset
     * @return bool|mixed
     */
    public function fetch($fetch_style = null, $cursor_orientation = \PDO::FETCH_ORI_NEXT, $cursor_offset = 0)
    {
        if (empty($this->data)) {
            return false;
        }
        return $this->data[++$this->_index] ?? false;
    }

    public function fetchAll($fetch_style = null, $fetch_argument = null, $ctor_args = array())
    {
        if (empty($this->data)) {
            return [];
        }
        if ($fetch_style == PDO::FETCH_COLUMN) {
            $key = key($this->data[0]);
            return ArrayHelper::getColumn($this->data, $key);
        }
        return $this->data;
    }

    /**
     *
     * @param int $column_number
     * @return bool|mixed
     */
    public function fetchColumn($column_number = 0)
    {
        if (empty($this->data)) {
            return null;
        }
        $data = $this->data[++$this->_index];
        return current(array_slice($data, $column_number, 1));
    }
}
