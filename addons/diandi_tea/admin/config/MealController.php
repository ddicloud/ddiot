<?php

namespace addons\diandi_tea\admin\config;

use Yii;
use addons\diandi_tea\models\config\TeaHourseMeal;
    use addons\diandi_tea\models\searchs\config\TeaHourseMeal as TeaHourseMealSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use admin\controllers\AController;
use common\helpers\ResultHelper;
use common\helpers\ErrorsHelper;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use Throwable;

/**
* MealController implements the CRUD actions for TeaHourseMeal model.
*/
class MealController extends AController
{
public string $modelSearchName = "TeaHourseMealSearch";

public $modelClass = '';


/**
* Lists all TeaHourseMeal models.
* @return array
*/
public function actionIndex(): array
{
    $searchModel = new TeaHourseMealSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return ResultHelper::json(200, '获取成功',[
    'searchModel' => $searchModel,
    'dataProvider' => $dataProvider,
    'modelSearchName'=>$this->modelSearchName,
    'field' => $searchModel->attributeLabels()
    ]);
}

/**
* Displays a single TeaHourseMeal model.
* @param integer $id
* @return array
* @throws NotFoundHttpException if the model cannot be found
*/
public function actionView($id): array
{
    $view = $this->findModel($id);

    return ResultHelper::json(200, '获取成功', $view->toArray());
}

/**
* Creates a new TeaHourseMeal model.
* If creation is successful, the browser will be redirected to the 'view' page.
* @return array
*/
public function actionCreate(): array
{
    $model = new TeaHourseMeal();
    $data = Yii::$app->request->post();
    if ($model->load($data, '') && $model->save()) {
        return ResultHelper::json(200, '创建成功', $model->toArray());
    } else {
        $msg = ErrorsHelper::getModelError($model);
        return ResultHelper::json(400, $msg);
    }
}

/**
* Updates an existing TeaHourseMeal model.
* If update is successful, the browser will be redirected to the 'view' page.
* @param integer $id
* @return array
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
* Deletes an existing WeihExhibitionServiceProvider model.
* If deletion is successful, the browser will be redirected to the 'index' page.
* @param integer $id
* @return array
* @throws NotFoundHttpException if the model cannot be found
* @throws Throwable
* @throws StaleObjectException
*/
public function actionDelete($id): array
{
    $this->findModel($id)->delete();

    return ResultHelper::json(200, '删除成功');
}

/**
* Finds the TeaHourseMeal model based on its primary key value.
* If the model is not found, a 404 HTTP exception will be thrown.
* @param integer $id
* @return array|ActiveRecord the loaded model
* @throws NotFoundHttpException if the model cannot be found
*/
protected function findModel($id): array|ActiveRecord
{
if (($model = TeaHourseMeal::findOne($id)) !== null) {
return $model;
}

throw new NotFoundHttpException('The requested page does not exist.');
}
}