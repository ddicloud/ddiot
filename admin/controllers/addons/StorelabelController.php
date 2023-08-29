<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-06-05 16:03:25
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-04-04 21:20:47
 */

namespace admin\controllers\addons;

use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use diandi\addons\models\searchs\StoreLabelSearch;
use diandi\addons\models\StoreLabel;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * StorelabelController implements the CRUD actions for StoreLabel model.
 */
class StorelabelController extends AController
{
    public string $modelSearchName = 'StoreLabelSearch';

    public $modelClass = '';

    // 根据公司检索字段,不参与检索设置为false
    public string $blocField = '';

    // 根据商户检索字段,不参与检索设置为false
    public string $storeField = '';

    /**
     * Lists all StoreLabel models.
     *
     * @return array
     */
    public function actionIndex(): array
    {
        $searchModel = new StoreLabelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StoreLabel model.
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
     * Creates a new StoreLabel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate(): array
    {
        $model = new StoreLabel();

        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();

            if ($model->load($data, '') && $model->save()) {
                return ResultHelper::json(200, '创建成功', (array)$model);
            } else {
                $msg = ErrorsHelper::getModelError($model);

                return ResultHelper::json(400, $msg);
            }
        }
    }

    /**
     * Updates an existing StoreLabel model.
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

        if (Yii::$app->request->isPut) {
            $data = Yii::$app->request->post();

            if ($model->load($data, '') && $model->save()) {
                return ResultHelper::json(200, '编辑成功', (array)$model);
            } else {
                $msg = ErrorsHelper::getModelError($model);

                return ResultHelper::json(400, $msg);
            }
        }
    }

    /**
     * Deletes an existing StoreLabel model.
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
     * Finds the StoreLabel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return array the loaded model
     */
    protected function findModel($id): array
    {
        if (($model = StoreLabel::findOne($id)) !== null) {
            return ResultHelper::json(200, '获取成功',(array)$model);
        }

        return ResultHelper::json(500, '请检查数据是否存在');
    }
}
