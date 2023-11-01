<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-25 09:30:33
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-22 14:17:39
 */

namespace common\plugins\diandi_hub\admin;


use admin\controllers\AController;
use common\helpers\ResultHelper;
use common\services\common\AddonsService;
use yii\web\Response;

/**
 * @SWG\Swagger(
 *     schemes={"https"},
 *     host="www.wayfiretech.com",
 *     basePath="/admin/diandi_hub/",
 *     produces={"application/json"},
 *     consumes={"application/x-www-form-urlencoded"},
 *     @SWG\Info(
 *          version="1.0", title="应用中心",
 *          description="应用中心 - 后台",
 *          @SWG\Contact(name="Radish", email="minradish@163.com")
 *     ),
 *     @SWG\Parameter(in="header", name="store-id", type="string", description="商户ID", required=true),
 *     @SWG\Parameter(in="header", name="bloc-id", type="string", description="公司ID", required=true),
 *     @SWG\Parameter(in="header", name="refresh_token", type="string", description="刷新token令牌", required=true),
 *     @SWG\Parameter(in="header", description="用户access-token", name="access-token", type="string", required=false)
 * )
 */

/**
 * DefaultController
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class DefaultController extends AController
{

    // public $layout = "@backend/views/layouts/plugins-base";
    /**
     * Action index
     */
    public function actionIndex()
   {

        $info = AddonsService::getAddonsInfo('diandi_hub');
        // $out_refund_no =  'Ref2021011797101559';
        // AftersaleService::rundAccountOrder($out_refund_no);
        // $nickname = GoodsTypeStatus::GIFT;
        // p($nickname);
        return ResultHelper::json(200,'获取成功',[
            'info' => $info
        ]);
    }
}
