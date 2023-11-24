<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-14 10:56:16
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-21 09:41:29
 */

namespace addons\diandi_tea\api;

use addons\diandi_tea\models\config\TeaGlobalConfig;
use addons\diandi_tea\models\config\TeaHourse;
use addons\diandi_tea\models\marketing\TeaCoupon;
use addons\diandi_tea\models\order\TeaMeituan;
use addons\diandi_tea\services\TuanService;
use api\controllers\AController;
use common\helpers\ResultHelper;
use Yii;

class MeituanController extends AController
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
    public function actionAdd(): array
   {

        $data = Yii::$app->request->post();
        $access_token = $data['access_token'];
        $data['user_id'] = Yii::$app->user->identity->member_id??0;
        $res = [];
        // 美团卡券code
        $meituan_code =\Yii::$app->request->input('meituan_code');
        // 卡券
        $coupon_id =\Yii::$app->request->input('coupon_id');
        // 房间
        $hourse_id =\Yii::$app->request->input('hourse_id');

        $Res = TuanService::addTuan($meituan_code, $coupon_id, $hourse_id);

        if ($Res['status'] === 1) {
            return ResultHelper::json(400, $Res['message']);
        } else {
            return ResultHelper::json(200, '请求成功', $Res);
        }
    }

    public function actionShowCoupon(): array
   {
        $member_id = Yii::$app->user->identity->member_id??0;
        $model = new TeaGlobalConfig();
        $where['store_id'] =\Yii::$app->request->input('store_id',0);
        $admin_ids = $model->find()->select(['admin_ids'])->scalar();
        $show_coupon = false;
        if (!empty($admin_ids)) {
            $admin = explode(',', $admin_ids);
            if (in_array($member_id, $admin)) {
                $show_coupon = true;
            } else {
                $show_coupon = false;
            }
        }

        return ResultHelper::json(200, '请求成功', [
            'show_coupon' => $show_coupon,
        ]);
    }

    public function actionGive(): array
    {
        $Coupon = TeaCoupon::find()->orderBy(['num_sort' => SORT_DESC])->asArray()->all();
        $Hourse = TeaHourse::find()->asArray()->all();

        return ResultHelper::json(200, '请求成功', [
            'coupon' => $Coupon,
            'hourse' => $Hourse,
        ]);
    }

    public function actionDetail(): array
   {
        $id =\Yii::$app->request->input('id');
        $detail = TeaMeituan::find()->where(['id' => $id])->with(['coupon'])->asArray()->one();
        if ($detail) {
            try {
                $coupon_give = TuanService::giveCoupon($id);
                if ($coupon_give['code'] != 200) {
                    $detail['coupon_id'] = 0;
                }
                $detail['coupon_give'] = $coupon_give;
            } catch (\Throwable $e) {
                return ResultHelper::json(400, $e->getMessage(), (array)$e);
            }

        }

        return ResultHelper::json(200, '获取成功', $detail);
    }
}
