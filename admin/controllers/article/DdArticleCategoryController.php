<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-29 03:13:52
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 17:01:01
 */

namespace admin\controllers\article;

use admin\controllers\AController;
use common\helpers\ResultHelper;
use common\models\DdArticleCategory;
use common\models\searchs\DdArticleCategorySearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * DdArticleCategoryController implements the CRUD actions for DdArticleCategory model.
 */
class DdArticleCategoryController extends AController
{
    public $modelClass = '';

    public $searchLevel = 0;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all DdArticleCategory models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DdArticleCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $catedata = [];
        $catedata = DdArticleCategory::find()->where(['pcate' => 0])->all();

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'catedata' => $catedata,
        ]);
    }

    /**
     * Displays a single DdArticleCategory model.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return ResultHelper::json(200, '获取成功', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new DdArticleCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DdArticleCategory();

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->error($model, 'index');
            }
        }

        $catedata = DdArticleCategory::find()->where(['pcate' => 0])->asArray()->all();

        return ResultHelper::json(200, '获取成功', [
            'model' => $model,
            'catedata' => $catedata,
        ]);
    }

    /**
     * Updates an existing DdArticleCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $catedata = [];
        $catedata = DdArticleCategory::find()->where(['pcate' => 0])->all();

        return ResultHelper::json(200, '获取成功', [
            'model' => $model,
            'catedata' => $catedata,
        ]);
    }

    /**
     * Deletes an existing DdArticleCategory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return ResultHelper::json(200, '删除成功');
    }

    /**
     * @return string
     */
    public function actionChildcate()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $data = Yii::$app->request->post();
            $parent_id = $data['parent_id'];
            $cates = DdArticleCategory::findAll(['pcate' => $parent_id]);

            return $cates;
        }
    }

    /**
     * Finds the DdArticleCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return DdArticleCategory the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DdArticleCategory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('请检查数据是否存在');
    }
}
