<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-04-27 03:13:51
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-22 14:07:29
 */

namespace common\plugins\diandi_hub\admin\statistics;

use admin\controllers\AController;

/**
 * 订单统计
 */
class OrderController extends AController
{
    public string $modelSearchName = 'HubAccountStorePayListSearch';

    public function actionIndex()
    {
        return $this->render('index');
    }
}
