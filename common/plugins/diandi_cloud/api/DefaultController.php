<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-20 22:06:32
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-07-18 10:35:12
 */

namespace common\plugins\diandi_cloud\api;

use api\controllers\AController;

class DefaultController extends AController
{
    public $modelClass = '';

    /**
     * Renders the index view for the module.
     *
     * @return string
     */
    public function actionIndex(): array
    {
        global $_GPC;
    }
}
