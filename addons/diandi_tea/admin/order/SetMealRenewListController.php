<?php

namespace addons\diandi_tea\admin\order;

use Yii;
use addons\diandi_tea\models\order\TeaSetMealRenewList;
use addons\diandi_tea\models\searchs\order\TeaSetMealRenewList as TeaSetMealRenewListSearch;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BaseController;
use admin\controllers\AController;
use common\helpers\ResultHelper;
use common\helpers\ErrorsHelper;


/**
 * SetMealRenewListController implements the CRUD actions for TeaSetMealRenewList model.
 */
class SetMealRenewListController extends AController
{
    public string $modelSearchName = "TeaSetMealRenewListSearch";

    public $modelClass = '';


    /**
     * Lists all TeaSetMealRenewList models.
     * @return mixed
     */
    public function actionIndex(): array
    {
        $searchModel = new TeaSetMealRenewListSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TeaSetMealRenewList model.
     * @param integer $id
     * @return mixed
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
     * Creates a new TeaSetMealRenewList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate(): array
    {
        $model = new TeaSetMealRenewList();

        $data = Yii::$app->request->post();

        if ($model->load($data, '') && $model->save()) {

            return ResultHelper::json(200, '创建成功', $model->toArray());
        } else {
            $msg = ErrorsHelper::getModelError($model);
            return ResultHelper::json(400, $msg);
        }

    }

    /**
     * Updates an existing TeaSetMealRenewList model.
     * If the update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
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
     * Deletes an existing TeaSetMealRenewList model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
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
     * Finds the TeaSetMealRenewList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return array|ActiveRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): array|\yii\db\ActiveRecord
    {
        if (($model = TeaSetMealRenewList::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
