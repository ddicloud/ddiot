<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-23 12:00:12
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-25 16:49:36
 */

namespace addons\diandi_tea\admin\order;

use addons\diandi_tea\models\order\TeaSetMealList;
use addons\diandi_tea\models\searchs\order\TeaSetMealList as TeaSetMealListSearch;
use admin\controllers\AController;
use api\models\DdMember;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

/**
 * SetMealListController implements the CRUD actions for TeaSetMealList model.
 */
class SetMealListController extends AController
{
    public string $modelSearchName = 'TeaSetMealList';

    public $modelClass = '';

    /**
     * @SWG\Get(path="/diandi_tea/order/set-meal-list/index",
     *    tags={"套餐选用记录"},
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
        $searchModel = new TeaSetMealListSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @SWG\Get(path="/diandi_tea/order/set-meal-list/view",
     *    tags={"套餐选用记录"},
     *    summary="记录详情",
     *     @SWG\Response(
     *         response = 200,
     *         description = "'id' => '套餐消费记录id','bloc_id' => '人脸库组id','store_id' => 'Store ID','create_time' => 'Create Time','update_time' => 'Update Time','title' => '套餐名','duration' => '套餐时长','price' => '套餐价格','renew_price' => '每半小时续费单价','order_id' => '订单id','set_meal_id' => '套餐id','member_id' => '会员id'",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     * )
     */
    public function actionView($id): array
    {
        $view = TeaSetMealList::find()->where(['id' => $id])->with(['member'])->asArray()->one();
        $view['username'] = DdMember::find()->select(['username'])->where(['member_id' => $view['member_id']])->asArray()->one()['username'];

        return ResultHelper::json(200, '获取成功', $view);
    }

    /**
     * Creates a new TeaSetMealList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate(): array
    {
        $model = new TeaSetMealList();

        $data = Yii::$app->request->post();

        if ($model->load($data, '') && $model->save()) {
            return ResultHelper::json(200, '创建成功', $model->toArray());
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }
    }

    /**
     * Updates an existing TeaSetMealList model.
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
     * @SWG\Get(path="/diandi_tea/order/set-meal-list/delete",
     *    tags={"套餐选用记录"},
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
     * Finds the TeaSetMealList model based on its primary key value.
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
        if (($model = TeaSetMealList::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
