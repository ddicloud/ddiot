<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-02-29 18:32:46
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 17:01:06
 */

namespace admin\controllers\article;

use addons\diandi_soot\models\article\DdArticleCategory;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use common\models\DdArticle;
use common\models\searchs\DdArticleSearch;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * DdArticleController implements the CRUD actions for DdArticle model.
 */
class DdArticleController extends AController
{
    public $modelClass = 'common\models\DdArticle';

    public int $searchLevel = 0;


    public function actionCeshi(): array
    {
        return ResultHelper::json(200, '获取成功');
    }

    /**
     * Lists all DdArticle models.
     *
     * @return array
     */
    public function actionIndex(): array
    {
        $searchModel = new DdArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DdArticle model.
     *
     * @param int $id
     *
     * @return array
     *
     */
    public function actionView($id): array
    {
        return ResultHelper::json(200, '获取成功', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new DdArticle model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate(): array
    {
        $model = new DdArticle();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return ResultHelper::json(200, '新建成功', (array)$model);
        } else {

            $msg = ErrorsHelper::getModelError($model);
            return ResultHelper::json(500, $msg);
        }
    }

    /**
     * Updates an existing DdArticle model.
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
            return ResultHelper::json(200, '修改成功', (array)$model);

        }else{

            $msg = ErrorsHelper::getModelError($model);
            return ResultHelper::json(500, $msg);
        }
    }

    /**
     * Deletes an existing DdArticle model.
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
     * Finds the DdArticle model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return array
     *
     */
    protected function findModel($id): array
    {
        if (($model = DdArticle::findOne($id)) !== null) {
            return ResultHelper::json(200, '获取成功',(array)$model);
        }

        return ResultHelper::json(500, '请检查数据是否存在');
    }
}
