<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-09-16 14:45:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-09-22 12:30:52
 */


namespace common\plugins\diandi_hub;

use common\components\addons\PluginsModule;

/**
 * diandi_dingzuo module definition class.
 */
class admin extends PluginsModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = "common\plugins\diandi_hub\admin";

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();
    }
}
