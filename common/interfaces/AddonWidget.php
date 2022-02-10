<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-11 00:34:05
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-27 22:59:21
 */


namespace common\interfaces;

/**
 * 小工具接口
 *
 * Interface AddonWidget
 * @package common\interfaces
 */
interface AddonWidget
{
    /**
     * 运行方法
     *
     * @param $params
     * @return mixed
     */
    public function run($params);
}