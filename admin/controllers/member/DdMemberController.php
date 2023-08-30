<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-06-05 16:03:25
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-03-03 15:59:37
 */

namespace admin\controllers\member;

use admin\controllers\AController;
use admin\models\searchs\DdMemberSearch;
use api\models\DdMember;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

/**
 * DdMemberController implements the CRUD actions for DdMember model.
 */
class DdMemberController extends AController
{
    public string $modelSearchName = 'DdMemberSearch';

    public $modelClass = '';

    /**
     * Lists all DdMember models.
     *
     * @return array
     */
    public function actionIndex(): array
    {
        $searchModel = new DdMemberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DdMember model.
     *
     * @param int $id
     *
     * @return array
     *
     */
    public function actionView($id): array
    {
        $view = $this->findModel($id);

        return ResultHelper::json(200, '获取成功', (array)$view);
    }

    /**
     * Creates a new DdMember model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate(): array
    {
        $model = new DdMember();

        $data = Yii::$app->request->post();

        if ($model->load($data, '') && $model->save()) {
            return ResultHelper::json(200, '创建成功', (array)$model);
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }

    }

    /**
     * Updates an existing DdMember model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return array
     *
     */
    public function actionUpdate($id): array
    {
        $model = $this->findModel($id);

        $data = Yii::$app->request->post();

        if ($model->load($data, '') && $model->save()) {
            return ResultHelper::json(200, '编辑成功', $model);
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }

    }

    /**
     * Deletes an existing DdMember model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return array
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
     * Finds the DdMember model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return array|ActiveRecord the loaded model
     */
    protected function findModel($id): array|\yii\db\ActiveRecord
    {
        if (($model = DdMember::findOne($id)) !== null) {
            return $model;
        }

        return ResultHelper::json(500, '请检查数据是否存在');
    }
}
