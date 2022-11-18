<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-08-30 16:43:08
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-11-18 11:31:42
 */
namespace ddswoole\pool;

use common\helpers\loggingHelper;
use yii\base\Component;
use yii\base\InvalidParamException;

class ConnectionManager extends Component
{
    public $poolConfig = [];

    /**
     * 连接池
     * @var ConnectionPool[]
     */
    protected static $poolMap = [];

    /**
     * @param $connectionKey
     * @return null|object
     */
    public function get($connectionKey)
    {
        if (isset(self::$poolMap[$connectionKey])) {
            return $this->getFromPool($connectionKey);
        }
    }

    public function getFromPool($connectionKey)
    {
        $pool = self::$poolMap[$connectionKey];

        $conn = $pool->getConnect();
        return $conn;
    }

    public function getPool($poolKey)
    {
        loggingHelper::writeLog('poolpdo', 'getPool', '全部', [
            'poolMap' => self::$poolMap,
        ]);

        if (!$this->hasPool($poolKey)) {
            return null;
        }

        return self::$poolMap[$poolKey];
    }

    public function hasPool($poolKey)
    {
        return isset(self::$poolMap[$poolKey]);
    }

    public function addPool($poolKey, $pool)
    {
        if ($pool instanceof ConnectionPool) {
            self::$poolMap[$poolKey] = $pool;
        } else {
            throw new InvalidParamException("invalid pool type, poolKey=$poolKey");
        }
    }

    public function releaseConnection($connectionKey, $pool, $connection)
    {
        if (isset(self::$poolMap[$connectionKey])) {
            $poolMap = self::$poolMap[$connectionKey];
            return $poolMap->release($pool, $connection);
        }
    }
}
