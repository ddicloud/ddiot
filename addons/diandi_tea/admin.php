<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-14 10:56:16
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-14 10:56:26
 */


namespace addons\diandi_tea;

use common\components\addons\AddonsModule;

/**
 * diandi_dingzuo module definition class.
 */
class admin extends AddonsModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = "addons\diandi_tea\admin";

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();
    }
}