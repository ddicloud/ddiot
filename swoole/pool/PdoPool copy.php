<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-08-30 17:27:32
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-09-04 00:32:07
 */

namespace ddswoole\pool;

use diandi\swoole\coroutine\Context;
use RuntimeException;
use Swoole\Coroutine;
use Swoole\Database\PDOConfig;
use Swoole\Database\PDOPool as SwoolePDOPool;

class PdoPool
{
    /**
     * @var array
     */
    protected $_config = [
        'host' => 'localhost',
        'port' => 3306,
        'database' => 'test',
        'username' => 'root',
        'password' => 'root',
        'charset' => 'utf8mb4',
        'unixSocket' => null,
        'options' => [],
        'size' => 64,
    ];

    protected $_pools;

    protected $_poolName;

    protected $_instance;

    public $connected = false;

    public function __construct($config, $poolName = '')
    {
        //设置一个容量为1的通道
        $this->setConfig($config);
        //执行mysql相关 操作
        $return = $this->init();
    }

    public function init()
    {
        if (empty($this->getPools())) {
            $config = $this->getConfig();
            $pools = new SwoolePDOPool(
                (new PDOConfig())
                    ->withHost($config['host'])
                    ->withPort($config['port'])
                    ->withUnixSocket($config['unixSocket'])
                    ->withDbName($config['database'])
                    ->withCharset($config['charset'])
                    ->withUsername($config['username'])
                    ->withPassword($config['password'])
                    ->withOptions($config['options']),
                $config['size']
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

    public function doQuery($sql, $bingId)
    {
        $Connection = $this->getConnection();

        return $Connection->prepare($sql, $bingId);
    }

    public function query($sql, $param = [], $toArray = false)
    {
        $pools = $this->getPools();
        $pdo = $pools->get();
        $statement = $pdo->prepare($sql);
        if (!$statement) {
            throw new RuntimeException('Prepare failed');
        }

        $result = $statement->execute($param);
        if (!$result) {
            throw new RuntimeException('Execute failed');
        }

        $result = $statement->fetchAll();
        echo '查询中4coro '.Coroutine::getcid()." start\n";
        var_dump($result);
        $this->close($pdo);

        Context::setContextDataByKey('456', $result);
        echo '查询结果 '." start\n";

        var_dump($result);
        if (!$toArray) {
            return $result;
        }

        $res1 = [];
        foreach ($result as $k => $v) {
            $res1[] = (array) $v;
        }

        return $res1;
        \go(function () use ($pools,$sql,$param,$toArray) {
            echo '查询中1coro '.$sql." start\n";
            $pdo = $pools->get();
            $statement = $pdo->prepare($sql);
            echo '查询中1-2coro '.Coroutine::getcid()." start\n";
            if (!$statement) {
                throw new RuntimeException('Prepare failed');
            }
            echo '查询中2coro '.Coroutine::getcid()." start\n";

            $result = $statement->execute($param);
            if (!$result) {
                throw new RuntimeException('Execute failed');
            }
            echo '查询中3coro '.Coroutine::getcid()." start\n";

            $result = $statement->fetchAll();
            echo '查询中4coro '.Coroutine::getcid()." start\n";
            var_dump($result);
            $this->close($pdo);

            Context::setContextDataByKey('456', $result);
            echo '查询结果 '." start\n";

            var_dump($result);
            if (!$toArray) {
                return $result;
            }

            $res1 = [];
            foreach ($result as $k => $v) {
                $res1[] = (array) $v;
            }

            return $res1;
        });
    }

    public function fetch($sql, $param = [], $toArray = false)
    {
        echo '查询结果 '." start\n";
        $pools = $this->getPools();
        echo '查询中1coro '.$sql." start\n";
        $pdo = $pools->get();
        $statement = $pdo->prepare($sql);
        echo '查询中1-2coro '.Coroutine::getcid()." start\n";
        if (!$statement) {
            throw new RuntimeException('Prepare failed');
        }
        echo '查询中2coro '.Coroutine::getcid()." start\n";

        $result = $statement->execute($param);
        if (!$result) {
            throw new RuntimeException('Execute failed');
        }
        echo '查询中3coro '.Coroutine::getcid()." start\n";

        $result = $statement->fetchAll();
        echo '查询中4coro '.Coroutine::getcid()." start\n";
        var_dump($result);
        $this->close($pdo);

        Context::setContextDataByKey('456', $result);
        echo '查询结果 '." start\n";

        var_dump($result);
        if (!$toArray) {
            return $result;
        }

        $res1 = [];
        foreach ($result as $k => $v) {
            $res1[] = (array) $v;
        }

        return $res1;
        \go(function () use ($pools,$sql,$param,$toArray) {
            echo '查询中1coro '.$sql." start\n";
            $pdo = $pools->get();
            $statement = $pdo->prepare($sql);
            echo '查询中1-2coro '.Coroutine::getcid()." start\n";
            if (!$statement) {
                throw new RuntimeException('Prepare failed');
            }
            echo '查询中2coro '.Coroutine::getcid()." start\n";

            $result = $statement->execute($param);
            if (!$result) {
                throw new RuntimeException('Execute failed');
            }
            echo '查询中3coro '.Coroutine::getcid()." start\n";

            $result = $statement->fetchAll();
            echo '查询中4coro '.Coroutine::getcid()." start\n";
            var_dump($result);
            $this->close($pdo);

            Context::setContextDataByKey('456', $result);
            echo '查询结果 '." start\n";

            var_dump($result);
            if (!$toArray) {
                return $result;
            }

            $res1 = [];
            foreach ($result as $k => $v) {
                $res1[] = (array) $v;
            }

            return $res1;
        });
    }

    public function fetchAll($sql, $param = [], $toArray = false)
    {
        $pools = $this->getPools();
        echo 'fetchAll-coro '.Coroutine::getcid()." start\n";
        $pdo = $pools->get();
        echo '准备查询';

        $statement = $pdo->prepare($sql);
        echo '结果';
        if (!$statement) {
            throw new RuntimeException('Prepare failed');
        }

        $result = $statement->execute($param);

        if (!$result) {
            throw new RuntimeException('Execute failed');
        }
        $result = $statement->fetchAll();
        $this->close($pdo);
        Context::setContextDataByKey('456', $result);
        if (!$toArray) {
            return $result;
        }

        $res1 = [];
        foreach ($result as $k => $v) {
            $res1[] = (array) $v;
        }

        return $res1;

        \go(function () use ($pools,$sql,$param,$toArray) {
            echo 'fetchAll-coro '.Coroutine::getcid()." start\n";
            $pdo = $pools->get();
            echo '准备查询';

            $statement = $pdo->prepare($sql);
            echo '结果';
            if (!$statement) {
                throw new RuntimeException('Prepare failed');
            }

            $result = $statement->execute($param);

            if (!$result) {
                throw new RuntimeException('Execute failed');
            }
            $result = $statement->fetchAll();
            $this->close($pdo);
            Context::setContextDataByKey('456', $result);
            if (!$toArray) {
                return $result;
            }

            $res1 = [];
            foreach ($result as $k => $v) {
                $res1[] = (array) $v;
            }

            return $res1;
        });
    }

    public function fetchColumn($sql, $param = [], $toArray = false)
    {
        $pools = $this->getPools();
        $res = \go(function () use ($pools,$sql,$param,$toArray) {
            echo 'coro '.Coroutine::getcid()." start\n";
            $pdo = $pools->get();
            $statement = $pdo->prepare($sql);
            if (!$statement) {
                throw new RuntimeException('Prepare failed');
            }

            $result = $statement->execute($param);
            if (!$result) {
                throw new RuntimeException('Execute failed');
            }
            $result = $statement->fetchAll();
            $this->close($pdo);

            Context::setContextDataByKey('456', $result);
            if (!$toArray) {
                return $result;
            }

            $res1 = [];
            foreach ($result as $k => $v) {
                $res1[] = (array) $v;
            }

            return $res1;
        });
    }

    public function escape($string)
    {
        return $string;
    }
}
