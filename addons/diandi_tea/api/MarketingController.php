<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-14 10:56:16
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-08 14:26:45
 */

namespace addons\diandi_tea\api;

use addons\diandi_tea\services\MarketingService;
use api\controllers\AController;
use common\helpers\ResultHelper;
use Yii;

class MarketingController extends AController
{
    public $modelClass = '';

    /**
     * @SWG\Get(path="/diandi_tea/marketing/coupondetail",
     *    tags={"推广活动"},
     *    summary="卡券详情",
     *     @SWG\Response(
     *         response = 200,
     *         description = "卡券详情",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="coupon_id",
     *     type="string",
     *     description="卡券id",
     *     required=true,
     *   ),
     * )
     */
    public function actionCouponDetail(): array
   {
        $coupon_id =\Yii::$app->request->input('coupon_id')??0;
        if(empty($coupon_id)) return ResultHelper::json(401, '缺少卡券id');
        $info = MarketingService::couponDetail($coupon_id);
        
        return ResultHelper::json(200, '获取成功',$info);
    }
}
