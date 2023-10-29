<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-26 03:34:01
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-29 15:45:43
 */
 

namespace common\plugins\diandi_hub\backend\member;

use Yii;
use common\plugins\diandi_hub\models\member\HubUserBank;
use common\plugins\diandi_hub\models\Searchs\member\HubUserBank as HubUserBankSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BaseController;
use common\helpers\FileHelper;
use common\helpers\ImageHelper;
use common\helpers\phpexcel\ExportModel;
use common\helpers\ResultHelper;

/**
 * BankController implements the CRUD actions for HubUserBank model.
 */
class BankController extends BaseController
{
    public $modelSearchName = "HubUserBankSearch
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
     * Lists all HubUserBank models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HubUserBankSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HubUserBank model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new HubUserBank model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new HubUserBank();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing HubUserBank model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate()
    {
        global $_GPC;
        
        $member_id = $_GPC['member_id'];

        $member = HubUserBank::find()->where(['member_id'=>$member_id])->one();
        if(empty($member)){
            Yii::$app->session->setFlash('error', "用户未设置收款账号,请关闭窗口");
            return $this->redirect(['index']);
        }
        $model =  $this->findModel($member['id']);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing HubUserBank model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    
    public function actionExportdatalist()
    {
        global $_GPC;
       
        $list = HubUserBank::find()->all();
    

        if (!empty($list)) {
           
            $fileName = '收款账户'.date('Y-m-d H:i:s', time()).'.xls';
            $savePath = yii::getAlias('@attachment/diandi_hub/excel/back/'.date('Y/m/d/',time()));
            FileHelper::mkdirs($savePath);
            $Res = ExportModel::widget([
                'models' => $list,  // 必须
                'fileName' => $fileName,  // 默认为:'excel.xls'
                'asAttachment' => false,  // 默认值, 可忽略
                'savePath'=>$savePath
            ]);
                
            return ResultHelper::json(200,'下载成功',[
                'url'=>ImageHelper::tomedia('/diandi_hub/excel/back/'.date('Y/m/d/',time()). $fileName)
            ]);
        } else {
            return ResultHelper::json(400,'没有可以下载的数据');
        }
    }
    

    /**
     * Finds the HubUserBank model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HubUserBank the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubUserBank::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
