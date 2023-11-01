<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-20 01:45:07
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-03-02 12:27:02
 */
 

namespace common\plugins\diandi_hub\backend\store;

use Yii;
use common\plugins\diandi_hub\models\store\HubAccountStorePay;
use common\plugins\diandi_hub\models\Searchs\store\HubAccountStorePay as HubAccountStorePaySearch;
use common\plugins\diandi_hub\services\StoreService;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BaseController;
use common\helpers\loggingHelper;

/**
 * StorepayController implements the CRUD actions for HubAccountStorePay model.
 */
class StorepayController extends BaseController
{
    public $modelName = 'HubAccountStorePay';

    
    public $modelSearchName = "HubAccountStorePay";
    
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
     * Lists all HubAccountStorePay models.
     * @return array
     */
    public function actionIndex()
    {
        $searchModel = new HubAccountStorePaySearch();
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HubAccountStorePay model.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        
        $model =  HubAccountStorePay::find()->where(['id'=>$id])->with(['member','affirm','operation'])->one();
        
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new HubAccountStorePay model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return array
     */
    public function actionCreate()
    {
        $model = new HubAccountStorePay();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing HubAccountStorePay model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
   {
        $model = HubAccountStorePay::find()->where(['id'=>$id])->with(['userbank'])->one();
        
        $member_id = $model['member_id'];

     

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if(Yii::$app->request->input('HubAccountStorePay')['status'] == 2){
            
                $Res = StoreService::thawMoney($id);      
                
                loggingHelper::writeLog('diandi_hub', 'StoreService/thawMoney', '后台确认订单结果',$Res);
                
            }
    
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing HubAccountStorePay model.
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
     * Finds the HubAccountStorePay model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HubAccountStorePay the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubAccountStorePay::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
