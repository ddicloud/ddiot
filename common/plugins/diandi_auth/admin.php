<?php

namespace common\plugins\diandi_auth;

use common\components\addons\PluginsModule;

/**
 * diandi_dingzuo module definition class.
 */
class admin extends PluginsModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = "common\plugins\diandi_auth\admin";

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();
    }
}