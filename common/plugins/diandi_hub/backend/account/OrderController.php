<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-02 15:14:42
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-29 17:30:17
 */
 

namespace common\plugins\diandi_hub\backend\account;

use Yii;
use common\plugins\diandi_hub\models\account\HubAccountOrder;
use common\plugins\diandi_hub\models\enums\EarningsStatus;
use common\plugins\diandi_hub\models\enums\OrderTypeStatus;
use common\plugins\diandi_hub\models\enums\WithdrawStatus;
use common\plugins\diandi_hub\models\enums\WithdrawTypeStatus;
use common\plugins\diandi_hub\models\Searchs\account\HubAccountOrder as HubAccountOrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BaseController;
use common\helpers\DateHelper;
use common\helpers\FileHelper;
use common\helpers\ImageHelper;
use common\helpers\phpexcel\ExportModel;
use common\helpers\ResultHelper;
use yii\helpers\Html;

/**
 * OrderController implements the CRUD actions for HubAccountOrder model.
 */
class OrderController extends BaseController
{
    public $modelSearchName = "HubAccountOrderSearch";
    
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
     * Lists all HubAccountOrder models.
     * @return array
     */
    public function actionIndex()
    {
        $searchModel = new HubAccountOrderSearch();
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
      
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HubAccountOrder model.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $model = HubAccountOrder::find()->with([
            'orderGoods','order',
            'goodsSpec','goodsSpecRel','goodsShare',
            'memberc','member',
            'levelc','level'
        ])->where(['id'=>$id])->one();
        
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new HubAccountOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return array
     */
    public function actionCreate()
    {
        $model = new HubAccountOrder();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing HubAccountOrder model.
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

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing HubAccountOrder model.
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

    
    public function actionExportdatalist()
    {
        global $_GPC;
       
        $query = HubAccountOrder::find();
 
        $query->with([
            'orderGoods',
            'goodsSpec','goodsSpecRel','goodsShare',
            'memberc','member',
            'levelc','level'
        ]);
        
        $between_time =\Yii::$app->request->input('between_time');
   

        $timeWhere = [];
        if(!empty($between_time[0])){
            $start_time = DateHelper::dateToInt($between_time[0]);
            $end_time = DateHelper::dateToInt($between_time[1]);
            $timeWhere = ['between','create_time',$start_time, $end_time];
        }
        
        $list = $query->where($timeWhere)->all();
      
        if (!empty($list)) {
            
            $fileName = '订单'.date('Y-m-d H:i:s', time()).'.xls';
            $savePath = yii::getAlias('@attachment/diandi_hub/excel/accountorder/'.date('Y/m/d/',time()));
            FileHelper::mkdirs($savePath);
            $Res = ExportModel::widget([
                'models' => $list,  // 必须
                'fileName' => $fileName,  // 默认为:'excel.xls'
                'asAttachment' => false,  // 默认值, 可忽略
                'savePath'=>$savePath,
                'columns' => [
                    [
                        'header' => '订单编号',
                        'format' => ['raw'],
                        'value' => function ($model) {
                            return $model->order_type == OrderTypeStatus::getValueByName('到店订单')?$model->storeOrder['order_no']:$model->order['order_no'];     
                            
                        }
                    ],
                    // [
                    //     'label' => '资金状态',
                    //     'format' => ['raw'],
                    //     'attribute' => 'status',
                    //     'value' => function ($model) {
                            
                    //         return AccountAudit::getLabel($model->status);     
                            
                    //     }
                    // ],
                    [
                        'header' => '下单人',
                        'format' => ['raw'],
                        'attribute' => 'member_id',
                        'value' => function ($model) {
                            $html = ''; 
                            $html .=   '会员ID：'.$model->member_id.'('.$model->level['levelname'].')';          
                            $html .=   '/会员名称：'.$model->member['username'];          
                            return $html;
                            
                        }
                    ],
                    [
                        'header' => '受益人',
                        'attribute' => 'memberc_id',
                        'value' => function ($model) {
                            $html = ''; 
                            $html .=   '会员ID：'.$model->memberc_id.'('.$model->levelc['levelname'].')';          
                            $html .=   '/会员名称：'.$model->memberc['username'];          
                            return $html;
                            
                        }
                    ],
                    [
                        'header' => '订单类型',
                        'format' => ['raw'],
                        'attribute' => 'order_type',
                        'value' => function ($model) {
                            return OrderTypeStatus::getLabel($model->order_type);     
                        }
                    ],
                    [
                        'header' => '分佣类型',
                        'format' => ['raw'],
                        'attribute' => 'type',
                        'value' => function ($model) {
                            return EarningsStatus::getLabel($model->type);     
                        }
                    ],
                    'money',
                    //'type',
                    //'performance',
                    //'order_goods_id',
                    //'order_type',
                    //'goods_type',
                    //'order_id',
                    //'order_price',
                    //'goods_id',
                    //'goods_price',
                    //'update_time:datetime',
                    //'create_time:datetime',
                ]
            ]);
                
            return ResultHelper::json(200,'下载成功',[
                'url'=>ImageHelper::tomedia('diandi_hub/excel/accountorder/'.date('Y/m/d/',time()). $fileName)
            ]);
        } else {
            return ResultHelper::json(400,'没有可以下载的数据');
        }
    }
    

    /**
     * Finds the HubAccountOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HubAccountOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubAccountOrder::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
