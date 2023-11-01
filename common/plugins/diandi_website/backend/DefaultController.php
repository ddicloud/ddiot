<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-09-16 14:45:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-09-23 15:01:29
 */


namespace addons\diandi_website\backend;


use backend\controllers\BaseController;
use common\services\common\AddonsService;

/**
 * Default controller for the `diandi_website` module
 */
class DefaultController extends BaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
   {

        $info = AddonsService::getAddonsInfo("diandi_website");

        return $this->render('index', [
            'info' => $info
        ]);
    }
}
