<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-07-18 09:49:25
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-06-13 09:26:06
 */


namespace addons\diandi_integral\api;

use common\helpers\ResultHelper;
use yii\web\Controller;

/**
 * Default controller for the `DiandiShop` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return array
     */
    public function actionIndex(): array
    {
        return ResultHelper::json(200, '获取成功');
    }
}
