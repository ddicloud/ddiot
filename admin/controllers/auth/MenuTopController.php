<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-06-05 16:03:25
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 16:46:35
 */

namespace admin\controllers\auth;

use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use diandi\admin\models\MenuTop;
use diandi\admin\models\searchs\MenuTopSearch;
use Yii;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

/**
 * MenuTopController implements the CRUD actions for MenuTop model.
 */
class MenuTopController extends AController
{
    public string $modelSearchName = 'MenuTopSearch';

    public $modelClass = '';

    public int $searchLevel = 0;

    /**
     * Lists all MenuTop models.
     *
     * @return array
     */
    public function actionIndex(): array
    {
        $searchModel = new MenuTopSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MenuTop model.
     *
     * @param int $id
     *
     * @return array
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
     * Creates a new MenuTop model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate(): array
    {

        $model = new MenuTop();

        $data = Yii::$app->request->post();
        if (!empty($data['module_name'])) {
            $data['mark'] = $data['module_name'];
        }
        if ($model->load($data, '') && $model->save()) {
            return ResultHelper::json(200, '创建成功', $model->toArray());
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }

    }

    /**
     * Updates an existing MenuTop model.
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
        if (!empty($data['module_name'])) {
            $data['mark'] = $data['module_name'];
        }
        if ($model->load($data, '') && $model->save()) {
            return ResultHelper::json(200, '编辑成功', $model);
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }

    }

    /**
     * Deletes an existing MenuTop model.
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
     * Finds the MenuTop model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return array|MenuTop
     */
    protected function findModel($id): array|\yii\db\ActiveRecord
    {
        if (($model = MenuTop::findOne($id)) !== null) {
            return $model;
        }

        return ResultHelper::json(500, '请检查数据是否存在');
    }
}
