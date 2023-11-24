<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-18 17:48:51
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-25 16:12:40
 */

namespace addons\diandi_tea\admin\order;

use addons\diandi_tea\models\enums\OrderStatus;
use addons\diandi_tea\models\order\TeaOrderList;
use addons\diandi_tea\models\searchs\order\TeaOrderList as TeaOrderListSearch;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

/**
 * OrderListController implements the CRUD actions for TeaOrderList model.
 */
class OrderListController extends AController
{
    public string $modelSearchName = 'TeaOrderList';

    public $modelClass = '';

    /**
     * @SWG\Get(path="/diandi_tea/order/order-list/index",
     *    tags={"包间订单记录"},
     *    summary="列表数据",
     *     @SWG\Response(
     *         response = 200,
     *         description = "'id' => '包间订单id','bloc_id' => '人脸库组id','store_id' => 'Store ID','create_time' => 'Create Time','update_time' => 'Update Time','start_time' => '开始时间','end_time' => '结束时间','member_id' => '会员id','coupon_id' => '使用卡券id','balance' => '余额','amount_payable' => '应付金额','discount' => '优惠金额','real_pay' => '实付金额','order_number' => '订单编号','pay_type' => '支付方式：1.现金支付 2.余额支付','status' => '订单状态：1.待付款 2.支付成功 3.已完成 4.已取消','hourse_id' => '包间id','is_use' => '是否正在使用 ：1.未使用  2.使用中  3.已使用','order_type' => '订单类型 1.包间订单  2.续费订单','set_meal_id' => '使用套餐id','set_meal_name' => '使用套餐名','renew_order_id' => '续费订单id','transaction_id' => '微信订单编号','pay_time' => '支付时间','renew_price' => '半小时续费单价', ",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     * )
     */
    public function actionIndex(): array
    {
        $searchModel = new TeaOrderListSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @SWG\Get(path="/diandi_tea/order/order-list/view",
     *    tags={"包间订单记录"},
     *    summary="订单详情",
     *     @SWG\Response(
     *         response = 200,
     *         description = "订单详情",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *  @SWG\Parameter(
     *     in="query",
     *     name="id",
     *     type="integer",
     *     description="id",
     *     required=false,
     *   )
     * )
     */
    public function actionView($id): array
    {
         try {
             $view = TeaOrderList::find()->where(['id' => $id])->with(['member'])->asArray()->one();
             $order_status = OrderStatus::listData();
             $view['status'] = $order_status[$view['status']];
             $view['order_type'] = $view['order_type'] == 1 ? '包间订单' : '续费订单';
             $view['pay_type'] = $view['order_type'] == 1 ? '现金支付' : '余额支付';

             return ResultHelper::json(200, '获取成功', $view);
        } catch (NotFoundHttpException $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        }

    }

    /**
     * Creates a new TeaOrderList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate(): array
    {
        $model = new TeaOrderList();

        $data = Yii::$app->request->post();

        if ($model->load($data, '') && $model->save()) {
            return ResultHelper::json(200, '创建成功', $model->toArray());
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }
    }

    /**
     * Updates an existing TeaOrderList model.
     * If the update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id): array
    {
        $model = $this->findModel($id);

        $data = Yii::$app->request->post();

        if ($model->load($data, '') && $model->save()) {
            return ResultHelper::json(200, '编辑成功', $model->toArray());
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }

    }

    /**
     * @SWG\Get(path="/diandi_tea/order/order-list/delete",
     *    tags={"包间订单记录"},
     *    summary="删除订单",
     *     @SWG\Response(
     *         response = 200,
     *         description = "删除订单",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     * )
     */
    public function actionDelete($id): array
    {
        try {
            $this->findModel($id)->delete();
            return ResultHelper::json(200, '删除成功');

        } catch (StaleObjectException|NotFoundHttpException $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        } catch (\Throwable $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        }

    }

    /**
     * Finds the TeaOrderList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return array|ActiveRecord the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): array|\yii\db\ActiveRecord
    {
        if (($model = TeaOrderList::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
