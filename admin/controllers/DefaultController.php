<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-20 22:06:32
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-07-22 11:01:28
 */

namespace admin\controllers;

use common\helpers\ResultHelper;

class DefaultController extends AController
{
    public $modelClass = '';

    /**
     * Renders the index view for the module.
     *
     * @return array
     */
    public function actionIndex(): array
    {

        return ResultHelper::json(200,'获取成功');

    }
}
