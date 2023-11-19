<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-14 10:56:16
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-27 20:34:47
 */

namespace addons\diandi_tea\api;

use addons\diandi_tea\services\IndexService;
use api\controllers\AController;
use common\helpers\ResultHelper;
use Exception;
use Yii;

class IndexController extends AController
{
    public $modelClass = '';

    protected array $authOptional = ['top', 'sms'];

    /**
     * @SWG\Post(path="/diandi_tea/index/top",
     *    tags={"首页"},
     *    summary="商家及旗下包间信息",
     *     @SWG\Response(
     *         response = 200,
     *         description = "商家列表",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     * )
     * @throws Exception
     */
    public function actionTop(): array
    {
        $data = Yii::$app->request->post();
        $pageSize = $data['pageSize'] ?? 10;
        $page = $data['page'] ?? 1;
        $store_id = \Yii::$app->request->input('store_id', 0) ?? 0;
        $indexList = IndexService::top($pageSize, $page, $store_id);

        return ResultHelper::json(200, '请求成功', $indexList);
    }

    public function actionSms(): array
    {
        //    短信通知
        $mobile = '17778984690';
        $template = 'SMS_243370847';
        $data = [
            'product' => '有新的订单情况'
        ];
        $res = Yii::$app->service->apiSmsService->sendContent($mobile, $data, $template);
        return ResultHelper::json(200, '请求成功', $res);

    }
}
