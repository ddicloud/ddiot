<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-11 00:34:05
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-09-03 08:17:42
 */

namespace ddswoole\interfaces;
use Swoole\Http\Request;
use Swoole\Http\Response;


/**
 * swoole服务
 *
 * Interface AddonWidget
 */
interface SocketServer
{
    
    public function handles(Request $request, Response $ws);

    public function addlistenerPort($channel);

    /**
     * 响应消息处理
     * @param Type|null $var
     * @return void
     * @date 2022-09-02
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public function messageReturn(Request $request, Response $ws,$message,$channel);

}
