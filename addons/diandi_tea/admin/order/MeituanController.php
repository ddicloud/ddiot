<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-30 14:45:19
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-30 16:45:03
 */

namespace addons\diandi_tea\admin\order;

use addons\diandi_tea\models\order\TeaMeituan;
use addons\diandi_tea\models\searchs\order\TeaMeituan as TeaMeituanSearch;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

/**
 * MeituanController implements the CRUD actions for TeaMeituan model.
 */
class MeituanController extends AController
{
    public string $modelSearchName = 'TeaMeituan';

    public $modelClass = '';

    /**
     * Lists all TeaMeituan models.
     *
     * @return mixed
     */
    public function actionIndex(): array
    {
        $searchModel = new TeaMeituanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TeaMeituan model.
     *
     * @param int $id
     *
     * @return array|object[]|string[]
     *
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
     * Creates a new TeaMeituan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate(): array
    {
        $model = new TeaMeituan();

        $data = Yii::$app->request->post();

        if ($model->load($data, '') && $model->save()) {
            return ResultHelper::json(200, '创建成功', $model->toArray());
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }
    }

    /**
     * Updates an existing TeaMeituan model.
     * If the update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return array
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
     * Deletes an existing TeaMeituan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     *
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
     * Finds the TeaMeituan model based on its primary key value.
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
        if (($model = TeaMeituan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
