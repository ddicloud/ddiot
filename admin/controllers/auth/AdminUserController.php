<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-10-31 13:35:34
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-04-04 10:02:29
 */

namespace admin\controllers\auth;

use admin\controllers\AController;
use admin\models\searchs\adminUser;
use admin\models\User;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

/**
 * AdminUserController implements the CRUD actions for User model.
 */
class AdminUserController extends AController
{
    public $modelClass = 'adminUser';

    public int $searchLevel = 0;

    /**
     * Lists all User models.
     *
     * @return array
     */
    public function actionIndex(): array
    {
        $searchModel = new adminUser();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id): array
    {
        $view = $this->findModel($id);

        return ResultHelper::json(200, '获取成功', (array)$view);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate(): array
    {
        $model = new User();

        $data = Yii::$app->request->post();

        if ($model->load($data, '') && $model->save()) {
            return ResultHelper::json(200, '创建成功', (array)$model);
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }

    }

    /**
     * Updates an existing User model.
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

        $data = Yii::$app->request->post();

        if ($model->load($data, '') && $model->save()) {
            return ResultHelper::json(200, '编辑成功', (array)$model);
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }

    }


    public function actionDelete($id): array
    {
        $this->findModel($id)->delete();

        return ResultHelper::json(200, '删除成功');
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return array the loaded model
     *
     */
    protected function findModel($id): array
    {
        if (($model = User::findOne($id)) !== null) {
            return ResultHelper::json(20, '获取成功', (array)$model);
        }
        return ResultHelper::json(500, '请检查数据是否存在');
    }
}
