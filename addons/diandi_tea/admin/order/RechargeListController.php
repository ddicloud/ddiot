<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-18 17:49:55
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-25 16:48:03
 */

namespace addons\diandi_tea\admin\order;

use addons\diandi_tea\models\order\TeaRechargeList;
use addons\diandi_tea\models\searchs\order\TeaRechargeList as TeaRechargeListSearch;
use admin\controllers\AController;
use api\models\DdMember;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

/**
 * RechargeListController implements the CRUD actions for TeaRechargeList model.
 */
class RechargeListController extends AController
{
    public string $modelSearchName = 'TeaRechargeList';

    public $modelClass = '';

    /**
     * @SWG\Get(path="/diandi_tea/order/recharge-list/index",
     *    tags={"充值列表"},
     *    summary="列表数据",
     *     @SWG\Response(
     *         response = 200,
     *         description = "'id' => '余额充值id','bloc_id' => '人脸库组id','store_id' => 'Store ID','create_time' => 'Create Time','update_time' => 'Update Time','member_id' => '充值用户id','recharge_id' => '充值套餐列表id','price' => '花费金额','balance' => '余额','transaction_id' => '微信订单编号','order_number' => '订单编号','pay_time' => '购买时间',",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     * )
     */
    public function actionIndex(): array
    {
        $searchModel = new TeaRechargeListSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @SWG\Get(path="/diandi_tea/order/recharge-list/view",
     *    tags={"充值列表"},
     *    summary="充值详情",
     *     @SWG\Response(
     *         response = 200,
     *         description = "充值详情",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     * )
     */
    public function actionView($id): array
    {
        $view = TeaRechargeList::find()->where(['id' => $id])->with(['member'])->asArray()->one();
        $view['username'] = DdMember::find()->select(['username'])->where(['member_id' => $view['member_id']])->asArray()->one()['username'];

        return ResultHelper::json(200, '获取成功', $view);
    }

    /**
     * Creates a new TeaRechargeList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate(): array
    {
        $model = new TeaRechargeList();

        $data = Yii::$app->request->post();

        if ($model->load($data, '') && $model->save()) {
            return ResultHelper::json(200, '创建成功', $model->toArray());
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }
    }

    /**
     * Updates an existing TeaRechargeList model.
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
     * @SWG\Get(path="/diandi_tea/order/recharge-list/delete",
     *    tags={"充值列表"},
     *    summary="删除记录",
     *     @SWG\Response(
     *         response = 200,
     *         description = "删除记录",
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
     * Finds the TeaRechargeList model based on its primary key value.
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
        if (($model = TeaRechargeList::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
