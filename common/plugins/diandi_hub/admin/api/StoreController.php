<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-09 23:19:04
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 17:05:12
 */

namespace common\plugins\diandi_hub\admin\api;

use common\plugins\diandi_hub\models\config\HubConfig;
use common\plugins\diandi_hub\models\express\HubExpressCompany;
use common\plugins\diandi_hub\services\StoreService;
use admin\controllers\AController;
use common\helpers\ImageHelper;
use common\helpers\MapHelper;
use common\helpers\ResultHelper;
use function GuzzleHttp\json_decode;
use Yii;

class StoreController extends AController
{
    public $modelClass = '\common\models\DdGoods';
    protected array $authOptional = ['info', 'conf'];

    public int $searchLevel = 0;

    /**
     * @SWG\Get(path="/diandi_hub/store/info",
     *     tags={"商家"},
     *     summary="商家信息.",
     *     @SWG\Response(
     *         response = 200,
     *         description = "商家信息",
     *     )
     * )
     */
    public function actionInfo():array
    {
        $store_id = Yii::$app->params['store_id'];
        $store = Yii::$app->service->commonGlobalsService->getStoreDetail($store_id);

        if (!$store) {
            return ResultHelper::json(400, '商户或不存在，请检查配置参数', $store);
        }

        if ($store['surroundings']) {
            $store['surroundings'] = ImageHelper::tomedia($store['surroundings']);
            $store['surroundings'] = array_chunk($store['surroundings'], 2);
        }
        if ($store['certificate']) {
            $store['certificate'] = ImageHelper::tomedia($store['certificate']);
            $store['certificate'] = array_chunk($store['certificate'], 2);
        }
        $store['banner'] = ImageHelper::tomedia($store['banner']);
        $store['shareimg'] = ImageHelper::tomedia($store['shareimg']);
        $store['hotSearch'] = explode(',', $store['hotSearch']);
        $info['wxappName'] = Yii::$app->settings->get('Wxapp', 'name');

        return ResultHelper::json(200, '获取成功', $store);
    }

    /**
     * @SWG\Get(path="/diandi_hub/store/distance",
     *     tags={"商家"},
     *     summary="计算与商家的距离",
     *     @SWG\Response(
     *         response = 200,
     *         description = "计算与商家的距离",
     *     ),
     *     @SWG\Parameter(
     *      in="query",
     *      name="lat",
     *      type="string",
     *      description="纬度",
     *      required=true,
     *    ),
     *     @SWG\Parameter(
     *      in="query",
     *      name="lng",
     *      type="string",
     *      description="经度",
     *      required=true,
     *    ),
     * )
     */
    public function actionDistance():array
    {
        $store_id = Yii::$app->params['store_id'];
        $store = Yii::$app->service->commonGlobalsService->getStoreDetail($store_id);

        if (!$store) {
            return ResultHelper::json(400, '商户或不存在，请检查配置参数', $store);
        }

        $lng1 = Yii::$app->request->get('lng');
        $lat1 = Yii::$app->request->get('lat');
        $lng_lat = json_decode($store['lng_lat'], true);
        $distance = $store['distance'];

        $lng2 = $lng_lat['lng'];
        $lat2 = $lng_lat['lat'];

        $data = MapHelper::getdistance($lng1, $lat1, $lng2, $lat2);

        $is_distance = $data / 1000 > $distance && $distance > 0 ? 1 : 0;

        return ResultHelper::json(200, '获取成功', [
            'distance' => $data / 1000,
            'is_distance' => $is_distance,
            'juli' => $distance,
        ]);
    }

    // 申请开店
    public function actionAdd(): array
    {
        global $_GPC;
        $name = Yii::$app->request->input('name');
        $mobile = Yii::$app->request->input('mobile');
        $address = Yii::$app->request->input('address');
        $city = Yii::$app->request->input('city');
        $provice = Yii::$app->request->input('province');
        $area = Yii::$app->request->input('area');
        $linkman = Yii::$app->request->input('linkman');
        $storefront = Yii::$app->request->input('storefront');
        $cardFront = Yii::$app->request->input('cardFront');
        $cardReverse = Yii::$app->request->input('cardReverse');
        $desc = Yii::$app->request->input('desc');
        $wechat_code = Yii::$app->request->input('wechat_code');
        $business = Yii::$app->request->input('business');
        $interior = Yii::$app->request->input('interior');
        $certification = Yii::$app->request->input('certification');

        $Res = StoreService::addStore($name, $mobile, $address, $city, $provice, $area, $desc, $linkman, $storefront, $business, $cardFront, $cardReverse, $interior, $wechat_code, $certification);
        if ($Res) {
            return ResultHelper::json(200, '添加成功', []);
        } else {
            return ResultHelper::json(400, '添加失败', []);
        }
    }

    public function actionMystore(): array
    {
        $member_id = Yii::$app->user->identity->user_id;

        $list = StoreService::getStoreBymid($member_id);

        return ResultHelper::json(200, '获取成功', $list);
    }

    public function actionAddpay(): array
    {
        global $_GPC;
        $member_id = Yii::$app->user->identity->user_id;

        if (!empty(Yii::$app->request->input('goods'))) {
            $goods = json_decode(Yii::$app->request->input('goods'), true);
        } else {
            $goods = [];
        }

        $totalprice = Yii::$app->request->input('totalprice');
        $remark = Yii::$app->request->input('remark');
        $member_store_id = Yii::$app->request->input('member_store_id');

        $typeStatus = Yii::$app->request->input('typeStatus');

        $operation_mid = StoreService::getStoreByStoreId($member_store_id);

        if ($typeStatus == 0) {
            // 收款，用户扫码后关联
            $member_id = 0;
        }

        $Res = StoreService::addPay($operation_mid, $member_id, $member_store_id, $totalprice, $remark, $goods);

        if ($Res['code'] == 0) {
            return ResultHelper::json(200, '创建成功', ['order_id' => $Res['order_id']]);
        } else {
            return ResultHelper::json(400, $Res['msg'], []);
        }
    }

    public function actionPaylist(): array
    {
        global $_GPC;
        $member_id = Yii::$app->user->identity->user_id;
        $order_status = Yii::$app->request->input('order_status');
        $page = Yii::$app->request->post('page', 1);
        $pageSize = Yii::$app->request->post('pageSize', 10);
        $order_status = Yii::$app->request->input('order_status');
        $list = StoreService::list($member_id, $order_status, $page, $pageSize);

        return ResultHelper::json(200, '获取成功', [
            'list' => $list,
        ]);
    }

    public function actionMemberpaylist(): array
    {
        global $_GPC;
        $member_id = Yii::$app->user->identity->user_id;
        $order_status = Yii::$app->request->input('order_status');
        $page = Yii::$app->request->post('page', 1);
        $pageSize = Yii::$app->request->post('pageSize', 10);
        $order_status = Yii::$app->request->input('order_status');
        $list = StoreService::memberPayList($member_id, $order_status, $page, $pageSize);

        return ResultHelper::json(200, '获取成功', [
            'list' => $list,
        ]);
    }

    public function actionPaydetail(): array
    {
        global $_GPC;
        $member_id = Yii::$app->user->identity->user_id;
        $order_id = Yii::$app->request->input('order_id');
        $detail = StoreService::detail($order_id, $member_id);

        return ResultHelper::json(200, '获取成功', $detail);
    }

    public function actionCreditpay(): array
    {
        global $_GPC;
        $member_id = Yii::$app->user->identity->user_id;
        $order_id = Yii::$app->request->input('order_id');

        $Res = StoreService::creditPay($order_id);

        if ($Res['status'] == 0) {
            return ResultHelper::json(200, $Res['msg'], $Res);
        } else {
            return ResultHelper::json(400, $Res['msg'], $Res);
        }
    }

    public function actionConfirm(): array
    {
        global $_GPC;
        $member_id = Yii::$app->user->identity->user_id;
        $order_id = Yii::$app->request->input('order_id');
        $Res = StoreService::confirm($member_id, $order_id);

        if ($Res['status'] == 0) {
            return ResultHelper::json(200, '订单确认成功', $Res);
        } else {
            return ResultHelper::json(400, $Res['msg'], $Res);
        }
    }

    public function actionList(): array
    {
        $user_id = Yii::$app->user->identity->user_id;
        $pageSize = Yii::$app->request->post('pageSize');
        $order_status = Yii::$app->request->post('order_status');
        $order_status = $order_status == -1 ? '' : $order_status;
        $list = StoreService::onlineList($user_id, $order_status, $pageSize);

        return ResultHelper::json(200, '获取成功', $list);
    }

    public function actionConfirmonline():array
    {
        global $_GPC;

        $order_id = Yii::$app->request->input('order_id');

        $ctype = Yii::$app->request->input('ctype');

        $expressCode = trim(Yii::$app->request->input('expressCode'));
        $express_company = trim(Yii::$app->request->input('express_company'));

        return StoreService::confirmOrder($order_id, $ctype, $expressCode, $express_company);
    }

    public function actionExpress():array
    {
        global $_GPC;
        $express = HubExpressCompany::find()->where(['status' => 1])->asArray()->all();

        return ResultHelper::json(200, '获取成功', $express);
    }

    public function actionConf():array
    {
        $model = new HubConfig();
        $detail = $model->findOne(1);

        return ResultHelper::json(200, '获取成功', $detail);
    }
}
