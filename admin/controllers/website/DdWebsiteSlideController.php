<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-04-21 23:05:20
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-01-20 11:04:55
 */
 

namespace admin\controllers\website;

use Yii;
use common\models\DdWebsiteSlide;
use common\models\searchs\DdWebsiteSlideSearch;
use admin\controllers\AController;
use common\helpers\ResultHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DdWebsiteSlideController implements the CRUD actions for DdWebsiteSlide model.
 */
class DdWebsiteSlideController extends AController
{

    public $modelClass = '';
    protected $authOptional = [];

    
    /**
     * Lists all DdWebsiteSlide models.
     * @return mixed
     */
    public function actionIndex()
    {
        global $_GPC;
        $searchModel = new DdWebsiteSlideSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200,'获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DdWebsiteSlide model.
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
     * Creates a new DdWebsiteSlide model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        
        $model = new DdWebsiteSlide();

        if(Yii::$app->request->isPost){
            if ($model->load(Yii::$app->request->post(),'') && $model->save()) {
                return ResultHelper::json(200,'获取成功', [
                    'model' => $model,
                ]);
            }     
        }
        
    }

    /**
     * Updates an existing DdWebsiteSlide model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateitem()
    {
        
        global $_GPC;
        
        $id = $_GPC['id'];
        
        $model = $this->findModel($id);

        if(Yii::$app->request->isPost){
            if ($model->load(Yii::$app->request->post(),'') && $model->save()) {
                return ResultHelper::json(200,'获取成功', [
                    'model' => $model,
                ]);   
            }     
        }
        
    }

    /**
     * Deletes an existing DdWebsiteSlide model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeleteitem()
    {
        global $_GPC;
        
        $id = $_GPC['id'];
        $this->findModel($id)->delete();

        return ResultHelper::json(200,'删除成功');
    }

    /**
     * Finds the DdWebsiteSlide model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DdWebsiteSlide the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DdWebsiteSlide::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('请检查数据是否存在');
    }
}
