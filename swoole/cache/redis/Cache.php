<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-09-24 11:56:17
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-09-24 11:56:52
 */

namespace ddswoole\cache\redis;

class Cache extends \yii\redis\Cache
{
    /**
     * {@inheritdoc}
     */
    protected function setValue($key, $value, $expire)
    {
        if ($expire == 0) {
            return (bool) $this->redis->executeCommand('SET', [$key, $value]);
        } else {
            return (bool) $this->redis->executeCommand('SETEX', [$key, $expire, $value]);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function addValue($key, $value, $expire)
    {
        if ($expire == 0) {
            return (bool) $this->redis->executeCommand('SETNX', [$key, $value]);
        } else {
            return (bool) $this->redis->executeCommand('SET', [$key, $value, ['NX', 'EX' => $expire]]);
        }
    }
}
