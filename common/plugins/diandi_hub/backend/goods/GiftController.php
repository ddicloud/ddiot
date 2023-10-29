<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-07-12 00:16:24
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-02-05 21:59:38
 */
 

namespace common\plugins\diandi_hub\backend\goods;

use Yii;
use common\plugins\diandi_hub\models\HubGift;
use common\plugins\diandi_hub\models\Searchs\goods\HubGiftSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BaseController;
use common\plugins\diandi_hub\models\enums\GoodsTypeStatus;
use common\plugins\diandi_hub\models\goods\HubGift as GoodsHubGift;
use common\plugins\diandi_hub\models\goods\HubGoods as GoodsHubGoods;
use common\plugins\diandi_hub\models\member\HubMemberLevel as MemberHubMemberLevel;
use common\plugins\diandi_hub\services\levelService;
use common\plugins\diandi_hub\services\GoodsService as ServicesGoodsService;
use common\helpers\ResultHelper;

/**
 * GiftController implements the CRUD actions for HubGift model.
 */
class GiftController extends BaseController
{
    
    public $modelName = 'HubGift';

    public $modelSearchName = 'HubGiftSearch';
    
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
            ]
        ];
    }

    public function actionGoodslist()
    {
        global  $_GPC;
        $keywords = $_GPC['keywords'];
        $list = [];
        
        $list = ServicesGoodsService::getList(0,$keywords);
        
        foreach ($list as $key => &$value) {
            $value['images'] = is_array($value['images'])?$value['images']:[]; 
        }

        $model = new GoodsHubGoods();

        $levels = [];

        $levels = levelService::getLevels();
        foreach ($levels as $key => &$value) {
            $value['money1'] = $value['money2'] = $value['money3'] = '';
        }

        return ResultHelper::json(200, '请求成功', [
             'list' => $list,
             'levels' => $levels
            ]);
    }


    /**
     * Lists all HubGift models.
     * @return mixed
     */
    public function actionIndex()
    {
        $DistributormemberLevel = new MemberHubMemberLevel();
        $userInfo = $DistributormemberLevel->find()->where(['member_id' => 404])->with(['level'])->asArray()->one();
        
        $searchModel = new HubGiftSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HubGift model.
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
     * Displays a single HubGift model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDetail()
    {
        global $_GPC;
        $id  = $_GPC['id'];
        $list = $this->findModel($id);
        return ResultHelper::json(200,'获取成功',$list);
    }

    /**
     * Creates a new HubGift model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GoodsHubGift();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $goods_id = $model->goods_id;
            $goods_type = GoodsTypeStatus::GIFT;
            ServicesGoodsService::updateGoodsType($goods_id,$goods_type);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing HubGift model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->images = unserialize($model->images);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $goods_id = $model->goods_id;
            $goods_type = GoodsTypeStatus::GIFT;
            ServicesGoodsService::updateGoodsType($goods_id,$goods_type);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing HubGift model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $goods_id = $this->findModel($id)->goods_id;
        $this->findModel($id)->delete();
        $isself  = Yii::$app->service->commonGlobalsService->isSelf();
        if($isself){
            $goods_type = GoodsTypeStatus::GIFT;
            
        }else{
            $goods_type = GoodsTypeStatus::STORE;
            
        }
        ServicesGoodsService::updateGoodsType($goods_id,$goods_type);
        
        $isself  = Yii::$app->service->commonGlobalsService->isSelf();


        return $this->redirect(['index']);
    }

    /**
     * Finds the HubGift model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HubGift the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GoodsHubGift::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
