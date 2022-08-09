<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-09-19 08:47:51
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-03-24 21:16:43
 */

namespace addons\diandi_ai\backend;

use backend\controllers\BaseController;
use common\services\common\AddonsService;
use Yii;

/**
 * Default controller for the `diandi_ai` module.
 */
class DefaultController extends BaseController
{
    /**
     * Renders the index view for the module.
     *
     * @return string
     */
    public function actionIndex()
    {
        global $_GPC;
        
        $info = AddonsService::getAddonsInfo('diandi_ai');

        return $this->render('index', [
        'info' => $info,
    ]);
    }
}
