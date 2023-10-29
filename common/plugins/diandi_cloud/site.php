<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-07-18 09:49:34
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-07-17 14:28:03
 */


namespace common\plugins\diandi_cloud;

use common\components\addons\AddonsModule;

/**
 * diandi_cloud module definition class
 */
class site extends AddonsModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'addons\diandi_cloud\backend';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
