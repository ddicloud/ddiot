<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-11 14:41:20
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-22 14:17:07
 */

namespace common\plugins\diandi_hub\admin\order;

use common\plugins\diandi_hub\models\enums\AftersaleStatus;
use common\plugins\diandi_hub\models\enums\PayTypeStatus;
use common\plugins\diandi_hub\models\order\HubRefundLog;
use common\plugins\diandi_hub\models\Searchs\refund\HubRefundLog as HubRefundLogSearch;
use common\plugins\diandi_hub\services\AftersaleService;
use admin\controllers\AController;
use common\helpers\ResultHelper;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * RefundlogController implements the CRUD actions for HubRefundLog model.
 */
class RefundlogController extends AController
{
    public string $modelSearchName = 'HubRefundLogSearch';

    /**
     * Lists all HubRefundLog models.
     *
     * @return array
     */
    public function actionIndex()
    {
        global $_GPC;
        $order_id =\Yii::$app->request->input('order_id');

        $searchModel = new HubRefundLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200,'获取成功',[
            'order_id' => $order_id,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HubRefundLog model.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        global $_GPC;
        $order_id =\Yii::$app->request->input('order_id');

        return ResultHelper::json(200,'获取成功',[
            'order_id' => $order_id,
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new HubRefundLog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate()
    {
        global $_GPC;
        $order_id =\Yii::$app->request->input('order_id');
        $refund = AftersaleService::detail($order_id);
        $detail = $refund['refund'];
        $pay_type = PayTypeStatus::getLabel($refund['pay_type']);

        if ($detail['status'] == AftersaleStatus::getValueByName('已完结')) {
            Yii::$app->session->setFlash('error', '该售后已完结不需要处理');

            return $this->redirect(['index', 'order_id' => $order_id]);
        }

        $model = new HubRefundLog();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            AftersaleService::confirmRefund($order_id,\Yii::$app->request->input('HubRefundLog')['status'],\Yii::$app->request->input('HubRefundLog')['refund_status']);

            return $this->redirect(['view', 'id' => $model->id, 'order_id' => $order_id]);
        }

        $model->order_id = $detail['order_id'];
        $model->refund_id = $detail['id'];

        $model->old_refund_status = $detail['refund_status'];
        $model->old_status = $detail['status'];

        $model->type = $detail['type'];
        $model->member_id = $detail['member_id'];
        $model->refund_username = Yii::$app->user->identity->username;
        $model->user_remark = $detail['remark'];
        $model->money = $detail['money'];

        $model->refund_status = $detail['refund_status'];
        $model->status = $detail['status'];

        return ResultHelper::json(200,'获取成功',[
            'order_id' => $order_id,
            'model' => $model,
            'pay_type' => $pay_type,
            'total_price' => $refund['total_price'],
            'order_no' => $refund['order_no'],
        ]);
    }

    /**
     * Updates an existing HubRefundLog model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        global $_GPC;
        $order_id =\Yii::$app->request->input('order_id');
        $model = $this->findModel($id);

        $refund = AftersaleService::detail($order_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'order_id' => $order_id]);
        }

        $pay_type = PayTypeStatus::getLabel($refund['pay_type']);

        return ResultHelper::json(200,'获取成功',[
            'order_id' => $order_id,
            'model' => $model,
            'pay_type' => $pay_type,
            'total_price' => $refund['total_price'],
            'order_no' => $refund['order_no'],
        ]);
    }

    /**
     * Deletes an existing HubRefundLog model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        global $_GPC;
        $order_id =\Yii::$app->request->input('order_id');

        $this->findModel($id)->delete();

        return $this->redirect(['index', 'order_id' => $order_id]);
    }

    /**
     * Finds the HubRefundLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return HubRefundLog the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubRefundLog::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
