<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-02-28 19:47:35
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-09-03 14:22:10
 */


namespace common\plugins\diandi_cloud;

use common\components\addons\AddonsModule;
use common\helpers\loggingHelper;
use Yii;

/**
 * diandi_dingzuo module definition class.
 */
class console extends AddonsModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = "addons\diandi_cloud\console";

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
    }
}
