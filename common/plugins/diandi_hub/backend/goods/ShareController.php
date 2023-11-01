<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-02-07 10:35:08
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-08 17:48:27
 */


namespace common\plugins\diandi_hub\backend\goods;

use Yii;
use common\plugins\diandi_hub\models\goods\HubGoodsSubsidy;
use common\plugins\diandi_hub\models\Searchs\goods\HubGoodsSubsidy as HubGoodsSubsidySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BaseController;
use InvalidArgumentException;

/**
 * ShareController implements the CRUD actions for HubGoodsSubsidy model.
 */
class ShareController extends BaseController
{
    public $modelSearchName = "HubGoodsSubsidySearch";

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
     * Lists all HubGoodsSubsidy models.
     * @return array
     */
    public function actionIndex()
    {
        global $_GPC;
        $goods_id  =Yii::$app->request->input('goods_id');
        $searchModel = new HubGoodsSubsidySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'goods_id'=>$goods_id

        ]);
    }

    /**
     * Displays a single HubGoodsSubsidy model.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        global $_GPC;
        $goods_id  = Yii::$app->request->input('goods_id');
        return $this->render('view', [
            'model' => $this->findModel($id),
            'goods_id'=>$goods_id

        ]);
    }

    /**
     * Creates a new HubGoodsSubsidy model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return array
     */
    public function actionCreate()
    {
        global $_GPC;
        $goods_id  = Yii::$app->request->input('goods_id');
        $model = new HubGoodsSubsidy();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'goods_id'=>$goods_id]);
        }

        return $this->render('create', [
            'model' => $model,
        'goods_id'=>$goods_id

        ]);
    }

    /**
     * Updates an existing HubGoodsSubsidy model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        global $_GPC;
        $goods_id  =Yii::$app->request->input('goods_id');
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'goods_id'=>$goods_id]);
        }

        return $this->render('update', [
            'model' => $model,
            'goods_id'=>$goods_id

        ]);
    }

    /**
     * Deletes an existing HubGoodsSubsidy model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        global $_GPC;
        $goods_id  =Yii::$app->request->input('goods_id');

        $this->findModel($id)->delete();

        return $this->redirect(['index','goods_id'=>$goods_id]);
    }

    /**
     * Finds the HubGoodsSubsidy model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HubGoodsSubsidy the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubGoodsSubsidy::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
