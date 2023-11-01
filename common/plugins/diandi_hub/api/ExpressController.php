<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-27 23:01:41
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-16 17:59:03
 */

namespace common\plugins\diandi_hub\api;

use common\plugins\diandi_hub\models\express\HubExpressCompany;
use common\plugins\diandi_hub\services\AddressService;
use api\controllers\AController;
use common\helpers\ResultHelper;
use Yii;

class ExpressController extends AController
{
    public $modelClass = '';

    /**
     * @SWG\Post(path="/diandi_hub/express/list",
     *    tags={"收货地址"},
     *    summary="收货地址添加",
     *     @SWG\Response(
     *         response = 200,
     *         description = "收货地址添加",
     *     ),
     *     @SWG\Parameter(
     *      name="access-token",
     *      type="string",
     *      in="query",
     *      required=true
     *     ),
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
    public function actionList()
    {
        global $_GPC;
        $user_id = Yii::$app->user->identity->member_id??0;
        $res = [];
        $address_id =\Yii::$app->request->input('address_id');
        $address = AddressService::detail($user_id, $address_id);
        $province = $address['province_id'];
        $district = $address['city_id'];

        // $list = HubExpressCompany::find()->with(['template' => function ($query) use ($province,$district) {
        //     return  $query->where(['is_default' => 1]);
        // }, 'area' => function ($query) use ($province,$district) {
        //     return  $query->where(['province' => $province, 'district' => $district]);
        // }])->asArray()->all();

        $list = HubExpressCompany::find()->with(['template', 'area' => function ($query) use ($province,$district) {
            return  $query->where(['province' => $province, 'district' => $district]);
        }])->asArray()->all();

        // foreach ($list as $key => $value) {
        //     if (empty($value['area']) || empty($value['template'])) {
        //         unset($list[$key]);
        //     }
        // }

        return ResultHelper::json(200, '请求成功', $list);
    }
}
