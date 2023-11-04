<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-22 10:41:41
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-28 16:13:50
 */

namespace addons\diandi_tea\admin\marketing;

use addons\diandi_tea\models\marketing\TeaCoupon;
use addons\diandi_tea\models\marketing\TeaRecharge;
use addons\diandi_tea\models\searchs\marketing\TeaRecharge as TeaRechargeSearch;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

/**
 * RechargeController implements the CRUD actions for TeaRecharge model.
 */
class RechargeController extends AController
{
    public string $modelSearchName = 'TeaRecharge';

    public $modelClass = '';

    /**
     * @SWG\Get(path="/diandi_tea/marketing/recharge/index",
     *    tags={"充值活动"},
     *    summary="列表数据",
     *     @SWG\Response(
     *         response = 200,
     *         description = "列表数据",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     * )
     */
    public function actionIndex(): array
    {
        $searchModel = new TeaRechargeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @SWG\Get(path="/diandi_tea/marketing/recharge/view",
     *    tags={"充值活动"},
     *    summary="活动详情",
     *     @SWG\Response(
     *         response = 200,
     *         description = "活动详情",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     * )
     */
    public function actionView($id): array
    {
         try {
            $view = $this->findModel($id)->toArray();
             $view = TeaRecharge::find()->where(['id' => $id])->asArray()->one();
             if ($view['give_coupon_ids']) {
                 $give_coupon_ids = explode(',', $view['give_coupon_ids']);

                 $data = TeaCoupon::find()->select(['name'])->where(['id' => $give_coupon_ids])->asArray()->all();
                 $new = [];
                 foreach ($data as $a => $b) {
                     $new[] = $b['name'];
                 }

                 $view['give_coupon_name'] = implode(',', $new);
             }

             return ResultHelper::json(200, '获取成功', $view);
        } catch (NotFoundHttpException $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        }

    }

    /**
     * @SWG\Post(path="/diandi_tea/marketing/recharge/create",
     *    tags={"充值活动"},
     *    summary="创建活动",
     *     @SWG\Response(
     *         response = 200,
     *         description = "创建活动",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="price",
     *     type="number",
     *     description="充值金额",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="give_money",
     *     type="number",
     *     description="赠送金额",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="give_coupon_ids",
     *     type="string",
     *     description="赠送卡券集合",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="type",
     *     type="integer",
     *     description="是否为活动套餐：1.是 2否",
     *     required=false,
     *   ),
     * )
     */
    public function actionCreate(): array
    {
        $model = new TeaRecharge();

        $data = Yii::$app->request->post();
        $ids = $data['give_coupon_ids'];
        if (count(explode(',', $ids)) != count(array_unique(explode(',', $ids)))) {
            return ResultHelper::json(400, '请勿添加重复卡券');
        }
        if ($model->load($data, '') && $model->save()) {
            return ResultHelper::json(200, '创建成功', $model->toArray());
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }
    }

    /**
     * @SWG\Post(path="/diandi_tea/marketing/recharge/update",
     *    tags={"充值活动"},
     *    summary="更新活动",
     *     @SWG\Response(
     *         response = 200,
     *         description = "更新活动",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *    @SWG\Parameter(
     *     in="query",
     *     name="price",
     *     type="number",
     *     description="充值金额",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="give_money",
     *     type="number",
     *     description="赠送金额",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="give_coupon_ids",
     *     type="string",
     *     description="赠送卡券集合",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="type",
     *     type="integer",
     *     description="是否为活动套餐：1.是 2否",
     *     required=false,
     *   ),
     * )
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
     * Deletes an existing TeaRecharge model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionDelete($id): array
    {
        $this->findModel($id)->delete();

        return ResultHelper::json(200, '删除成功');
    }

    /**
     * Finds the TeaRecharge model based on its primary key value.
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
        if (($model = TeaRecharge::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
