<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-17 11:33:24
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-24 11:09:41
 */

namespace addons\diandi_tea\admin\marketing;

use addons\diandi_tea\models\marketing\TeaSetMeal;
use addons\diandi_tea\models\searchs\marketing\TeaSetMeal as TeaSetMealSearch;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

/**
 * SetMealController implements the CRUD actions for TeaSetMeal model.
 */
class SetMealController extends AController
{
    public string $modelSearchName = 'TeaSetMeal';

    public $modelClass = '';

    /**
     * @SWG\Get(path="/diandi_tea/marketing/set-meal/index",
     *    tags={"营销套餐"},
     *    summary="列表数据",
     *     @SWG\Response(
     *         response = 200,
     *         description = "列表数据",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *    @SWG\Parameter(
     *     in="query",
     *     name="SetMealAar[title]",
     *     type="string",
     *     description="套餐名",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="SetMealAar[type]",
     *     type="integer",
     *     description="套餐类型：1.小时套餐  2.计时套餐",
     *     required=false,
     *   )
     * )
     */
    public function actionIndex(): array
    {
        $searchModel = new TeaSetMealSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @SWG\Get(path="/diandi_tea/marketing/setmeal/view",
     *    tags={"营销套餐"},
     *    summary="套餐详情",
     *     @SWG\Response(
     *         response = 200,
     *         description = "套餐详情",
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
        } catch (NotFoundHttpException $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        }

        return ResultHelper::json(200, '获取成功', $view);
    }

    /**
     * @SWG\Post(path="/diandi_tea/marketing/setmeal/create",
     *    tags={"营销套餐"},
     *    summary="创建套餐",
     *     @SWG\Response(
     *         response = 200,
     *         description = "创建套餐",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *    @SWG\Parameter(
     *     in="query",
     *     name="title",
     *     type="string",
     *     description="套餐名",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="type",
     *     type="integer",
     *     description="套餐类型：1.小时套餐  2.计时套餐",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="duration",
     *     type="integer",
     *     description="套餐时长",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="price",
     *     type="number",
     *     description="套餐价格",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="renew_price",
     *     type="number",
     *     description="每半小时续费单价",
     *     required=false,
     *   )
     * )
     */
    public function actionCreate(): array
    {
        $model = new TeaSetMeal();

        $data = Yii::$app->request->post();

        if ($model->load($data, '') && $model->save()) {
            return ResultHelper::json(200, '创建成功', $model->toArray());
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }
    }

    /**
     * @SWG\Post(path="/diandi_tea/marketing/setmeal/update",
     *    tags={"营销套餐"},
     *    summary="更新套餐",
     *     @SWG\Response(
     *         response = 200,
     *         description = "更新套餐",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *    @SWG\Parameter(
     *     in="query",
     *     name="id",
     *     type="string",
     *     description="套餐id",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="title",
     *     type="string",
     *     description="套餐名",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="type",
     *     type="integer",
     *     description="套餐类型：1.小时套餐  2.计时套餐",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="duration",
     *     type="integer",
     *     description="套餐时长",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="price",
     *     type="number",
     *     description="套餐价格",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="renew_price",
     *     type="number",
     *     description="每半小时续费单价",
     *     required=false,
     *   )
     * )
     */
    public function actionUpdate($id): array
    {
        try {
            $model = $this->findModel($id);
            $data = Yii::$app->request->post();

            if ($model->load($data, '') && $model->save()) {
                return ResultHelper::json(200, '编辑成功', $model->toArray());
            } else {
                $msg = ErrorsHelper::getModelError($model);

                return ResultHelper::json(400, $msg);
            }
        } catch (NotFoundHttpException $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        }
    }

    /**
     * @SWG\Get(path="/diandi_tea/marketing/setmeal/delete",
     *    tags={"营销套餐"},
     *    summary="删除套餐",
     *     @SWG\Response(
     *         response = 200,
     *         description = "删除套餐",
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
     * Finds the TeaSetMeal model based on its primary key value.
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
        if (($model = TeaSetMeal::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
