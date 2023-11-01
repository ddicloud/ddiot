<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-11 22:12:48
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-08 17:49:01
 */
 

namespace common\plugins\diandi_hub\backend\member;

use Yii;
use common\plugins\diandi_hub\models\level\HubLevelBaseConf;
use common\plugins\diandi_hub\models\Searchs\level\HubLevelBaseConf as HubLevelBaseConfSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BaseController;
use common\plugins\diandi_hub\models\enums\LevelStatus;
use common\plugins\diandi_hub\models\level\HubLevel;

/**
 * BaseconfController implements the CRUD actions for HubLevelBaseConf model.
 */
class BaseconfController extends BaseController
{
    public $modelSearchName = "HubLevelBaseConfSearch";
    
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
     * Lists all HubLevelBaseConf models.
     * @return array
     */
    public function actionIndex()
    {
        global $_GPC;
        $levelnum = intval(Yii::$app->request->input('levelnum'));
        $searchModel = new HubLevelBaseConfSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'levelnum' => $levelnum,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HubLevelBaseConf model.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        global $_GPC;
        $levelnum = intval(Yii::$app->request->input('levelnum'));
        return $this->render('view', [
            'levelnum' => $levelnum,
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new HubLevelBaseConf model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return array
     */
    public function actionCreate()
    {
        global $_GPC;
        $levelnum = intval(Yii::$app->request->input('levelnum'));

        $model = new HubLevelBaseConf();
      
        $levels = LevelStatus::listData();
        
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id,'levelnum' => $levelnum]);
        }

        return $this->render('create', [
            'levelnum' => $levelnum,
            'levels' => $levels,
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing HubLevelBaseConf model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        global $_GPC;
        $levelnum = intval(Yii::$app->request->input('levelnum'));
        $model = $this->findModel($id);
      
        $levels = LevelStatus::listData();
         
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id,'levelnum' => $levelnum]);
        }

        return $this->render('update', [
            'levelnum' => $levelnum,
            'levels' => $levels,
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing HubLevelBaseConf model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        global $_GPC;
        $levelnum = intval(Yii::$app->request->input('levelnum'));

        $this->findModel($id)->delete();

        return $this->redirect(['index','levelnum' => $levelnum]);
    }

    /**
     * Finds the HubLevelBaseConf model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HubLevelBaseConf the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubLevelBaseConf::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
