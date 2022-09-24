<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-08-30 18:16:03
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-09-24 09:45:23
 */

declare(strict_types=1);

namespace ddswoole\pool;

use RuntimeException;
use Swoole\Database\RedisConfig;
use Swoole\Database\RedisPool as SwooleRedisPool;
use yii\base\Component;

class RedisPool extends Component
{
    protected $_config = [
        'host' => 'localhost',
        'port' => 6379,
        'auth' => '',
        'db_index' => 0,
        'time_out' => 1,
        'size' => 64,
    ];

    protected $_pools;

    protected $_poolName;

    private static $_instance = [];

    public function init()
    {
        if (empty($this->getPools())) {
            $pools = new SwooleRedisPool(
                (new RedisConfig())
                    ->withHost($this->config['host'])
                    ->withPort($this->config['port'])
                    ->withAuth($this->config['auth'])
                    ->withDbIndex($this->config['db_index'])
                    ->withTimeout($this->config['time_out']),
                $this->config['size']
            );

            $this->setPools($pools);
        }
    }

    public function getInstance()
    {
        $instance = $this->_instance;
        $poolName = $this->getPoolName();
        $config = $this->getConfig();
        if (empty($instance[$poolName])) {
            if (empty($config)) {
                throw new RuntimeException('redis config empty');
            }
            if (empty($config['size'])) {
                throw new RuntimeException('the size of redis connection pools cannot be empty');
            }
            $instance[$poolName] = new static($config);
        }

        return $instance[$poolName];
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
        $this->_pools->fill();
    }
}
