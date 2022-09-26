<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-08-30 18:16:03
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-09-26 12:30:05
 */

namespace ddswoole\pool;

use RuntimeException;
use Swoole\Database\RedisConfig;
use Swoole\Database\RedisPool as DatabaseRedisPool;
use yii\base\Component;

class RedisPool extends Component
{
    /**
     * @var array
     */
    protected $_config = [
        'hostname' => 'localhost',
        'port' => 3306,
        'database' => 1,
        'timeout' => 1000,
        'password' => '',
        'size' => 100,
    ];

    public $_pools;

    protected $_poolName;

    protected $_instance = [];

    public function __construct($config, $poolName = '')
    {
        //设置一个容量为1的通道
        $config = array_replace_recursive($this->config, $config);
        $this->setConfig($config);
        $this->setPoolName($poolName);
        //执行mysql相关 操作
        $return = $this->init();
    }

    public function init()
    {
        parent::init();
        if (empty($this->getPools())) {
            $config = $this->getConfig();
            $pools = new DatabaseRedisPool((new RedisConfig())
                ->withHost($config['hostname'])
                ->withPort($config['port'])
                ->withAuth('')
                ->withDbIndex($config['database'])
                ->withTimeout(1),
                $this->config['size']
            );
            $this->setPools($pools);
        }
    }

    public function getInstance($poolName)
    {
        $instance = $this->_instance;
        $config = $this->getConfig();
        if (empty($instance[$poolName])) {
            if (empty($config)) {
                throw new RuntimeException('pdo config empty');
            }
            if (empty($config['size'])) {
                throw new RuntimeException('the size of database connection pools cannot be empty');
            }

            $this->_instance[$poolName] = new static($config);
        }

        return  $this->_instance[$poolName];
    }

    public function setInstance($value)
    {
        $this->_instance = $value;
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

    public function fill(): void
    {
        $this->pools->fill();
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
}
