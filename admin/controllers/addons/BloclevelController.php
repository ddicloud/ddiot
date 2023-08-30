<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-06-03 17:40:00
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-04-04 20:03:27
 */

namespace admin\controllers\addons;

use admin\controllers\AController;
use admin\models\enums\LevelStatus;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use diandi\addons\models\BlocLevel;
use diandi\addons\models\searchs\BlocLevel as BlocLevelSearch;
use Yii;
use yii\db\StaleObjectException;

/**
 * BloclevelController implements the CRUD actions for BlocLevel model.
 */
class BloclevelController extends AController
{
    public string $modelSearchName = 'BlocLevel';

    public $modelClass = '';


    // 根据公司检索字段,不参与检索设置为false
    public string $blocField = '';

    // 根据商户检索字段,不参与检索设置为false
    public string $storeField = '';

    /**
     * Lists all BlocLevel models.
     *
     * @return array
     */
    public function actionIndex(): array
    {
        $searchModel = new BlocLevelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BlocLevel model.
     *
     * @param int $id
     *
     * @return array
     *
     */
    public function actionView($id): array
    {
        $view = $this->findModel($id);

        return ResultHelper::json(200, '获取成功', $view);
    }

    /**
     * Creates a new BlocLevel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate(): array
    {
        $model = new BlocLevel();

        $data = Yii::$app->request->post();

        if ($model->load($data, '') && $model->save()) {
            return ResultHelper::json(200, '创建成功', (array)$model);
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }
    }

    /**
     * Updates an existing BlocLevel model.
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
            return ResultHelper::json(200, '编辑成功', (array)$model);
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }
    }

    /**
     * Deletes an existing BlocLevel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionDelete($id): array
    {
        $this->findModel($id)->delete();

        return ResultHelper::json(200, '删除成功');
    }

    /**
     * Finds the BlocLevel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return array|BlocLevel
     *
     */
    protected function findModel($id): array|\yii\db\ActiveRecord
    {
        if (($model = BlocLevel::findOne($id)) !== null) {

            return $model;

        }
        return ResultHelper::json(500, '请检查数据是否存在');
    }

    public function actionLevels(): array
    {
        $list = LevelStatus::listData();

        $lists = [];

        foreach ($list as $key => $value) {
            $lists[] = [
                'text' => $value,
                'value' => $key,
            ];
        }

        return ResultHelper::json(200, '获取成功', $lists);
    }
}
