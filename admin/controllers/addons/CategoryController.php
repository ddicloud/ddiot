<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-06-05 16:03:24
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-06-10 14:33:04
 */


namespace admin\controllers\addons;

use Yii;
use diandi\addons\models\StoreCategory;
use diandi\addons\models\searchs\StoreCategory as StoreCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BaseController;
use admin\controllers\AController;
use common\helpers\ArrayHelper;
use common\helpers\ResultHelper;
use common\helpers\ErrorsHelper;


/**
 * CategoryController implements the CRUD actions for StoreCategory model.
 */
class CategoryController extends AController
{
    public $modelSearchName = "StoreCategorySearch";

    public $modelClass = '';


    /**
     * Lists all StoreCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StoreCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        $dataProvider = ArrayHelper::objectToarray($dataProvider);

        $parentMent = $dataProvider['allModels'];

        $lists = ArrayHelper::itemsMerge($parentMent, 0, 'category_id', 'parent_id', 'children');

        return ResultHelper::json(200, '获取成功', [
            'list' => $lists,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    public function actionCategory()
    {
        $list = StoreCategory::find()->where(['parent_id' => 0])->select(['name as text', 'category_id as value'])->asArray()->all();

        return ResultHelper::json(200, '获取成功', $list);
    }

    /**
     * Displays a single StoreCategory model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $view = $this->findModel($id);

        return ResultHelper::json(200, '获取成功', $view);
    }

    /**
     * Creates a new StoreCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StoreCategory();

        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();

            if ($model->load($data, '') && $model->save()) {

                return ResultHelper::json(200, '创建成功', $model);
            } else {
                $msg = ErrorsHelper::getModelError($model);
                return ResultHelper::json(400, $msg);
            }
        }
    }

    /**
     * Updates an existing StoreCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);


        if (Yii::$app->request->isPut) {
            $data = Yii::$app->request->post();

            if ($model->load($data, '') && $model->save()) {

                return ResultHelper::json(200, '编辑成功', $model);
            } else {
                $msg = ErrorsHelper::getModelError($model);
                return ResultHelper::json(400, $msg);
            }
        }
    }

    /**
     * Deletes an existing StoreCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return ResultHelper::json(200, '删除成功');
    }

    /**
     * Finds the StoreCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StoreCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StoreCategory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('请检查数据是否存在');
    }
}
