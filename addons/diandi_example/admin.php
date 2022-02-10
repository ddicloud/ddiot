<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-09-16 14:45:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-09-22 12:31:18
 */


namespace addons\diandi_example;

use common\components\addons\AddonsModule;

/**
 * diandi_dingzuo module definition class.
 */
class admin extends AddonsModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = "addons\diandi_example\admin";

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
    }
}
