<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-14 10:56:16
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-14 10:56:32
 */


namespace addons\diandi_tea;

use common\components\addons\AddonsModule;

/**
 * diandi_dingzuo module definition class.
 */
class console extends AddonsModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = "addons\diandi_tea\console";

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();
    }
}
