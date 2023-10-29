<?php

namespace common\plugins\diandi_cloud;

use common\components\addons\AddonsModule;

/**
 * diandi_dingzuo module definition class
 */
class frontend extends AddonsModule
{
    /**
     * {@inheritdoc}frontend
     */
    public $controllerNamespace = 'addons\diandi_cloud\frontend';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        // custom initialization code goes here
    }
}
