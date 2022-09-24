<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-09-24 11:56:17
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-09-24 12:00:39
 */

namespace ddswoole\cache\redis;

use ddswoole\cache\session\SessionTrait;
use Yii;
use yii\base\InvalidConfigException;

class Session extends \yii\redis\Session
{
    use SessionTrait;

    /**
     * Initializes the redis Session component.
     * This method will initialize the [[redis]] property to make sure it refers to a valid redis connection.
     *
     * @throws InvalidConfigException if [[redis]] is invalid.
     */
    public function init()
    {
        if (is_string($this->redis)) {
            $this->redis = Yii::$app->get($this->redis);
        } elseif (is_array($this->redis)) {
            if (!isset($this->redis['class'])) {
                $this->redis['class'] = Connection::className();
            }
            $this->redis = Yii::createObject($this->redis);
        }
        if (!$this->redis instanceof Connection) {
            throw new InvalidConfigException('Session::redis must be either a Redis connection instance or the application component ID of a Redis connection.');
        }
        if ($this->keyPrefix === null) {
            $this->keyPrefix = substr(md5(Yii::$app->id), 0, 5);
        }
        //parent::init();
        if ($this->getIsActive()) {
            Yii::warning('Session is already started', __METHOD__);
            $this->updateFlashCounters();
        }
    }

    /**
     * Session write handler.
     * Do not call this method directly.
     *
     * @param string $id   session ID
     * @param string $data session data
     *
     * @return bool whether session write is successful
     */
    public function writeSession($id, $data)
    {
        return (bool) $this->redis->executeCommand('SETEX', [$this->calculateKey($id), $this->getTimeout(), $data]);
    }
}
