<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-14 10:56:16
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-20 10:30:44
 */

namespace addons\diandi_tea\api;

use addons\diandi_tea\services\TimingWorkService;
use api\controllers\AController;

class TimingWorkController extends AController
{
    protected array $authOptional = ['cancel-order', 'finish-order'];

    public $modelClass = '';

    //取消订单轮训
    public function actionCancelOrder(): array
    {
        $info = TimingWorkService::cancelOrder();

        return ['info' => $info];
    }

    //轮询完成订单
    public function actionFinishOrder(): array
    {
        $info = TimingWorkService::finishOrder();

        return ['info' => $info];
    }
}
