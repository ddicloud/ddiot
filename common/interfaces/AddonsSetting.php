<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-10-27 14:37:04
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-04-24 00:04:32
 */
 

namespace common\interfaces;

/**
 * 插件模块设置接口
 *
 * Interface AddonsSetting
 * @package common\interfaces
 */
interface AddonsSetting
{
    /**
     * 默认设置方法
     *
     * @return mixed
     */
    public function actionDisplay();
}