<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-14 10:56:16
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-30 18:12:15
 */

namespace addons\diandi_tea\api;

use addons\diandi_doorlock\models\sdk\DoorlockRoomOrder;
use addons\diandi_tea\services\NoticeService;
use api\controllers\AController;
use api\modules\wechat\models\DdWxappFans;
use common\helpers\ResultHelper;
use diandi\addons\cloud;
use Yii;

class ApiController extends AController
{
    public $modelClass = '';

    protected array $authOptional = ['test'];

    /**
     * @SWG\Post(path="/diandi_shop/address/add",
     *    tags={"测试接口"},
     *    summary="收货地址添加",
     *     @SWG\Response(
     *         response = 200,
     *         description = "收货地址添加",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="name",
     *     type="string",
     *     description="收货人",
     *     required=true,
     *   ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="phone",
     *     type="integer",
     *     description="手机号",
     *     required=true,
     *   ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="province_id",
     *     type="integer",
     *     description="省份",
     *     required=true,
     *   ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="city_id",
     *     type="integer",
     *     description="城市",
     *     required=true,
     *   ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="region_id",
     *     type="integer",
     *     description="区县",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="detail",
     *     type="integer",
     *     description="具体地址",
     *     required=true,
     *   )
     * )
     */
    public function actionIndex(): array
   {

        $data = Yii::$app->request->post();
        $access_token = $data['access_token'];
        $data['user_id'] = Yii::$app->user->identity->member_id??0;
        $res = [];

        return ResultHelper::json(200, '请求成功', $res);
    }

    public function actionTest(): void
    {
       $cloud = new cloud();
//       $verify_license =$cloud->activate_license('3617B0UY','chunchun');
//       var_dump($verify_license);
       $file = $cloud->check_update();
       $cloud->download_update($file['update_id'], $file['has_sql'], $file['version']);
       var_dump($file);
    }

    // 队列测试
    public function actionQueue()
    {
    }
}
