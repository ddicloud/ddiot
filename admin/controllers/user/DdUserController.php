<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-03-26 15:16:13
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 17:01:48
 */

namespace admin\controllers\user;

use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use common\models\DdUser;
use common\models\DdUserSearch;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * DdUserController implements the CRUD actions for DdUser model.
 */
class DdUserController extends AController
{
    public $modelClass = '';

    public int $searchLevel = 0;

    /**
     * Lists all DdUser models.
     *
     * @return array
     */
    public function actionIndex(): array
    {
        $searchModel = new DdUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DdUser model.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id): array
    {
        return ResultHelper::json(200, '获取成功', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new DdUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate(): array
    {
        $model = new DdUser();

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return ResultHelper::json(200, '添加成功', [
                'model' => $model,
            ]);
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }
    }

    /**
     * Updates an existing DdUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
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

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return ResultHelper::json(200, '获取成功', [
                'model' => $model,
            ]);
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }
    }

    public function actionProfile($id): array|\yii\web\Response
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->user_id]);
        }

        return ResultHelper::json(200, '获取成功', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DdUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id): array
    {
        $this->findModel($id)->delete();

        return ResultHelper::json(200, '删除成功');
    }

    /**
     * Finds the DdUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return array the loaded model
     */
    protected function findModel($id): array
    {
        if (($model = DdUser::findOne($id)) !== null) {
            return ResultHelper::json(200, '获取成功',(array)$model);
        }

        return ResultHelper::json(500, '请检查数据是否存在');
    }
}
