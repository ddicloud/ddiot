<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-14 10:56:16
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-08 10:21:56
 */

namespace addons\diandi_tea\api;

use addons\diandi_tea\services\NotifyService;
use api\controllers\AController;
use common\helpers\ResultHelper;
use Yii;

class NotifyController extends AController
{
    public $modelClass = '';

    /**
     * @SWG\Post(path="/diandi_tea/notify/notify",
     *    tags={"现金支付"},
     *    summary="现金支付零元",
     *     @SWG\Response(
     *         response = 200,
     *         description = "现金支付零元",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="out_trade_no",
     *     type="string",
     *     description="订单编号",
     *     required=true,
     *   ),
     * )
     */
    public function actionNotify(): ?array
   {
        $data = \Yii::$app->request->input();
        if(empty($data['out_trade_no'])){
            return ResultHelper::json(401, '缺少订单id');
        }
        //手动回调
        $data['is_auto'] = 1;
        
        return NotifyService::Notify($data);
    }
}
