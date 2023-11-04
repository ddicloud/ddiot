<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-26 00:09:42
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-01 13:09:12
 */

namespace addons\diandi_integral;


use common\components\addons\AddonsModule;
use common\helpers\ResultHelper;
use yii\web\HttpException;

/**
 * diandi_dingzuo module definition class
 */
class frontend extends AddonsModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'addons\diandi_integral\frontend';

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
        // custom initialization code goes here
    }
}
