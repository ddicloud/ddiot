<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-02-21 10:06:15
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-23 18:24:25
 */

namespace swooleService\modules\officialaccount\controllers;

use api\controllers\AController;

/**
 * Default controller for the `wechat` module.
 */
class DefaultController extends AController
{
    /**
     * Renders the index view for the module.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
