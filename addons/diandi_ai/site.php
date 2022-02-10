<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-09-19 10:01:36
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-31 23:59:29
 */

namespace addons\diandi_ai;

use common\components\addons\AddonsModule;
use Yii;

/**
 * diandi_ai module definition class.
 */
class site extends AddonsModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'addons\diandi_ai\backend';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        Yii::$app->params['aierror'] = require __DIR__.'/config/ErrorCode.php';
        // custom initialization code goes here
    }
}
