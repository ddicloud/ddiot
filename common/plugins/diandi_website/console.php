<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-09-16 14:45:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-09-16 14:47:33
 */


namespace common\plugins\diandi_website;

use common\components\addons\AddonsModule;

/**
 * diandi_dingzuo module definition class.
 */
class console extends AddonsModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = "common\plugins\diandi_website\console";

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
    }
}
