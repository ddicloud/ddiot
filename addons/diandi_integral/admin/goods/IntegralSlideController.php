<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-07-18 09:49:30
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-06-15 16:35:46
 */


namespace addons\diandi_integral\admin\goods;

use Yii;
use addons\diandi_integral\models\IntegralSlide;
use addons\diandi_integral\models\searchs\IntegralSlide as IntegralSlideSearch;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;
use admin\controllers\AController;
use common\helpers\ResultHelper;
use common\helpers\ErrorsHelper;


/**
 * IntegralSlideController implements the CRUD actions for IntegralSlide model.
 */
class IntegralSlideController extends AController
{
    public string $modelSearchName = "IntegralSlideSearch";

    public $modelClass = '';


    /**
     * Lists all IntegralSlide models.
     * @return array
     */
    public function actionIndex(): array
    {
        $searchModel = new IntegralSlideSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single IntegralSlide model.
     * @param integer $id
     * @return array|object[]|string[]
     */
    public function actionView($id): array
    {
        $model = IntegralSlide::find()->where(['id' => $id])->asArray()->one();

        $model['blocs'] = [$model['bloc_id'], $model['store_id']];

        return ResultHelper::json(200, '获取成功', $model);

    }

    /**
     * Creates a new IntegralSlide model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return array
     */
    public function actionCreate(): array
   {
        $model = new IntegralSlide();

        $data = \Yii::$app->request->input();
        $blocs =\Yii::$app->request->input('blocs');
        $data['bloc_id'] = $blocs[1];
        $data['store_id'] = $blocs[0];

        if ($model->load($data, '') && $model->save()) {

            return ResultHelper::json(200, '创建成功', $model->toArray());
        } else {
            $msg = ErrorsHelper::getModelError($model);
            return ResultHelper::json(400, $msg);
        }

    }

    /**
     * Updates an existing IntegralSlide model.
     * If the update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id): array
   {

        $model = $this->findModel($id);


        $data = \Yii::$app->request->input();
        $blocs =\Yii::$app->request->input('blocs');
        $data['bloc_id'] = $blocs[0];
        $data['store_id'] = $blocs[1];
        if ($model->load($data, '') && $model->save()) {

            return ResultHelper::json(200, '编辑成功', $model->toArray());
        } else {
            $msg = ErrorsHelper::getModelError($model);
            return ResultHelper::json(400, $msg);
        }

    }

    /**
     * Deletes an existing IntegralSlide model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return array
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
     * Finds the IntegralSlide model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return array|ActiveRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): array|\yii\db\ActiveRecord
    {
        if (($model = IntegralSlide::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
