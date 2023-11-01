<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-09-16 14:45:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-09-16 14:47:19
 */


namespace addons\diandi_website;


use common\components\addons\PluginsModule;

/**
 * diandi_dingzuo module definition class.
 */
class admin extends PluginsModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = "addons\diandi_website\admin";

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();
    }
}
