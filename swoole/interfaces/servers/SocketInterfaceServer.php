<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-11 00:34:05
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-09-15 07:46:33
 */

namespace ddswoole\interfaces\servers;

use Swoole\Http\Request;
use Swoole\Http\Response;

/**
 * swoole服务
 *
 * Interface AddonWidget
 */
interface SocketInterfaceServer extends BaseInterfaceServer
{
    public function addlistenerPort($channel);

    /**
     * 心跳处理.
     *
     * @param [type] $ws
     * @param [type] $message
     *
     * @return void
     * @date 2022-09-05
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public function heartbeat($ws, $message);

    /**
     * 响应消息处理.
     *
     * @return void
     * @date 2022-09-02
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public function messageReturn(Request $request, Response $ws, $message, $channel);

    /**
     * 上下文处理.
     *
     * @param [type] $type 0：websocket 1tcp或其他
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
    public function ContextInit($type);

    public function checkUpgrade(Request $request, Response $ws);
}
