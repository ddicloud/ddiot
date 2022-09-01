<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-08-30 17:04:49
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-31 23:26:18
 */

namespace ddswoole\db;

use ddswoole\bootstrap\YiiWeb;
use ddswoole\db\mysql\Schema;
use ddswoole\web\Application;
use Yii;
use yii\base\BaseObject;
use yii\base\NotSupportedException;

/**
 * Class Connection
 * @package ddswoole\db
 */
class Connection extends \yii\db\Connection
{
    public $commandClass = 'ddswoole\db\Command';

    public $pdoClass = 'ddswoole\db\mysql\PoolPdo';

    public $enableSchemaCache = true;

    public $schemaMap = [
        'pgsql' => 'yii\db\pgsql\Schema', // PostgreSQL
        'mysqli' => 'yii\db\mysql\Schema', // MySQL
        'mysql' => 'ddswoole\db\mysql\Schema', // MySQL
        'sqlite' => 'yii\db\sqlite\Schema', // sqlite 3
        'sqlite2' => 'yii\db\sqlite\Schema', // sqlite 2
        'sqlsrv' => 'yii\db\mssql\Schema', // newer MSSQL driver on MS Windows hosts
        'oci' => 'yii\db\oci\Schema', // Oracle driver
        'mssql' => 'yii\db\mssql\Schema', // older MSSQL driver on MS Windows hosts
        'dblib' => 'yii\db\mssql\Schema', // dblib drivers on GNU/Linux (and maybe other OSes) hosts
        'cubrid' => 'yii\db\cubrid\Schema', // CUBRID
    ];

    public $enableReloadSchema = true;

    private static $isSchemaLoaded = false;

    public function init()
    {
        if (!empty($this->charset)) {
            $this->charset = null;
        }
    }

    /**
     * It work when you init mysql schema before handle request
     * ```php
     *   'on beforeRequest' => function ($event){
     *      //当Application初始化的时候，生成 MysqlSchemas,
     *      //防止Mysql子协程挂起
     *       $app = $event->sender;
     *       $app->getDb()->initSchema();
     *    }
     * ```
     * @see YiiWeb::onYiiEvent()
     * @see https://wiki.swoole.com/wiki/page/p-coroutine.html
     * @var bool
     */
    public function initSchema()
    {
        if (!static::$isSchemaLoaded) {
            $this->getSchema()->getTableSchemas();
            static::$isSchemaLoaded = true;
        }
    }

    /**
     * @var Schema the database schema
     */
    private $_schema;

    /**
     * @inheritdoc
     */
    public function getSchema()
    {
        if ($this->_schema !== null) {
            return $this->_schema;
        } else {
            $driver = $this->getDriverName();
            if (isset($this->schemaMap[$driver])) {
                $config = !is_array($this->schemaMap[$driver]) ? ['class' => $this->schemaMap[$driver]] : $this->schemaMap[$driver];
                $config['db'] = $this->getComponentId($this);

                return $this->_schema = Yii::createObject($config);
            } else {
                throw new NotSupportedException("Connection does not support reading schema information for '$driver' DBMS.");
            }
        }
    }

    /**
     * find the Component Id
     * @param \yii\base\Object $object
     * @return bool|int|string
     */
    protected function getComponentId(BaseObject $object)
    {
        $components = Yii::$app->getComponents(false);
        foreach ($components as $id => $component) {
            if ($object === $component) {
                return $id;
            }
        }
        return false;
    }
}
