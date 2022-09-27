<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-08-30 21:27:46
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-09-27 18:59:09
 */

declare(strict_types=1);

namespace ddswoole\db\mysql;

use common\helpers\ArrayHelper;
use ddswoole\pool\ResultData;
use ddswoole\servers\DebugService;
use PDO;
use PDOStatement;
use phpDocumentor\Reflection\Types\Mixed_;
use RuntimeException;

/**
 * This class extends PDOStatement but overrides all of its methods. It does
 * this so that instanceof check and type-hinting of existing code will work
 * seamlessly.
 */
class PoolPDOStatement extends PDOStatement
{
    protected $statement;

    /**
     * PDO Oci8 driver.
     *
     * @var PoolPDO
     */
    protected $pdo;

    /**
     * Statement options.
     *
     * @var array
     */
    protected $options = [];

    /**
     * Default fetch mode for this statement.
     *
     * @var integer
     */
    private $_fetchMode = null;

    /**
     * @var ResultData
     */
    private $_resultData = null;

    private $_boundColumns = [];

    private $_index = 0;

    private $data = [];

    private $sql = '';

    /**
     * PoolPDOStatement constructor.
     *
     * @param string $statement the SQL statement
     * @param array  $options   Options for the statement handle
     */
    public function __construct(string $statement, PoolPDO $pdo, $options)
    {
        $this->statement = $statement;
        $this->pdo = $pdo;
        $this->options = $options;
    }

    /**
     * {@inheritdoc}
     */
    public function __destruct()
    {
        unset($this->_resultData, $this->_boundColumns, $this->statement);
    }

    public function setQueryString($queryString)
    {
        $this->sql = $queryString;
    }

    #[\ReturnTypeWillChange]
    public function bindValue($parameter, $value, $data_type = PDO::PARAM_STR): bool
    {
        $this->params[$parameter] = $value;

        return true;
    }

    #[\ReturnTypeWillChange]
    public function execute($input_parameters = []): bool
    {
        try {
            $client = $this->pdo->getClient();
            $statement = $client->prepare($this->getRawSql());
            $result = $statement->execute($input_parameters);
            if (!$statement) {
                throw new RuntimeException('Prepare failed');
            }
            $result = $statement->fetchAll();
            $this->data = $result;
            // $this->affected_rows = $client->affected_rows;
            if ($this->data === false && $client->error != null) {
                throw new \PDOException($client->error, $client->errno);
            }
        } finally {
            DebugService::consoleWrite('释放连接',[
                'inTransaction'=>$this->pdo->inTransaction()
            ]);
            if (!$this->pdo->inTransaction()) {
                $this->pdo->releaseConnect();
            }
        }

        return is_array($this->data);
    }

    /**
     * swoole并不支持select返回影响数据行
     * Returns the number of rows affected by the last SQL statement.
     *
     * @see https://php.net/manual/en/pdostatement.rowcount.php
     *
     * @return int the number of rows.
     */
    #[\ReturnTypeWillChange]
    public function rowCount()
    {
        if (is_array($this->data)) {
            return count($this->data);
        }

        return $this->affected_rows;
    }

    #[\ReturnTypeWillChange]
    public function closeCursor(): bool
    {
        return true;
    }

    #[\ReturnTypeWillChange]
    public function bindParam($parameter, &$variable, $data_type = PDO::PARAM_STR, $length = null, $driver_options = null): bool
    {
        $PDOStatement = new PDOStatement();
        $PDOStatement->bindParam($parameter, $variable, $data_type, $length, $driver_options); // TODO: Change the autogenerated stub

        return true;
    }

    /**
     * Returns the raw SQL by inserting parameter values into the corresponding placeholders in [[sql]].
     * Note that the return value of this method should mainly be used for logging purpose.
     * It is likely that this method returns an invalid SQL due to improper replacement of parameter placeholders.
     *
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
                $name = ':'.$name;
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
            $sql .= (isset($params[$i]) ? $params[$i] : '').$part;
        }

        return $sql;
    }

    /**
     * 生效于queryOne.
     *
     * @param null $fetch_style
     * @param int  $cursor_orientation
     * @param int  $cursor_offset
     *
     * @return bool|mixed
     */
    #[\ReturnTypeWillChange]
    public function fetch($fetch_style = null, $cursor_orientation = \PDO::FETCH_ORI_NEXT, $cursor_offset = 0)
    {
        if (empty($this->data)) {
            return false;
        }
        
        return $this->data[$this->_index] ?? false;
    }

    #[\ReturnTypeWillChange]
    // public function  fetchAll(int $fetch_style = PDO::FETCH_DEFAULT, mixed ...$args): array
    public function fetchAll($fetch_style = PDO::FETCH_COLUMN, $class_name = null, $ctor_args = null): array
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
     * @param int $column_number
     *
     * @return bool|mixed
     */
    #[\ReturnTypeWillChange]
    public function fetchColumn($column_number = 0)
    {
        if (empty($this->data)) {
            return null;
        }
        // $data = $this->data[++$this->_index];
        $data = $this->data[$this->_index];
        
        return current(array_slice($data, $column_number, 1));
    }
}
