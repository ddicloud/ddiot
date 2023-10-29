<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-04-27 03:13:51
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-07-18 22:18:47
 */

namespace common\plugins\diandi_hub\backend\statistics;

use Yii;
use backend\controllers\BaseController;

/**
 * 收益统计
 */
class MoneyController extends BaseController
{
    public $modelSearchName = "HubAccountStorePayListSearch";

    public function actionIndex()
    {
        return $this->render('index');
    }
}
