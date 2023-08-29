<?php

namespace addons\diandi_website\admin;

use Yii;
use addons\diandi_website\models\WebsitePriceSon;
use addons\diandi_website\models\searchs\WebsitePriceSon as WebsitePriceSonSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BaseController;
use admin\controllers\AController;
use common\helpers\ResultHelper;
use common\helpers\ErrorsHelper;


/**
 * PriceSonController implements the CRUD actions for WebsitePriceSon model.
 */
class PriceSonController extends AController
{
    public string $modelSearchName = "WebsitePriceSonSearch";
    
    public $modelClass = '';
  

    /**
     * Lists all WebsitePriceSon models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WebsitePriceSonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WebsitePriceSon model.
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
     * Creates a new WebsitePriceSon model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new WebsitePriceSon();
        
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
     * Updates an existing WebsitePriceSon model.
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
     * Deletes an existing WebsitePriceSon model.
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
     * Finds the WebsitePriceSon model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WebsitePriceSon the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WebsitePriceSon::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
