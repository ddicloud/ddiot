<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-26 00:09:42
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-24 00:31:33
 */


namespace addons\diandi_integral;

use common\components\addons\AddonsModule;
use common\helpers\ResultHelper;
use Yii;
use yii\web\HttpException;

/**
 * diandi_dingzuo module definition class
 */
class site extends AddonsModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'addons\diandi_integral\backend';

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
