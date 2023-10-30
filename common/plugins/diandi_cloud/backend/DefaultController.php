<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-06-08 17:34:08
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-11-25 10:48:15
 */

namespace common\plugins\diandi_cloud\backend;

use common\plugins\diandi_cloud\services\BoxServIce;
use backend\controllers\BaseController;
use common\services\common\AddonsService;

/**
 * Default controller for the `diandi_cloud` module.
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

        $info = AddonsService::getAddonsInfo('diandi_cloud');

        $str = str_replace('_:_', ':', $str);
        $ss = json_decode($str,true);
        $sss = json_decode($ss, true);
        // $s = BoxServIce::objectToarray($ss);
        print_r($sss);
        // foreach ($ss as $key => $value) {
        //     print_r($value);
        // }
        die;

        return $this->render('index', [
        'info' => $info,
    ]);
    }
}