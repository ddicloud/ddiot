<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-09-15 07:42:38
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-09-15 16:19:00
 */

namespace ddswoole\interfaces\servers;

use Swoole\Http\Request;
use Swoole\Http\Response;

/**
 * swoole服务
 *
 * Interface AddonWidget
 */
interface BaseInterfaceServer
{
    public function run();

    public function destory(Request $request, Response $ws);
}
