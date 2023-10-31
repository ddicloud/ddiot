<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-11 16:41:45
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-01 18:27:12
 */


namespace common\plugins\diandi_hub\backend\setting;

use common\plugins\diandi_hub\models\Searchs\pickup\HubShopAreas;
use Yii;
use backend\controllers\BaseController;
use common\helpers\LevelTplHelper;
use common\helpers\ResultHelper;
use common\models\DdRegion;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AreaController implements the CRUD actions for DdShopAreas model.
 */
class AreaController extends BaseController
{
    public $modelSearchName = 'DdShopAreas';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs']=[
            'class' => VerbFilter::class,
            'actions' => [
                'delete' => ['POST'],
            ],
        ];
        return $behaviors;
    }

    /**
     * Lists all DdShopAreas models.
     * @return array
     */
    public function actionIndex()
    {
        $searchModel = new HubShopAreas();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DdShopAreas model.
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
     * Creates a new DdShopAreas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return array
     */
    public function actionCreate()
    {
        $model = new HubShopAreas();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->area_id]);
        }

        $region = new DdRegion();
        $Helper = new LevelTplHelper([
            'pid' => 'pid',
            'cid' => 'id',
            'title' => 'name',
            'model' => $region,
            'id' => 'id'
        ]);

        return $this->render('create', [
            'model' => $model,
            'Helper' => $Helper,
            'region' => $region,
        ]);
    }

    /**
     * Updates an existing DdShopAreas model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->area_id]);
        }
        $region = new DdRegion();
        $Helper = new LevelTplHelper([
            'pid' => 'pid',
            'cid' => 'id',
            'title' => 'name',
            'model' => $region,
            'id' => 'id'
        ]);
        return $this->render('update', [
            'model' => $model,
            'Helper' => $Helper,
            'region' => $region,
        ]);
    }

    /**
     * 设置默认
     *
     * @return void
     */
    public function actionSetdefault(){
        if (Yii::$app->request->isPost) {
            $pk = Yii::$app->request->post('pk');
            $id = unserialize(base64_decode($pk));
            $files = Yii::$app->request->post('name');
            $value = Yii::$app->request->post('value');
            $DdShopAreas = new HubShopAreas();
            
            HubShopAreas::updateAll([
                $files=>0
            ],[    
                'bloc_id'=>Yii::$app->params['bloc_id'],
                'store_id'=>Yii::$app->params['store_id'],
            ]);
           $Res = HubShopAreas::updateAll([$files=>$value=='是'?1:0],['area_id'=>$id]);
           return ResultHelper::json(200, '修改成功', []);
        
        }
    }

    /**
     * Deletes an existing DdShopAreas model.
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
     * Finds the DdShopAreas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DdShopAreas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubShopAreas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
