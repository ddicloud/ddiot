<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-14 10:56:16
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-30 18:12:15
 */

namespace addons\diandi_tea\api;

use api\controllers\AController;
use common\helpers\ResultHelper;
use diandi\addons\cloud;
use diandi\iot\services\diandiSdk;
use Yii;

class ApiController extends AController
{
    public $modelClass = '';

    protected array $authOptional = ['index'];

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
     *     in="formData",
     *     name="name",
     *     type="string",
     *     description="收货人",
     *     required=true,
     *   ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="phone",
     *     type="integer",
     *     description="手机号",
     *     required=true,
     *   ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="province_id",
     *     type="integer",
     *     description="省份",
     *     required=true,
     *   ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="city_id",
     *     type="integer",
     *     description="城市",
     *     required=true,
     *   ),
     *     @SWG\Parameter(
     *     in="formData",
     *     name="region_id",
     *     type="integer",
     *     description="区县",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="detail",
     *     type="integer",
     *     description="具体地址",
     *     required=true,
     *   )
     * )
     */
    public function actionIndex(): array
    {
        $data = Yii::$app->request->post();
        $diandiSdk = new diandiSdk();
        $diandiSdk->LockOpen('13546');
        return ResultHelper::json(200,'获取成功');
    }

    public function actionTest(): void
    {
       $cloud = new cloud();
//       $verify_license =$cloud->activate_license('3617B0UY','chunchun');
//       var_dump($verify_license);
       $file = $cloud->check_update();
       $cloud->download_update($file['update_id'], $file['has_sql'], $file['version']);
       var_dump($file);
        $time = date('Y-m-d H:i:s');
        $start_time = date('Y-m-d H:i:s', time() - 10 * 60);
        $order = DoorlockRoomOrder::find()->where([
            'ext_order_id' => 456,
            'member_id' => 5, 'ext_room_id' => 5, ])
        ->andWhere(['<', 'FROM_UNIXTIME(UNIX_TIMESTAMP(start_time)-600)', $time])
        ->andWhere(['>=', 'end_time', $time])
        ->asArray()->one();
        print_r($order);
        echo DoorlockRoomOrder::find()->where([
            'ext_order_id' => 456,
            'member_id' => 5, 'ext_room_id' => 5, ])
        ->andWhere(['<', 'FROM_UNIXTIME(UNIX_TIMESTAMP(start_time)-600)', $time])
        ->andWhere(['>=', 'end_time', $time])->createCommand()->getRawSql();
        // $member_id = Yii::$App->user->identity->member_id??0;

        // $data['openid'] = DdWxappFans::find()->where(['user_id' => $member_id])->select('openid')->scalar();
        // if (empty($data)) {
        //     return ResultHelper::json(400, '缺少openid');
        // }
        // $res = NoticeService::Subscribe($data);

        // return ResultHelper::json(200, '请求成功', $res);
    }

    // 队列测试
    public function actionQueue()
    {
    }
}
