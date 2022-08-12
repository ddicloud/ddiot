<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-11 00:34:05
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-12 13:31:32
 */


namespace common\interfaces;

/**
 * swoole服务
 *
 * Interface AddonWidget
 * @package common\interfaces
 */
interface SwooleServer
{
    /**
     * 服务默认入口
     * @return void
     * @date 2022-08-12
     * @example
     * @author Wang Chunsheng
     * @since
     */    
    public function actionRun();

    
}