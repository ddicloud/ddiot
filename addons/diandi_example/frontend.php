<?php

namespace addons\diandi_example;

use common\components\addons\AddonsModule;

/**
 * diandi_dingzuo module definition class
 */
class frontend extends AddonsModule
{
    /**
     * {@inheritdoc}frontend
     */
    public $controllerNamespace = 'addons\diandi_example\frontend';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        // custom initialization code goes here
    }
}
