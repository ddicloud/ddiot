<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-07-30 16:46:10
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-09-03 14:12:25
 */


namespace addons\diandi_integral;

use common\components\addons\AddonsModule;
use common\helpers\ResultHelper;
use yii\web\HttpException;

/**
 * diandi_dingzuo module definition class.
 */
class console extends AddonsModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = "addons\diandi_integral\console";

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        try {
            parent::init();
        } catch (HttpException $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        }
    }
}
