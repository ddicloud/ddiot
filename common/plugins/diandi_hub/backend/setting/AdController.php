<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-10 23:50:31
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-13 03:31:39
 */
 

namespace common\plugins\diandi_hub\backend\setting;

use Yii;
use common\plugins\diandi_hub\models\advertising\HubLocationAd;
use common\plugins\diandi_hub\models\Searchs\location\HubLocationAd as HubLocationAdSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BaseController;
use common\plugins\diandi_hub\models\enums\locationType;
use common\plugins\diandi_hub\services\LocationService;
use common\helpers\ArrayHelper;

/**
 * AdController implements the CRUD actions for HubLocationAd model.
 */
class AdController extends BaseController
{
    public $modelSearchName = "HubLocationAdSearch
";
    
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
     * Lists all HubLocationAd models.
     * @return array
     */
    public function actionIndex()
    {
        $searchModel = new HubLocationAdSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HubLocationAd model.
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
     * Creates a new HubLocationAd model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return array
     */
    public function actionCreate()
    {
        $model = new HubLocationAd();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        
        $type = locationType::getValueByName('图片');
        
        $locations = LocationService::getLocation($type);

        return $this->render('create', [
            'model' => $model,
            'locations' => ArrayHelper::map($locations, 'id','name'),
        ]);
    }

    /**
     * Updates an existing HubLocationAd model.
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

        $type = locationType::getValueByName('图片');
        
        $locations = LocationService::getLocation($type);
        
        return $this->render('update', [
            'model' => $model,
            'locations' =>ArrayHelper::map($locations, 'id','name'),
        ]);
    }

    /**
     * Deletes an existing HubLocationAd model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the HubLocationAd model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HubLocationAd the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubLocationAd::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
