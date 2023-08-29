<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-19 00:10:28
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 16:46:26
 */

namespace admin\controllers\auth;

use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use diandi\addons\models\StoreCategory;
use diandi\admin\models\searchs\StoreCategory as StoreCategorySearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * CategoryController implements the CRUD actions for StoreCategory model.
 */
class CategoryController extends AController
{
    public $modelClass = '';

    public string $modelSearchName = 'StoreCategorySearch';

    public int $searchLevel = 0;



    /**
     * Lists all StoreCategory models.
     *
     * @return array
     */
    public function actionIndex(): array
    {
        $searchModel = new StoreCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StoreCategory model.
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
     * Creates a new StoreCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate(): array
    {
        $model = new StoreCategory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return ResultHelper::json(200, '获取成功',['view', 'id' => $model->category_id]);
        }

        $where['parent_id'] = 0;

        $catedata = $model::find()->where($where)->asArray()->all();
        array_unshift($catedata, ['category_id' => 0, 'name' => '顶级分类']);

        return  ResultHelper::json(200,'获取成功', [
            'model' => $model,
            'catedata' => $catedata,
        ]);
    }

    /**
     * Updates an existing StoreCategory model.
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return  ResultHelper::json(200,'获取成功',['view', 'id' => $model->category_id]);
        }else{
            $msg = ErrorsHelper::getModelError($model);
            return  ResultHelper::json(500,$msg);
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
     */
    public function actionDelete($id): array
    {
        $this->findModel($id)->delete();
        return  ResultHelper::json(200,'删除成功');
    }

    /**
     * Finds the StoreCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return StoreCategory the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): array
    {
        if (($model = StoreCategory::findOne($id)) !== null) {
            return ResultHelper::json(200, '获取成功',(array)$model);
        }

        return ResultHelper::json(500, '请检查数据是否存在');
    }
}
