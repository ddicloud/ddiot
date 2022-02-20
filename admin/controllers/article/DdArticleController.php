<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-02-29 18:32:46
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-04-22 01:07:26
 */


namespace admin\controllers\article;

use Yii;
use common\models\DdArticle;
use common\models\searchs\DdArticleSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use admin\controllers\AController;
use common\models\DdArticleCategory;
use common\helpers\LevelTplHelper;
use common\helpers\ResultHelper;

/**
 * DdArticleController implements the CRUD actions for DdArticle model.
 */
class DdArticleController extends AController
{
    public $modelClass = 'common\models\DdArticle';

    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config' => [
                    "imageUrlPrefix"  => "http://www.cc.com", //图片访问路径前缀
                    "imagePathFormat" => "/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}" //上传保存路径
                ],
            ]
        ];
    }

    public function actionCeshi()
    {
        return ResultHelper::json(200,'获取成功');
    }
    
    /**
     * Lists all DdArticle models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DdArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
     

        return ResultHelper::json(200,'获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DdArticle model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return ResultHelper::json(200,'获取成功', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new DdArticle model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DdArticle();

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $model->load(Yii::$app->request->post());
                print_r($model->attributes);
                return $this->error($model, 'index');
            }
        }

        $modelcate = new DdArticleCategory();

        $Helper = new LevelTplHelper([
            'pid' => 'pcate',
            'cid' => 'id',
            'title' => 'title',
            'model' => $modelcate,
            'id' => 'id'
        ]);


        return ResultHelper::json(200,'获取成功', [
            'model' => $model,
            'Helper' => $Helper,
        ]);
    }

    /**
     * Updates an existing DdArticle model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $modelcate = new DdArticleCategory();
        $Helper = new LevelTplHelper([
            'pid' => 'pcate',
            'cid' => 'id',
            'title' => 'title',
            'model' => $modelcate,
            'id' => 'id'
        ]);


        return ResultHelper::json(200,'获取成功', [
            'model' => $model,
            'Helper' => $Helper,
        ]);
    }

    /**
     * Deletes an existing DdArticle model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return ResultHelper::json(200,'删除成功');
    }

    /**
     * Finds the DdArticle model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DdArticle the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DdArticle::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('请检查数据是否存在');
    }
}
