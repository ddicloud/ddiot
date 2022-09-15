<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-11 00:34:05
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-09-15 09:09:11
 */

namespace ddswoole\interfaces\servers;

/**
 * swoole服务
 *
 * Interface AddonWidget
 */
interface SwooleInterfaceController
{
    /**
     * 服务默认入口.
     *
     * @return void
     * @date 2022-08-12
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public function actionRun();
}
