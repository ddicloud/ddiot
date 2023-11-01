<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-29 15:39:39
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-29 17:28:32
 */
 

namespace common\plugins\diandi_hub\backend\account;

use Yii;
use common\plugins\diandi_hub\models\account\HubAccountLog;
use common\plugins\diandi_hub\models\enums\AccountChangeStatus;
use common\plugins\diandi_hub\models\enums\AccountTypeStatus;
use common\plugins\diandi_hub\models\enums\GoodsTypeStatus;
use common\plugins\diandi_hub\models\enums\OrderTypeStatus;
use common\plugins\diandi_hub\models\Searchs\account\HubAccountLog as HubAccountLogSearch;
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
 * LogController implements the CRUD actions for HubAccountLog model.
 */
class LogController extends BaseController
{
    public $modelSearchName = "HubAccountLogSearch
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
     * Lists all HubAccountLog models.
     * @return array
     */
    public function actionIndex()
    {
        $searchModel = new HubAccountLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HubAccountLog model.
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
     * Creates a new HubAccountLog model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return array
     */
    public function actionCreate()
    {
        $model = new HubAccountLog();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing HubAccountLog model.
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
     * Deletes an existing HubAccountLog model.
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
        
        $between_time = Yii::$app->request->input('between_time');
        
        $query = HubAccountLog::find();
        
        $query->with(['goods','ordergoods','member']);
        
        $timeWhere = [];
        if(!empty($between_time[0])){
            $start_time = DateHelper::dateToInt($between_time[0]);
            $end_time = DateHelper::dateToInt($between_time[1]);
            $timeWhere = ['between','create_time',$start_time, $end_time];
        }
        
        $list = $query->where($timeWhere)->all();
        
        // foreach ($goodsList as $key => $value) {
        //     if(empty($value['order'])){
        //         $idss[$value['order_id']] = $value;
        //     }
        // }
        
        // p($where,$timeWhere,HubOrderGoods::find()->innerJoinWith(['order'=>function($query) use ($where,$timeWhere)
        // {
        //     $query->where($where);
        // }, 'address'])->select(['order_id', 'goods_name', 'goods_price', 'total_num','goods_attr'])->where($whereGoods)->andFilterWhere($timeWhere)->createCommand()->getRawSql(),$idss);
        // die;

        if (!empty($list)) {
         
            $fileName = '订单'.date('Y-m-d H:i:s', time()).'.xls';
            $savePath = yii::getAlias('@attachment/diandi_hub/excel/accountlog/'.date('Y/m/d/',time()));
            FileHelper::mkdirs($savePath);
            $Res = ExportModel::widget([
                'models' => $list,  // 必须
                'fileName' => $fileName,  // 默认为:'excel.xls'
                'asAttachment' => false,  // 默认值, 可忽略
                'savePath'=>$savePath,
                'columns' => [
                    'id',
                    [
                        'header' => '会员ID',
                        'attribute' => 'member_id',
                        'value' => function ($model) {
                            $html = ''; 
                            $html .=   '会员ID：'.$model->member_id;          
                            $html .=   '/会员名称：'.$model->member['username'];          
                            return $html;
                            
                        }
                    ],
                    [
                        'header' => '资金类型',
                        'format' => ['raw'],
                        'attribute' => 'account_type',
                        'value' => function ($model) {
                            return AccountTypeStatus::getLabel($model->account_type);     
                        }
                    ],
                    [
                        'header' => '资金变化类型',
                        'format' => ['raw'],
                        'attribute' => 'change_type',
                        'value' => function ($model) {
                            return AccountChangeStatus::getLabel($model->change_type);     
                        }
                    ],
                    'money',
                    [
                        'header' => '资金变化类型',
                        'format' => ['raw'],
                        'attribute' => 'is_add',
                        'value' => function ($model) {
                            return $model->is_add>0?'增加':'减少';     
                        }
                    ],
                    [
                        'header' => '订单编号',
                        'format' => ['raw'],
                        'value' => function ($model) {
                            return $model->order_type == OrderTypeStatus::getValueByName('到店订单')?$model->storeOrder['order_no']:$model->order['order_no'];     
                            
                        }
                    ],
                    // 'order_goods_id',
                    [
                        'header' => '订单类型',
                        'format' => ['raw'],
                        'attribute' => 'order_type',
                        'value' => function ($model) {
                            return OrderTypeStatus::getLabel($model->order_type);     
                        }
                    ],
                    [
                        'header' => '商品类型',
                        'format' => ['raw'],
                        'attribute' => 'goods_type',
                        'value' => function ($model) {
                            return  GoodsTypeStatus::getLabel($model->goods_type);     
                        }
                    ],
                    //'order_id',
                    'order_price',
                    'goods_id',
                    'goods_price',
                    'performance',
                ]
            ]);
                
            return ResultHelper::json(200,'下载成功',[
                'url'=>ImageHelper::tomedia('diandi_hub/excel/accountlog/'.date('Y/m/d/',time()). $fileName)
            ]);
        } else {
            return ResultHelper::json(400,'没有可以下载的数据');
        }
    }
    

    /**
     * Finds the HubAccountLog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HubAccountLog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubAccountLog::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
