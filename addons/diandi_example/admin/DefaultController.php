<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-20 22:06:32
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-08 14:50:42
 */

namespace addons\diandi_example\admin;

use admin\controllers\AController;

/**
 * Default controller for the `diandi_task` module.
 */
class DefaultController extends AController
{
    public $modelClass = '';

    /**
     * Renders the index view for the module.
     *
     * @return string
     */
    public function actionIndex()
    {
        global $_GPC;
    }
}
