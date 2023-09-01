<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-06-05 16:03:24
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-04-06 15:21:17
 */

namespace admin\controllers\addons;

use admin\controllers\AController;
use common\helpers\ArrayHelper;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use diandi\addons\models\searchs\StoreCategory as StoreCategorySearch;
use diandi\addons\models\StoreCategory;
use Yii;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

/**
 * CategoryController implements the CRUD actions for StoreCategory model.
 */
class CategoryController extends AController
{
    public string $modelSearchName = 'StoreCategory';

    public $modelClass = '';


    // 根据公司检索字段,不参与检索设置为false
    public string $blocField = '';

    // 根据商户检索字段,不参与检索设置为false
    public string $storeField = '';

    /**
     * Lists all StoreCategory models.
     *
     * @return array
     */
    public function actionIndex(): array
    {
        $searchModel = new StoreCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider = ArrayHelper::objectToarray($dataProvider);

        $parentMent = $dataProvider['allModels'];
        $lists = [];

        if ($parentMent && is_array($parentMent)) {
            $lists = ArrayHelper::itemsMerge($parentMent, 0, 'category_id', 'parent_id', 'children');
            if (empty($lists)) {
                $lists = $parentMent;
            }
        }




        return ResultHelper::json(200, '获取成功', [
            'list' => $lists,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCategory(): array
    {

        $list = StoreCategory::find()->where(['parent_id' => 0])->select(['name as text', 'category_id as value'])->asArray()->all();

        return ResultHelper::json(200, '获取成功', $list);
    }

    /**
     * Displays a single StoreCategory model.
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
     * Creates a new StoreCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate(): array
    {
        $model = new StoreCategory();

        $data = Yii::$app->request->post();

        if ($model->load($data, '') && $model->save()) {
            return ResultHelper::json(200, '创建成功', $model->toArray());
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }
    }

    /**
     * Updates an existing StoreCategory model.
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
            return ResultHelper::json(200, '编辑成功', $model->toArray());
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }
    }

    /**
     * Deletes an existing StoreCategory model.
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
     * Finds the StoreCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return array|StoreCategory
     *
     */
    protected function findModel($id): array|\yii\db\ActiveRecord
    {
        if (($model = StoreCategory::findOne($id)) !== null) {
            return $model;
        }

        return ResultHelper::json(500, '请检查数据是否存在');
    }
}
