<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-06-08 17:33:49
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-10-25 14:02:47
 */


namespace addons\diandi_example;

use common\components\addons\AddonsModule;

/**
 * diandi_dingzuo module definition class.
 */
class api extends AddonsModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = "addons\diandi_example\api";

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
    }
}
