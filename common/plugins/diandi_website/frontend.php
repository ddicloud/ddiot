<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-09-16 14:45:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-09-16 14:47:36
 */


namespace addons\diandi_website;

use common\components\addons\PluginsModule;

/**
 * diandi_dingzuo module definition class
 */
class frontend extends PluginsModule
{
    /**
     * {@inheritdoc}frontend
     */
    public $controllerNamespace = 'addons\diandi_website\frontend';

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();
        // custom initialization code goes here
    }
}
