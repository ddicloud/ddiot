<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-01-09 03:45:33
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-01-11 02:23:24
 */


namespace common\plugins\diandi_hub;

use common\components\addons\AddonsModule;

/**
 * diandi_dingzuo module definition class.
 */
class console extends AddonsModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = "addons\diandi_hub\console";

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();
    }
}
