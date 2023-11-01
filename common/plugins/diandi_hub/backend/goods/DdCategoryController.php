<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-08 10:19:54
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-11-18 11:13:44
 */
 

namespace common\plugins\diandi_hub\backend\goods;

use Yii;
use common\plugins\diandi_hub\models\DdCategory;
use backend\controllers\BaseController;
use common\plugins\diandi_hub\models\goods\HubCategory;
use common\plugins\diandi_hub\models\Searchs\goods\HubCategorySearch as SearchsHubCategorySearch;
use common\plugins\diandi_hub\services\GoodsService;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\helpers\ErrorsHelper;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use yii\data\ActiveDataProvider;
use yii\web\BadRequestHttpException;
use yii\web\Response;

/**
 * DdCategoryController implements the CRUD actions for DdCategory model.
 */
class DdCategoryController extends BaseController
{
    public $modelSearchName = 'HubCategorySearch';
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
     * Lists all DdCategory models.
     *
     * @return array
     */
    public function actionIndex()
    {
        $searchModel = new SearchsHubCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        // p($dataProvider);
        // $query = DdCategory::find();
        // $dataProvider = new ActiveDataProvider([
        //     'query' => $query,
        //     'pagination' => false,
        // ]);   

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DdCategory model.
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

    /**
     * Creates a new DdCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate()
    {
        $model = new HubCategory();
        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->category_id]);
            } else {
                $message = ErrorsHelper::getModelError($model);
                throw new BadRequestHttpException($message);
            }
        }

        $where = [];
        
        $bloc_id = Yii::$app->params['bloc_id'];

        $store_id = Yii::$app->params['store_id'];
        $where['parent_id'] = 0;
        
        if ($bloc_id) {
            $where['bloc_id'] = $bloc_id;
        }
        if ($store_id) {
            $where['store_id'] = $store_id;
        }
        
        $catedata = $model::find()->where($where)->asArray()->all();
        array_unshift($catedata, ['category_id' => 0, 'name' => '顶级分类']);

        return $this->render('create', [
            'model' => $model,
            'catedata' => $catedata,
        ]);
    }

    /**
     * Updates an existing DdCategory model.
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->category_id]);
        }

        $where = [];
        
        $bloc_id = Yii::$app->params['bloc_id'];

        $store_id = Yii::$app->params['store_id'];
        $where['parent_id'] = 0;
        
        if ($bloc_id) {
            $where['bloc_id'] = $bloc_id;
        }
        if ($store_id) {
            $where['store_id'] = $store_id;
        }
        
        $catedata = $model::find()->where($where)->asArray()->all();
        
        array_unshift($catedata, ['category_id' => 0, 'name' => '顶级分类']);

        return $this->render('update', [
            'model' => $model,
            'catedata' => $catedata,
        ]);
    }

    
    public function actionGoodslist()
    {
        global  $_GPC;
        $keywords =\Yii::$app->request->input('keywords');
        $list = [];
        
        $list = GoodsService::getList(0, 0, $keywords,10);
        
        foreach ($list as $key => &$value) {
            $value['images'] = is_array($value['images'])?$value['images']:[]; 
        }

        return ResultHelper::json(200, '请求成功', [
             'list' => $list
            ]);
    }


    /**
     * Deletes an existing DdCategory model.
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
     * @return string
     */
    public function actionChildcate()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $data = Yii::$app->request->post();
            $parent_id = $data['parent_id'];
            $cates = HubCategory::findAll(['parent_id' => $parent_id]);
            return $cates;
        }
    }

    /**
     * Finds the DdCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return DdCategory the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubCategory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
