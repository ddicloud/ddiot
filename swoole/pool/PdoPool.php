<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-08-30 17:27:32
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-31 13:12:40
 */
namespace swooleService\pool;

use RuntimeException;
use Swoole\Database\PDOConfig;
use Swoole\Database\PDOPool as SwoolePDOPool;
use yii\base\Component;

class PdoPool extends Component
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

    public function init()
    {
        if (empty($this->getPools())) {
            $pools = new SwoolePDOPool(
                (new PDOConfig())
                    ->withHost($this->config['host'])
                    ->withPort($this->config['port'])
                    // ->withUnixSocket($this->config['unixSocket'])
                    ->withDbName($this->config['database'])
                    ->withCharset($this->config['charset'])
                    ->withUsername($this->config['username'])
                    ->withPassword($this->config['password'])
                    ->withOptions($this->config['options']),
                $this->config['size']
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

            $instance = new static();
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

}
