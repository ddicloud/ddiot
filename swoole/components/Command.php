<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-08-30 22:54:36
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-31 13:20:41
 */
namespace swooleService\components;

use Yii;
use yii\db\Command as DbCommand;

class Command extends DbCommand
{

    public $retry;

    /**
     * 重新处理一下.
     * @param string $method
     * @param null $fetchMode
     * @return mixed
     * @throws Exception
     */
    protected function queryInternal($method, $fetchMode = null)
    {

        try {
            return parent::queryInternal($method, $fetchMode);
        } catch (\Exception $e) {
            if ($this->handleException($e)) {
                return parent::queryInternal($method, $fetchMode);
            }

            throw $e;
        }
    }

    /**
     * 利用$this->retry属性，标记当前是否是数据库重连
     * 重写bindPendingParams方法，当当前是数据库重连之后重试的时候
     * 调用bindValues方法重新绑定一次参数.
     */

    protected function bindPendingParams()
    {
        if ($this->retry) {
            $this->retry = false;
            $this->bindValues($this->params);
        }
        parent::bindPendingParams();
    }

    /**
     * 处理执行sql时捕获的异常信息
     * 并且根据异常信息来决定是否需要重新连接数据库
     * SQL Error (2013): Lost connection to MySQL server at 'waiting for initial communication packet', system error: 0
     * SQLSTATE[HY000]: General error: 2006 MySQL server has gone away
     * Error while sending QUERY packet. PID=24450 The SQL being executed was
     * 但是实际使用中发现，由于Yii2对数据库异常进行了处理并封装成\yii\db\Exception异常
     * 因此2006错误的错误码并不能在errorInfo中获取到，因此需要判断errorMsg内容
     * @param \Exception $e
     * @return bool true: 需要重新执行sql false: 不需要重新执行sql
     */
    private function handleException(\Exception $e)
    {
        //如果不是yii\db\Exception异常抛出该异常或者不是MySQL server has gone away
        $offset_1 = stripos($e->getMessage(), 'MySQL server has gone away');
        $offset_2 = stripos($e->getMessage(), 'Lost connection to MySQL server');
        $offset_3 = stripos($e->getMessage(), 'Error while sending QUERY packet');

        if (($e instanceof \yii\db\Exception) == true || ($offset_1 || $offset_2 || $offset_3)) {
            $this->retry = true;
            //将pdo设置从null
            $this->pdoStatement = null;
            $this->db->close();
            $this->db->open();
            return true;
            // echo '数据库重新链接';
            // $PoolPdoPool = new DbPool();
            // $config = require yii::getAlias("@common/config/db.php");
            // // mysql:host=127.0.0.1;dbname=20220628;port=3306
            // list($dri, $dsn) = explode(':', $config['dsn']);

            // $requestParam = StringHelper::parseAttr($dsn);
            // foreach ($requestParam as $key => $value) {
            //     list($k, $v) = explode('=', $value);
            //     $dsnArr[$k] = $v;
            // }

            // $PoolPdoPool->setConfig([
            //     'host' => $dsnArr['host'],
            //     'port' => $dsnArr['port'],
            //     'database' => $dsnArr['dbname'],
            //     'username' => $config['username'],
            //     'password' => $config['password'],
            //     'charset' => 'utf8mb4',
            //     'unixSocket' => null,
            //     'options' => [],
            //     'size' => 64,
            // ]);
            // $pool = $PoolPdoPool->getPool();
            // return $pool;
        }
        return false;
    }
}
