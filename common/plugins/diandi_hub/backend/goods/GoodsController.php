<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-01 20:28:55
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-01 18:34:02
 */

namespace common\plugins\diandi_hub\backend\goods;

use Yii;
use common\plugins\diandi_hub\models\Searchs\goods\HubGoodsSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BaseController;
use common\plugins\diandi_hub\models\goods\HubGoodsSpec;
use common\plugins\diandi_hub\models\money\HubPriceConf;
use common\plugins\diandi_hub\services\GoodsService as ServicesGoodsService;
use common\plugins\diandi_hub\services\levelService;
use common\plugins\diandi_hub\models\goods\HubGoods as GoodsHubGoods;
use common\plugins\diandi_hub\services\GoodsService;
use common\plugins\diandi_hub\models\DdGoodsSpecRel as ModelsDdGoodsSpecRel;
use common\helpers\FileHelper;
use common\helpers\ImageHelper;
use common\helpers\phpexcel\ExportModel;
use common\helpers\ResultHelper;

/**
 * GoodsController implements the CRUD actions for HubGoods model.
 */
class GoodsController extends BaseController
{
    public $prices;

    public $modelSearchName = 'HubGoodsSearch';


    public function actions()
    {
        $HubPriceConf = new HubPriceConf();
        $this->prices = $HubPriceConf->find()->where(['is_use'=>1])->indexBy('pricefield')->asArray()->all();
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

    public function actionAttribute()
    {
        global  $_GPC;
        if (Yii::$app->request->isPost) {
            $model = new GoodsHubGoods();
            $attribute = $model->attributeLabels();

            return ResultHelper::json(200, '初始化成功', [
                'attribute' => $attribute,
                'prices' => $this->prices,
             ]);
        }
    }

    /**
     * Lists all HubGoods models.
     *
     * @return array
     */
    public function actionIndex()
    {
        global  $_GPC;
        $searchModel = new HubGoodsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
     
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'prices' => $this->prices,
        ]);
    }

    /**
     * Displays a single HubGoods model.
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
            'prices' => $this->prices,
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new HubGoods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate()
    {
        global  $_GPC;

        if (Yii::$app->request->isPost) {
            $baseprice =\Yii::$app->request->input('baseprice');
            $goods_id =\Yii::$app->request->input('goods_id');
            $member_price =\Yii::$app->request->input('member_price');
            $disInfo =\Yii::$app->request->input('disInfo');
            $prices =\Yii::$app->request->input('prices');
            $type =\Yii::$app->request->input('type');
            $goodsSpecs =\Yii::$app->request->input('goodsSpecs');

            $goods_type = '0'; //0分销1礼包
            // 分销商品信息存储
            $Res = ServicesGoodsService::addGoods($goods_id, $goods_type, $type, $member_price, $prices, $disInfo, $goodsSpecs, $baseprice);

            return ResultHelper::json(200, '', $Res);
        }

        // 多规格存储分佣
        $model = new GoodsHubGoods();
        $levels = [];

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $levels = levelService::getLevels();
            foreach ($levels as $key => &$value) {
                $value['money1'] = $value['money2'] = $value['money3'] = '';
            }
        }

        return $this->render('create', [
            'prices' => $this->prices,
            'model' => $model,
            'levels' => $levels,
        ]);
    }

    public function actionPostdata()
    {
        global  $_GPC;
        $goods_id =\Yii::$app->request->input('goods_id');
    }

    public function actionDetail()
    {
        global  $_GPC;
        $model = $this->findModel(Yii::$app->request->input('id'));
        $goods_id = $model['goods_id'];

        $list = ServicesGoodsService::goodsDis($goods_id);
        
        
        $levels = [];

        $levels = levelService::getLevels();
        foreach ($levels as $key => &$value) {
            $value['money1'] = $value['money2'] = $value['money3'] = '';
        }

        return ResultHelper::json(200, '获取成功', ['list' => $list, 'levels' => $levels]);
    }

    public function actionGethtml()
    {
        global  $_GPC;
        // if (Yii::$App->request->isPost) {
        //     $DdGoodsSpecRel = new HubGoodsSpecRel();
        //     $html = $DdGoodsSpecRel->buildHtml(Yii::$app->request->input('goods_id'));

        //     return ResultHelper::json(200, '请求成功', $html);
        // }
    }

    /**
     * Updates an existing HubGoods model.
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
        global $_GPC;
        
        $model = $this->findModel($id);

        
        if (Yii::$app->request->isPost) {
            $baseprice =\Yii::$app->request->input('baseprice');
            $goods_id =\Yii::$app->request->input('goods_id');
            $member_price =\Yii::$app->request->input('member_price');
            $disInfo =\Yii::$app->request->input('disInfo');
            $prices =\Yii::$app->request->input('prices');
            $type =\Yii::$app->request->input('type');
            $goodsSpecs =\Yii::$app->request->input('goodsSpecs');

            $goods_type = '0'; //0分销1礼包
            // 分销商品信息存储
            $Res = ServicesGoodsService::updateGoods($goods_id, $goods_type, $type, $member_price, $prices, $disInfo, $goodsSpecs, $baseprice);

            return ResultHelper::json(200, '', $Res);
        }
        

        return $this->render('update', [
            'prices' => $this->prices,
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing HubGoods model.
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
        $model = $this->findModel($id);
        $goods_id = $model['goods_id'];
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionGoodslist()
    {
        global  $_GPC;
        $keywords =\Yii::$app->request->input('keywords');
        $list = [];

        $list = GoodsService::getList(0,$keywords);

        foreach ($list as $key => &$value) {
            $value['images'] = is_array($value['images']) ? $value['images'] : [];
        }

        $model = new GoodsHubGoods();

        $levels = [];

        $levels = levelService::getLevels();
        foreach ($levels as $key => &$value) {
            $value['money1'] = $value['money2'] = $value['money3'] = '';
        }

        return ResultHelper::json(200, '请求成功', [
             'list' => $list,
             'levels' => $levels,
            ]);
    }

    public function actionSpechtml()
    {
        global  $_GPC;
        $goods_id = Yii::$app->request->post();
    }

  
    /**
     * Finds the HubGoods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return HubGoods the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GoodsHubGoods::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
