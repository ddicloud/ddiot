<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-08-30 16:43:08
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-09-05 17:06:29
 */
namespace ddswoole\pool;


class DbPool extends ConnectionPool
{
    /**
     * 数据库池,通过回调来创建链接
     * @var callable
     */
    public $createHandle;
    /**
     * 重建链接的回调
     * @var callable
     */
    public $reConnectHandle;

    public function createConnect()
    {
        if($this->createHandle instanceof \Closure){
            $conn = call_user_func($this->createHandle);
            $this->reConnect($conn);
            return $conn;
        }
    }

    public function reConnect($client)
    {
        if($this->reConnectHandle instanceof \Closure){
            call_user_func($this->reConnectHandle,$client);
        }
    }

}