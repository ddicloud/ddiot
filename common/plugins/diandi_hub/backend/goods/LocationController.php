<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-05 12:42:03
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-02-02 18:25:22
 */

namespace common\plugins\diandi_hub\backend\goods;

use backend\controllers\BaseController;
use common\plugins\diandi_hub\models\advertising\HubLocation;
use common\plugins\diandi_hub\models\advertising\HubLocationAd;
use common\plugins\diandi_hub\models\advertising\HubLocationGoods;
use common\plugins\diandi_hub\models\enums\locationPage;
use common\plugins\diandi_hub\models\enums\locationStyle;
use common\plugins\diandi_hub\models\Searchs\location\LocationSearch;
use Yii;
use yii2mod\editable\EditableAction;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * LocationController implements the CRUD actions for HubLocation model.
 */
class LocationController extends BaseController
{
    public $modelSearchName = 'LocationSearch';

    public function actions()
    {
        return [
            'change-order' => [
                'class' => EditableAction::class,
                'modelClass' => HubLocation::class,
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
     * Lists all HubLocation models.
     *
     * @return array
     */
    public function actionIndex()
    {
        global  $_GPC;

        $searchModel = new LocationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HubLocation model.
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
     * Creates a new HubLocation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate()
    {
        $model = new HubLocation();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $pages = locationPage::listData();
        $styles = locationStyle::listData();

        return $this->render('create', [
            'model' => $model,
            'pages' => $pages,
            'styles' => $styles,
        ]);
    }

    /**
     * Updates an existing HubLocation model.
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // 更新该位置下的商品和图片广告位对应的mark
            $mark = $_GPC['HubLocation']['mark'];
            HubLocationGoods::updateAll(['mark'=> $mark],['location_id'=>$id]);
            HubLocationAd::updateAll(['mark'=> $mark],['location_id'=>$id]);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $pages = locationPage::listData();

        $styles = locationStyle::listData();

        return $this->render('update', [
            'model' => $model,
            'pages' => $pages,
            'styles' => $styles,
        ]);
    }

    /**
     * Deletes an existing HubLocation model.
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
     * Finds the HubLocation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return HubLocation the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubLocation::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
