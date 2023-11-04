<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-20 22:06:32
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-08 14:51:36
 */

namespace addons\diandi_integral\admin;

use admin\controllers\AController;
use common\helpers\ResultHelper;

/**
 * Default controller for the `diandi_task` module.
 */
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
        return ResultHelper::json(200, '获取成功');
    }
}
