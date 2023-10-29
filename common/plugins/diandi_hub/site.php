<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-07-18 23:27:14
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-04-07 22:31:48
 */
 

namespace common\plugins\diandi_hub;
use common\components\addons\AddonsModule;
use Yii;

/**
 * site module definition class
 */
class site extends AddonsModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'addons\diandi_hub\backend';

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
     
        parent::init();
     
        // custom initialization code goes here
    }
}
