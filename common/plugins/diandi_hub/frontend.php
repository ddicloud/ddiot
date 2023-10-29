<?php

namespace common\plugins\diandi_hub;

use common\components\addons\AddonsModule;

/**
 * diandi_dingzuo module definition class
 */
class frontend extends AddonsModule
{
    /**
     * {@inheritdoc}frontend
     */
    public $controllerNamespace = 'common\addons\diandi_hub\frontend';

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();
        // custom initialization code goes here
    }
}
