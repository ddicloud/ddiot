<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-06 23:40:45
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-09 01:21:55
 */
 

namespace common\plugins\diandi_hub\backend\express;

use Yii;
use common\plugins\diandi_hub\models\express\HubExpressCompany;
use common\plugins\diandi_hub\models\Searchs\express\HubExpressCompany as HubExpressCompanySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BaseController;
use common\plugins\diandi_hub\models\express\HubExpressTemplateArea;
use common\helpers\ArrayHelper;
use common\helpers\ResultHelper;
use common\models\DdRegion;

/**
 * ExpressController implements the CRUD actions for HubExpressCompany model.
 */
class ExpressController extends BaseController
{
    public $modelSearchName = "HubExpressCompanySearch";
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'delete' => ['POST'],
            ],
        ];

        return $behaviors;
    }

    /**
     * Lists all HubExpressCompany models.
     * @return array
     */
    public function actionIndex()
    {
        $searchModel = new HubExpressCompanySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HubExpressCompany model.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new HubExpressCompany model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return array
     */
    public function actionCreate()
    {
        $model = new HubExpressCompany();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $express = HubExpressCompany::find()->where(['status'=>1])->asArray()->all();
        return $this->render('create', [
            'model' => $model,
            'express' => $express
        ]);
    }


  

    /**
     * Updates an existing HubExpressCompany model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $express = HubExpressCompany::find()->where(['status'=>1])->asArray()->all();

        return $this->render('update', [
            'model' => $model,
            'express' => $express
        ]);
    }

    /**
     * Deletes an existing HubExpressCompany model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        HubExpressTemplateArea::deleteAll(['template_id'=>$id]);
        return $this->redirect(['index']);
    }

    /**
     * Finds the HubExpressCompany model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HubExpressCompany the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubExpressCompany::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
