<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-08-30 17:27:32
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-09-01 00:46:50
 */
namespace ddswoole\pool;

use RuntimeException;
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

    public function __construct($config)
    {
        $this->setConfig($config);
        $this->init();
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

    public function fetchAll($sql, $bingId)
    {
        $pdo = $this->getConnection();
        $statement = $pdo->prepare($sql);

        if (!$statement) {
            throw new RuntimeException('Prepare failed');
        }
        $a = mt_rand(1, 100);
        $b = mt_rand(1, 100);
        $result = $statement->execute([$a, $b]);
        if (!$result) {
            throw new RuntimeException('Execute failed');
        }
        $result = $statement->fetchAll();

        $this->close($pdo);

        return $result;
    }

}
