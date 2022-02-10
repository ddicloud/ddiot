<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-06-08 17:33:49
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-10-25 14:03:10
 */


namespace addons\diandi_example;

use common\components\addons\AddonsModule;

/**
 * diandi_dingzuo module definition class.
 */
class console extends AddonsModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = "addons\diandi_example\console";

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
    }
}
