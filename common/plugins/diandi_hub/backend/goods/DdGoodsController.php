<?php
/**
 * @Author: Wang chunsheng
 * @Date:   2020-04-29 15:40:49
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-11 11:19:24
 */

namespace common\plugins\diandi_hub\backend\goods;

use Yii;
use common\plugins\diandi_hub\models\DdGoods;
use backend\controllers\BaseController;
use common\plugins\diandi_hub\models\advertising\HubLocationGoods;
use common\plugins\diandi_hub\models\enums\GoodsTypeStatus;
use common\plugins\diandi_hub\models\express\HubExpressTemplate;
use common\plugins\diandi_hub\models\express\HubExpressTemplateArea;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use common\widgets\MyActiveForm;
use common\components\MyStringHelp;
use common\helpers\LevelTplHelper;
use common\plugins\diandi_hub\models\goods\HubCategory;
use common\plugins\diandi_hub\models\goods\HubGoods;
use common\plugins\diandi_hub\models\goods\HubGoodsBaseGoods;
use common\plugins\diandi_hub\models\goods\HubGoodsBaseSpec;
use common\plugins\diandi_hub\models\goods\HubGoodsBaseSpecRel;
use common\plugins\diandi_hub\models\goods\HubGoodsParam;
use common\plugins\diandi_hub\models\goods\HubGoodsSpec;
use common\plugins\diandi_hub\models\goods\HubSpec;
use common\plugins\diandi_hub\models\Searchs\goods\HubBaseGoodsSearch;
use common\helpers\ArrayHelper;
use common\helpers\ErrorsHelper;
use common\helpers\FileHelper;
use common\helpers\ImageHelper;
use common\helpers\phpexcel\ExportModel;
use common\helpers\ResultHelper;
use yii2mod\editable\EditableAction;
use yii\db\Transaction;
use yii\web\BadRequestHttpException;
use yii\widgets\ActiveForm;

/**
 * DdGoodsController implements the CRUD actions for DdGoods model.
 */
class DdGoodsController extends BaseController
{
    public $modelName = 'HubGoodsBaseGoods';

    public $modelSearchName = 'HubBaseGoodsSearch';

    public function actions()
    {
        return [
            'upload' => [
                'class' => 'common\widgets\ueditor\UEditorAction',
                'config' => [
                    // "imageUrlPrefix" => Yii::$App->request->hostInfo, //图片访问路径前缀
                    'imagePathFormat' => '../attachment/diandi_hub/image/{yyyy}{mm}{dd}/{time}{rand:6}', //上传保存路径
                    'imageMaxSize' => 10000000,
                    'imageCompressEnable' => true,
                ],
            ],
            'change-username' => [
                'class' => EditableAction::class,
                'modelClass' => DdGoods::class,
                'pkColumn' => 'goods_id',
            ],
        ];
    }

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
     * Lists all DdGoods models.
     *
     * @return array
     */
    public function actionIndex()
   {
        $searchModel = new HubBaseGoodsSearch();
        $searchWhere = $_GPC[$this->modelSearchName]; 
        if(!empty($searchWhere) && $searchWhere != 'undefined'){
            $where[$this->modelSearchName] = array_merge($searchWhere,Yii::$app->request->queryParams[$this->modelSearchName]);
        }else{
            $where = Yii::$app->request->queryParams;
        }
      
        $dataProvider = $searchModel->search($where);
        
        return $this->renderView('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCates()
    {
         // 商品分类
        
        $where = [];
    
        $bloc_id = Yii::$app->params['bloc_id'];
        $store_id = Yii::$app->params['store_id'];

        if ($bloc_id) {
            $where['bloc_id'] = $bloc_id;
        }

        if ($store_id) {
            $where['store_id'] = $store_id;
        }
        
        $list =  HubCategory::find()->select(['category_id','parent_id','name as label','category_id as value'])->where($where)->asArray()->all();

        $cates = ArrayHelper::itemsMerge($list,0,'category_id','parent_id','children',2);
        // 'cates' => $cates,
        
        return ResultHelper::json(200,'获取成功',$cates);
    }

    /**
     * Displays a single DdGoods model.
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

    public function goodsAdd()
    {
        $data = Yii::$app->request->post();
        $model = new HubGoodsBaseGoods();

        /* 基础信息 */
        $base = $data['HubGoodsBaseGoods'];
        $goods_base['HubGoodsBaseGoods'] = [
            'goods_name' => $base['goods_name'],
            'video' => $base['video'],
            'category_id' => $base['category_id'],
            'category_pid' => $base['category_pid'],
            'spec_type' => $base['spec_type'],
            'deduct_stock_type' => $base['deduct_stock_type'],
            'content' => str_replace('src="/backend/../attachment', 'width="100%" src="'.Yii::$app->request->hostInfo.'/attachment', $base['content']),
            'sales_initial' => $base['sales_initial'],
            'sales_actual' => $base['sales_actual'],
            'goods_sort' => $base['goods_sort'],
            'delivery_id' => is_numeric($base['delivery_id']) ? $base['delivery_id'] : 0,
            'goods_status' => $base['goods_status'],
            'thumb' => $base['thumb'],
            'images' => $base['images'],
            'is_delete' => $base['is_delete'],
            // 'images' => serialize($base['images']),
            'line_price' => $base['line_price'],
            'goods_price' => $base['goods_price'],
            'stock' => $base['stock'],
            'label' => $base['label'],
            // 'wxapp_id' => 'Wxapp ID',
            // 'create_time' => 'Create Time',
            // 'update_time' => 'Update Time',
            // 'spec_item_thumb' => '属性图片'
        ];

        if ($model->validate($data)) {
            if ($model->load($goods_base)) {
                $tr = Yii::$app->db->beginTransaction(Transaction::READ_COMMITTED);
                try {
                    if ($model->save()) {
                        $goods_id = Yii::$app->db->getLastInsertID();
                        $model->saveSpec($goods_id, $data);
                        $tr->commit();
                    } else {
                        $message = ErrorsHelper::getModelError($model);

                        throw new BadRequestHttpException($message);
                    }
                } catch (\Exception $e) {
                    $tr->rollBack();
                    throw $e;
                }

                return $this->redirect(['view', 'id' => $goods_id]);
            }
        }
    }

    //该方法是异步校验字段，输入框失去焦点之后自动会自动请求改地址
    public function actionValidate()
   {
        $model = new HubGoodsBaseGoods();

        $base =\Yii::$app->request->input('HubGoodsBaseGoods');
        $delivery_id = 0;
        if(isset($base['delivery_id'])){
            $delivery_id =is_numeric($base['delivery_id'])? $base['delivery_id'] : 0;
        }

        $goods_base['HubGoodsBaseGoods'] = [
            'goods_name' => $base['goods_name'],
            'video' => $base['video'],
            'category_id' => $base['category_id'],
            'category_pid' => $base['category_pid'],
            'spec_type' => $base['spec_type'],
            'deduct_stock_type' => $base['deduct_stock_type'],
            'content' => str_replace('src="/backend/../attachment', 'width="100%" src="'.Yii::$app->request->hostInfo.'/attachment', $base['content']),
            'sales_initial' => $base['sales_initial'],
            'sales_actual' => 0,
            'goods_weight' => $base['goods_weight'],
            'goods_sort' => $base['goods_sort'],
            'delivery_id' => $delivery_id,
            'goods_status' => $base['goods_status'],
            'thumb' => $base['thumb'],
            'is_delete' => isset($base['is_delete'])?$base['is_delete']:0,
            'images' => serialize($base['images']),
            'line_price' => $base['line_price'],
            'goods_price' => $base['goods_price'],
            'stock' => $base['stock'],
            'label' => $base['label'],
            // 'wxapp_id' => 'Wxapp ID',
            // 'create_time' => 'Create Time',
            // 'update_time' => 'Update Time',
            // 'spec_item_thumb' => '属性图片'
        ];

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model->load($goods_base);

        return ActiveForm::validate($model);
    }

    /**
     * Creates a new DdGoods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate()
    {
        $model = new HubGoodsBaseGoods();
        $modelcate = new HubCategory();

        $Helper = new LevelTplHelper([
            'pid' => 'parent_id',
            'cid' => 'category_id',
            'title' => 'name',
            'model' => $modelcate,
            'id' => 'category_id',
        ]);
        $query = $modelcate::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $MyStringHelp = new MyStringHelp(['_string' => Yii::$app->getSecurity()->generateRandomString()]);
        $specitem = [];
        $params = [];
        $html = '';
        $spec = [
            'id' => $MyStringHelp->CreateString('_'),
        ];
        $model->goods_status = 0;
        $model->deduct_stock_type = 20;
        $model->label = '新品';

        $catedata = HubCategory::find()->all();

        $goods_base = [];
        if (Yii::$app->request->isPost) {
            $isself  = Yii::$app->service->commonGlobalsService->isSelf();
            if($isself){
                $goods_type = GoodsTypeStatus::getValueByName('自营商品');
                
            }else{
                $goods_type = GoodsTypeStatus::getValueByName('店铺商品');
                
            }
            
            $data = Yii::$app->request->post();
            $delivery_id = 0;
            if(isset($base['delivery_id'])){
                $delivery_id = is_numeric($base['delivery_id']) ? $base['delivery_id'] : 0;
            }

            /* 基础信息 */
            $base = $data['HubGoodsBaseGoods'];
            $goods_base['HubGoodsBaseGoods'] = [
                'goods_name' => $base['goods_name'],
                'video' => $base['video'],
                'category_id' => $base['category_id'],
                'category_pid' => $base['category_pid'],
                'spec_type' => $base['spec_type'],
                'deduct_stock_type' => $base['deduct_stock_type'],
                'content' => str_replace('src="/backend/../attachment', 'width="100%" src="'.Yii::$app->request->hostInfo.'/attachment', $base['content']),
                'sales_initial' => $base['sales_initial'],
                'sales_actual' => isset($base['sales_actual'])?$base['sales_actual']:0,
                'goods_weight' => $base['goods_weight'],
                'goods_sort' => $base['goods_sort'],
                'delivery_id' => $delivery_id,
                'goods_status' => $base['goods_status'],
                'thumb' => $base['thumb'],
                'is_delete' => isset($base['is_delete'])?$base['is_delete']:0,
                'images' => $base['images'],
                'line_price' => $base['line_price'],
                'goods_price' => $base['goods_price'],
                'stock' => $base['stock'],
                'label' => $base['label'],
                'goods_type' => $goods_type,
                'express_type' => $base['express_type'],
                'goods_costprice' => $base['goods_costprice'],
                'volume' => $base['volume'],
                'exemption_type' => $base['exemption_type'],
                'exemption' => $base['exemption'],
                'express_template_id' => $base['express_template_id'],
                
                // 'wxapp_id' => 'Wxapp ID',
                // 'create_time' => 'Create Time',
                // 'update_time' => 'Update Time',
                // 'spec_item_thumb' => '属性图片'
            ];

            if ($model->load($goods_base) && $model->save()) {
                $goods_id = Yii::$app->db->getLastInsertID();
                $model->saveSpec($goods_id, $data);

                return $this->redirect(['view', 'id' => $goods_id]);
            } else {
                $message = ErrorsHelper::getModelError($model);
                
                Yii::$app->session->setFlash('error', $message);
            }
        }
        $spec_item_shows = [];
        $spec_item_thumbs = [];
        $html = '';
        $express_template = HubExpressTemplate::find()->asArray()->all();
        return $this->render('create', [
            'model' => $model,
            'catedata' => $catedata,
            'modelcate' => $modelcate,
            'dataProvider' => $dataProvider,
            'spec_item_thumbs' => $spec_item_thumbs,
            'spec_item_shows' => $spec_item_shows,
            'html' => $html,
            'Helper' => $Helper,
            'specitem' => $specitem,
            'params' => $params,
            'spec' => $spec,
            'express_template' => $express_template,
            'op' => 'create',
        ]);
    }

    /**
     * Updates an existing DdGoods model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            $delivery_id = 0;
            if(isset($base['delivery_id'])){
                $delivery_id = is_numeric($base['delivery_id']) ? $base['delivery_id'] : 0;
            }

            /* 基础信息 */
            $base = $data['HubGoodsBaseGoods'];
            $goods_base['HubGoodsBaseGoods'] = [
                'goods_name' => $base['goods_name'],
                'category_id' => $base['category_id'],
                'category_pid' => $base['category_pid'],
                'spec_type' => $base['spec_type'],
                'deduct_stock_type' => $base['deduct_stock_type'],
                'content' => str_replace('src="/backend/../attachment', 'width="100%" src="'.Yii::$app->request->hostInfo.'/attachment', $base['content']),
                // 'content' => str_replace(Yii::$App->request->hostInfo . '/attachment', '../attachment', $base['content']),
                'sales_initial' => $base['sales_initial'],
                'sales_actual' => isset($base['sales_actual'])?$base['sales_actual']:0,
                'goods_sort' => $base['goods_sort'],
                'delivery_id' => $delivery_id,
                'goods_status' => $base['goods_status'],
                'is_delete' =>isset($base['is_delete'])?$base['is_delete']:2,
                'thumb' => $base['thumb'],
                'images' => $base['images'],
                // 'images' => serialize($base['images']),
                'line_price' => $base['line_price'],
                'goods_price' => $base['goods_price'],
                'stock' => $base['stock'],
                'label' => $base['label'],
                'video' => $base['video'],
                'express_type' => $base['express_type'],
                'exemption_type' => $base['exemption_type'],
                'exemption' => $base['exemption'],
                'volume' => $base['volume'],
                'goods_costprice' => $base['goods_costprice'],
                'express_template_id' => $base['express_template_id'],
                // 'goods_type' => $goods_type,
                
                // 'wxapp_id' => 'Wxapp ID',
                // 'create_time' => 'Create Time',
                // 'update_time' => 'Update Time',
                // 'spec_item_thumb' => '属性图片'
            ];
            if ($model->load($goods_base) && $model->save()) {
                $model->saveSpec($model->goods_id, $data);

                return $this->redirect(['view', 'id' => $model->goods_id]);
            } else {
                $message = ErrorsHelper::getModelError($model);

                throw new BadRequestHttpException($message);
            }
        } else {
            // print_r($model->images);

            $model->images = unserialize($model->images);
            // print_r($model->images);
            $modelcate = new HubCategory();
            $Helper = new LevelTplHelper([
                'pid' => 'parent_id',
                'cid' => 'category_id',
                'title' => 'name',
                'model' => $modelcate,
                'id' => 'category_id',
            ]);
            $query = $modelcate::find();
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => false,
            ]);

            $bloc_id = Yii::$app->params['bloc_id'];
            $store_id = Yii::$app->params['store_id'];
            if ($bloc_id) {
                $where['bloc_id'] = $bloc_id;
            }

            if ($store_id) {
                $where['store_id'] = $store_id;
            }

            $catedata = HubCategory::find()->where($where)->all();
            $modelcate->category_pid = $model->category_pid;

            $MyStringHelp = new MyStringHelp(['_string' => Yii::$app->getSecurity()->generateRandomString()]);
            $specitem = [];
            $params = HubGoodsParam::findAll(['goods_id' => $id]);
            $html = '';
            $spec = [
                'id' => $MyStringHelp->CreateString('_'),
            ];
 
            // $ss = DdGoodsSpec::find()->where(['goods_id'=>$goods_id])->with('specvalue');

            $specitems = HubGoodsBaseSpecRel::find()->where(['goods_id' => $id])->with('specvalue')->asarray()->all();

            $specv = [];
            if (!empty($specitems)) {
                foreach ($specitems as $key => $value) {
                    $model->spec_item_thumb[$value['spec_id']][$value['spec_value_id']] = $value['thumb'];
                    $spec_item_thumbs[$value['spec_id']][$value['spec_value_id']]['spec_item_thumb'] = $value['thumb'];
                    $spec_item_shows[$value['spec_id']][$value['spec_value_id']]['spec_item_show'] = $value['spec_item_show'];
                    // $model->spec_item_thumb = $value['thumb'];

                    $specs[$value['spec_id']] = $value['spec_id'];
                    $specitem[$value['spec_id']][$value['specvalue']['spec_value_id']] = $value['specvalue']['spec_value'];
                }
                $specv = HubSpec::find()
                    ->where(['in', 'spec_id', $specs])
                    ->select('spec_name,spec_id')
                    ->indexBy('spec_id')
                    ->asArray()
                    ->all();
            }

            $allspecs = HubGoodsBaseSpec::find()->where(['goods_id' => $id])->with('goodsSpecRel')->asArray()->all();
            $DdGoodsSpecRel = new HubGoodsBaseSpecRel();
            $html = $DdGoodsSpecRel->buildHtml($id);
            $spec_item_shows = [];
            $spec_item_thumbs =[];

            $express_template = HubExpressTemplate::find()->asArray()->all();

            return $this->render('update', [
                'model' => $model,
                'express_template' => $express_template,
                'catedata' => $catedata,
                'modelcate' => $modelcate,
                'dataProvider' => $dataProvider,
                'Helper' => $Helper,
                'specitem' => $specitem,
                'params' => $params,
                'spec' => $spec,
                'spec_item_shows' => $spec_item_shows,
                'spec_item_thumbs' => $spec_item_thumbs,
                'html' => $html,
                'op' => 'update',
                'specv' => $specv,
            ]);
        }
    }

    /**
     * Deletes an existing DdGoods model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete()
   {

        if(Yii::$app->request->isPost){
            
            $ids = explode(',',Yii::$app->request->input('ids'));
            $model = new HubGoodsBaseGoods();
            $where = ['in', 'goods_id', $ids];
            $model->deleteAll($where);
            // 删除商品有关的广告
            HubLocationGoods::deleteAll($where);
            
            return ResultHelper::json(200,'删除成功',[]);    
        
        }else{
            
            return ResultHelper::json(400,'非ajax操作不能删除',[]);    
            
        }
        
    }

    public function actionExportdatalist()
   {
        $where = [];
        
        $where['store_id'] = Yii::$app->params['store_id'];
        $where['bloc_id']  = Yii::$app->params['bloc_id'];
        
        $goodsList = HubGoodsBaseGoods::find()->where($where)->with(['store','cate'])->all();
        
        if (!empty($goodsList)) {
           
            $fileName = '商品'.date('Y-m-d H:i:s', time()).'.xls';
            $savePath = yii::getAlias('@attachment/diandi_hub/excel/goods'.date('Y/m/d/',time()));
            FileHelper::mkdirs($savePath);
            $Res = ExportModel::widget([
                'models' => $goodsList,  // 必须
                'fileName' => $fileName,  // 默认为:'excel.xls'
                'asAttachment' => false,  // 默认值, 可忽略
                'savePath'=>$savePath,
                'headers' => [
                    'goods_id'      => '商品ID',
                    'goods_name'    => '商品名称',
                    'category_id'   => '商品分类',
                    'store_id'      => '所属商户',
                    'volume'        => '体积',
                    'store_id'      => '商户ID',
                    'video'         => '短视频',
                    'label'         => '商品标签',
                    'spec_type'     => '商品规格',
                    'goods_weight'  => '重量(克)',
                    // 'express_template_id'=>'运费模板',
                    'deduct_stock_type' => '库存计算方式',
                    // 'content' => '商品介绍',
                    'sales_initial' => '初始销量',
                    'sales_actual' => 'Sales Actual',
                    'goods_sort' => '商品排序',
                    'delivery_id' => '运费模板',
                    'goods_status' => '是否上架',
                    'is_delete' => '是否删除',
                    'goods_type' => '商品类型',
                    // 'images' => '商品相册',
                    'goods_costprice'=> '成本价格',
                    // 'thumb' => '商品主图',
                    'line_price' => '市场价',
                    'sales_actual' => '实际销量',
                    'browse' => '浏览量',
                    'goods_price' => '销售价格',
                    'stock' => '库存',
                    'spec_item_thumb' => '属性图片',
                    'exemption'=> '包邮条件',
                    'exemption_type' => '包邮条件类型',
                    'create_time' => '添加时间',
                    'update_time' => '更新时间',
                ],
                'columns' => [
                    'goods_id',
                    'goods_name',
                    'cate.name',
                    'store.name',
                    'volume',
                    'video',
                    'label',
                    'spec_type',
                    'goods_weight',
                    // 'express_template_id',
                    'deduct_stock_type',
                    // 'content',
                    'sales_initial',
                    'sales_actual',
                    'goods_sort',
                    'delivery_id',
                    'goods_status',
                    'is_delete',
                    [
                        'attribute' => 'goods_type',
                        'header' => '商品类型',
                        'format' => 'text',
                        'value' => function ($model) {
                            return GoodsTypeStatus::getLabel($model['goods_type']);
                        },
                    ],
                    // 'images',
                    'goods_costprice',
                    // 'thumb',
                    'line_price',
                    'sales_actual',
                    'browse',
                    'goods_price',
                    'stock',
                    'spec_item_thumb',
                    [
                        'attribute' => 'exemption_type',
                        'header' => '包邮方式',
                        'format' => 'text',
                        'value' => function ($model) {
                            $list = [
                                '1' => '元',
                                '2' => '件',
                            ];
                            
                            if(!empty($model['exemption_type'])){
                                return '满'.$model['exemption'].$list[$model['exemption_type']].'包邮';
                            }else{
                                return '未设置';
                            }
                        },
                    ],
                ],
                // 'mergeCells' => $cells,
            ]);
                
            return ResultHelper::json(200,'下载成功',[
                'url'=>ImageHelper::tomedia('/diandi_hub/excel/goods'.date('Y/m/d/',time()). $fileName)
            ]);
        } else {
            return ResultHelper::json(400,'没有可以下载的数据');
        }
    }



    /**
     * 添加规格页面.
     *
     * @param int|null post
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionSpecitem()
    {
        if (Yii::$app->request->isAjax) {
            // Yii::$App->response->format = Response::FORMAT_JSON;
            $data = Yii::$app->request->post();
            $pids = $data['specid'];

            $title = Yii::$app->request->post('title', '');
            $MyStringHelp = new MyStringHelp(['_string' => Yii::$app->getSecurity()->generateRandomString()]);
            $ids = $MyStringHelp->CreateString('_');

            $specitem = array(
                'ids' => $ids,
                'title' => $title,
                'show' => 1,
            );
            $spec = array(
                'ids' => $pids,
            );
            $model = new HubGoodsBaseGoods();

            $form = MyActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);

            return $this->renderAjax('spec_item', [
                'specitem' => $specitem,
                'spec' => $spec,
                'model' => $model,
                'form' => $form,
            ]);
        }
    }

    public function actionParam()
    {
        $MyStringHelp = new MyStringHelp(['_string' => Yii::$app->getSecurity()->generateRandomString()]);

        $tag = $MyStringHelp->CreateString('_');
        $model = new HubGoodsBaseGoods();

        return $this->renderAjax('param', [
            'tag' => $tag,
            'model' => $model,
        ]);
    }

    /**
     * 添加规格
     *
     * @param int|null post
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionSpec()
   {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            
            $title = Yii::$app->request->post('title', '');
            $MyStringHelp = new MyStringHelp(['_string' => Yii::$app->getSecurity()->generateRandomString()]);

            $ids = $MyStringHelp->CreateString('_');
            if (!empty($data['specid'])) {
                $ids = $data['specid'];
            }

            $model = new HubGoodsBaseGoods();

            $spec = array(
                'id' => $ids,
                'title' => $title,
            );

            return $this->renderPartial('spec', [
                'op' =>\Yii::$app->request->input('op'),
                'spec' => $spec,
                'model' => $model,
                'specitem' => [],
            ]);
        }
    }

    /**
     * Finds the DdGoods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return DdGoods the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubGoodsBaseGoods::findOne(['goods_id'=>$id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
