<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-08-17 09:25:45
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-09-07 11:27:34
 */

namespace ddswoole\components\tcp;

use ddswoole\interfaces\InteractsWithSwooleTable;
use diandi\swoole\tcp\server\TcpServer as ServerTcpServer;
use diandi\swoole\web\Application;
use Swoole\Coroutine\Server\Connection;

class TcpServer extends ServerTcpServer
{

    use InteractsWithSwooleTable;

    public $onWorkStartCallable;

    private $application;

    private $config;

    public $ssl = false;

    /**
     * 重新实例化application.
     *
     * @param [type] $config
     * @param [type] $callable
     * @date 2022-09-02
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public function __construct($config, $callable)
    {
        parent::__construct($config);
        $this->onWorkStartCallable = $callable;
        $this->config = $config['app'];
    }

    public function run()
    {
        $this->application = new Application($this->config);
        if (!empty($this->tables) && is_array($this->tables)) {
            $this->prepareTables($this->tables);
        }
    }

    /**
     * 上下文初始化.
     *
     * @param [type] $type
     *
     * @return void
     * @date 2022-09-05
     *
     * @example
     *
     * @author Li Jinfang
     *
     * @since
     */
    public function ContextInit($type)
    {
        // code...
    }

    // 系统校验后自己处理
    public function messageReturn(Connection $conn)
    {

    }

}
