<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-09-16 14:45:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-09-22 12:25:44
 */


namespace addons\diandi_integral;

use common\components\addons\AddonsModule;
use common\helpers\ResultHelper;
use yii\web\HttpException;

/**
 * diandi_dingzuo module definition class.
 */
class admin extends AddonsModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = "addons\diandi_integral\admin";

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();
    }
}
