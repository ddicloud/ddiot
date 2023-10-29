<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-09 23:19:04
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-24 14:36:11
 */

namespace common\plugins\diandi_hub\api;

use common\plugins\diandi_hub\models\config\HubConfig;
use common\plugins\diandi_hub\models\express\HubExpressCompany;
use common\plugins\diandi_hub\services\StoreService;
use api\controllers\AController;
use common\helpers\ImageHelper;
use common\helpers\MapHelper;
use common\helpers\ResultHelper;
use function GuzzleHttp\json_decode;
use Yii;

class StoreController extends AController
{
    public $modelClass = '\common\models\DdGoods';
    protected array $authOptional = ['info', 'conf'];

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
    public function actionInfo()
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
    public function actionDistance()
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
    public function actionAdd()
    {
        global $_GPC;
        $name = $_GPC['name'];
        $mobile = $_GPC['mobile'];
        $address = $_GPC['address'];
        $city = $_GPC['city'];
        $provice = $_GPC['province'];
        $area = $_GPC['area'];
        $linkman = $_GPC['linkman'];
        $storefront = $_GPC['storefront'];
        $cardFront = $_GPC['cardFront'];
        $cardReverse = $_GPC['cardReverse'];
        $desc = $_GPC['desc'];
        $wechat_code = $_GPC['wechat_code'];
        $business = $_GPC['business'];
        $interior = $_GPC['interior'];
        $certification = $_GPC['certification'];

        $Res = StoreService::addStore($name, $mobile, $address, $city, $provice, $area, $desc, $linkman, $storefront, $business, $cardFront, $cardReverse, $interior, $wechat_code, $certification);
        if ($Res) {
            return ResultHelper::json(200, '添加成功', []);
        } else {
            return ResultHelper::json(400, '添加失败', []);
        }
    }

    public function actionMystore()
    {
        $member_id = Yii::$app->user->identity->member_id??0;

        $list = StoreService::getStoreBymid($member_id);

        return ResultHelper::json(200, '获取成功', $list);
    }

    public function actionAddpay()
    {
        global $_GPC;
        $member_id = Yii::$app->user->identity->member_id??0;

        if (!empty($_GPC['goods'])) {
            $goods = json_decode($_GPC['goods'], true);
        } else {
            $goods = [];
        }

        $totalprice = $_GPC['totalprice'];
        $remark = $_GPC['remark'];
        $member_store_id = $_GPC['member_store_id'];

        $typeStatus = $_GPC['typeStatus'];

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

    public function actionPaylist()
    {
        global $_GPC;
        $member_id = Yii::$app->user->identity->member_id??0;
        $order_status = $_GPC['order_status'];
        $page = Yii::$app->request->post('page', 1);
        $pageSize = Yii::$app->request->post('pageSize', 10);
        $order_status = $_GPC['order_status'];
        $list = StoreService::list($member_id, $order_status, $page, $pageSize);

        return ResultHelper::json(200, '获取成功', [
            'list' => $list,
        ]);
    }

    public function actionMemberpaylist()
    {
        global $_GPC;
        $member_id = Yii::$app->user->identity->member_id??0;
        $order_status = $_GPC['order_status'];
        $page = Yii::$app->request->post('page', 1);
        $pageSize = Yii::$app->request->post('pageSize', 10);
        $order_status = $_GPC['order_status'];
        $list = StoreService::memberPayList($member_id, $order_status, $page, $pageSize);

        return ResultHelper::json(200, '获取成功', [
            'list' => $list,
        ]);
    }

    public function actionPaydetail()
    {
        global $_GPC;
        $member_id = Yii::$app->user->identity->member_id??0;
        $order_id = $_GPC['order_id'];
        $detail = StoreService::detail($order_id, $member_id);

        return ResultHelper::json(200, '获取成功', $detail);
    }

    public function actionCreditpay()
    {
        global $_GPC;
        $member_id = Yii::$app->user->identity->member_id??0;
        $order_id = $_GPC['order_id'];

        $Res = StoreService::creditPay($order_id);

        if ($Res['status'] == 0) {
            return ResultHelper::json(200, $Res['msg'], $Res);
        } else {
            return ResultHelper::json(400, $Res['msg'], $Res);
        }
    }

    public function actionConfirm()
    {
        global $_GPC;
        $member_id = Yii::$app->user->identity->member_id??0;
        $order_id = $_GPC['order_id'];
        $Res = StoreService::confirm($member_id, $order_id);

        if ($Res['status'] == 0) {
            return ResultHelper::json(200, '订单确认成功', $Res);
        } else {
            return ResultHelper::json(400, $Res['msg'], $Res);
        }
    }

    public function actionList()
    {
        $user_id = Yii::$app->user->identity->member_id??0;
        $pageSize = Yii::$app->request->post('pageSize');
        $order_status = Yii::$app->request->post('order_status');
        $order_status = $order_status == -1 ? '' : $order_status;
        $list = StoreService::onlineList($user_id, $order_status, $pageSize);

        return ResultHelper::json(200, '获取成功', $list);
    }

    public function actionConfirmonline()
    {
        global $_GPC;

        $order_id = $_GPC['order_id'];

        $ctype = $_GPC['ctype'];

        $expressCode = trim($_GPC['expressCode']);
        $express_company = trim($_GPC['express_company']);

        return StoreService::confirmOrder($order_id, $ctype, $expressCode, $express_company);
    }

    public function actionExpress()
    {
        global $_GPC;
        $express = HubExpressCompany::find()->where(['status' => 1])->asArray()->all();

        return ResultHelper::json(200, '获取成功', $express);
    }

    public function actionConf()
    {
        $model = new HubConfig();
        $detail = $model->findOne(1);

        return ResultHelper::json(200, '获取成功', $detail);
    }
}
