<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-01 11:49:31
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-11 22:12:25
 */
 

namespace common\plugins\diandi_hub\backend\level;


use Yii;
use common\plugins\diandi_hub\models\level\HubLevel;
use common\plugins\diandi_hub\models\Searchs\level\HubLevelSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BaseController;
use common\plugins\diandi_hub\models\enums\LevelStatus;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;

/**
 * LevelController implements the CRUD actions for HubLevel model.
 */
class LevelController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all HubLevel models.
     *
     * @return array
     */
    public function actionIndex()
    {
        $searchModel = new HubLevelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HubLevel model.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionDetail()
    {
        global $_GPC;
        $id =\Yii::$app->request->input('id');
        $detail = $this->findModel($id);
        
        return ResultHelper::json(200,'获取成功',$detail);
    }

    /**
     * Creates a new HubLevel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate()
    {
        $model = new HubLevel();
        
        $level = HubLevel::find()->select('levelnum')->asArray()->column();
        
        $levels = LevelStatus::listData();
       
        foreach ($level as $key => $value) {
            unset($levels[$value]);
        }

        if(Yii::$app->request->isPost){
            if ($model->load(Yii::$app->request->post(),'') && $model->save()) {
                return ResultHelper::json(200,'编辑成功',[]);
            }else{
                $msg = ErrorsHelper::getModelError($model);
                return ResultHelper::json(400,$msg,Yii::$app->request->post());
            }
        }

       

        return $this->render('create', [
            'model' => $model,
            'levels' =>$levels
        ]);
    }


    /**
     * Updates an existing HubLevel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate()
    {
        global $_GPC;
        
        $id =\Yii::$app->request->input('id');
        $model = $this->findModel($id);
         
        if(Yii::$app->request->isPost){
            if ($model->load(Yii::$app->request->post(),'') && $model->save()) {
                return ResultHelper::json(200,'编辑成功',[]);
            }else{
                $msg = ErrorsHelper::getModelError($model);
                return ResultHelper::json(400,$msg,Yii::$app->request->post());
            }
        }
            
        $level = HubLevel::find()->select('levelnum')->asArray()->column();
        
        $levels = LevelStatus::listData();


        return $this->render('update', [
            'model' => $model,
            'levels' =>$levels

        ]);
    }

    /**
     * Deletes an existing HubLevel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the HubLevel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return HubLevel the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubLevel::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
