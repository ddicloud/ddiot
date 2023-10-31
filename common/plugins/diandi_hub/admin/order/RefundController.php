<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-11 04:19:05
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-07-26 15:12:06
 */

namespace common\plugins\diandi_hub\admin\order;

use common\plugins\diandi_hub\models\goods\HubGoodsBaseGoods;
use common\plugins\diandi_hub\models\order\HubRefundOrder;
use common\plugins\diandi_hub\models\Searchs\refund\HubRefundOrder as HubRefundOrderSearch;
use common\plugins\diandi_hub\services\AftersaleService;
use admin\controllers\AController;
use api\models\DdMember;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * RefundController implements the CRUD actions for HubRefundOrder model.
 */
class RefundController extends AController
{
    public string $modelSearchName = 'HubRefundOrderSearch';

    /**
     * Lists all HubRefundOrder models.
     *
     * @return array
     */
    public function actionIndex()
    {
        $searchModel = new HubRefundOrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HubRefundOrder model.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = HubRefundOrder::find()->where(['id' => $id])->asArray()->one();

        $model['temp_goods_name'] = HubGoodsBaseGoods::find()->select(['goods_name'])->where(['goods_id' => $model['goods_id']])->asArray()->one()['goods_name'];
        $model['temp_username'] = DdMember::find()->select(['username'])->where(['member_id' => $model['member_id']])->asArray()->one()['username'];

        $detail = AftersaleService::detail($model->order_id);

        return ResultHelper::json(200, '获取成功', [
            'model' => $model,
            'detail' => $detail,
        ]);
    }

    /**
     * Creates a new HubRefundOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate()
    {
        $model = new HubRefundOrder();

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return ResultHelper::json(200, '新建成功', [
                'model' => $model,
            ]);
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(401, $msg);
        }

        $reasons = AftersaleService::getRefundInfo();
        $reason = $reasons['Reason'];

        return ResultHelper::json(200, '获取成功', [
            'reason' => $reason,
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing HubRefundOrder model.
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
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return ResultHelper::json(200, '更新成功', [
                'model' => $model,
            ]);
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(401, $msg);
        }

        $reasons = AftersaleService::getRefundInfo();
        $reason = $reasons['Reason'];

        return ResultHelper::json(200, '获取成功', [
            'reason' => $reason,
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing HubRefundOrder model.
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
        $this->findModel($id)->delete();

        return ResultHelper::json(200, '删除成功');
    }

    /**
     * Finds the HubRefundOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return HubRefundOrder the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubRefundOrder::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
