<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-08 12:22:25
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-08 13:09:03
 */
 

namespace common\plugins\diandi_hub\backend\express;

use Yii;
use common\plugins\diandi_hub\models\express\HubExpressTemplateArea;
use common\plugins\diandi_hub\models\Searchs\express\HubExpressTemplateArea as HubExpressTemplateAreaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BaseController;
use common\plugins\diandi_hub\models\express\HubExpressTemplate;
use common\models\DdRegion;

/**
 * AreaController implements the CRUD actions for HubExpressTemplateArea model.
 */
class AreaController extends BaseController
{
    public $modelSearchName = "HubExpressTemplateAreaSearch";

    public function actions()
    {
        
        $actions = parent::actions();
        $actions['get-region'] = [
            'class' => \diandi\region\RegionAction::class,
            'model' => DdRegion::class,
        ];

        return $actions;
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
     * Lists all HubExpressTemplateArea models.
     * @return array
     */
    public function actionIndex()
    {
        
        global $_GPC;

        $template_id = Yii::$app->request->input('template_id');
        
        $searchModel = new HubExpressTemplateAreaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'template_id' => $template_id

        ]);
    }

    /**
     * Displays a single HubExpressTemplateArea model.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        global $_GPC;

        $template_id = Yii::$app->request->input('template_id');
        return $this->render('view', [
            'model' => $this->findModel($id),
            'template_id' => $template_id
        ]);
    }

    /**
     * Creates a new HubExpressTemplateArea model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return array
     */
    public function actionCreate()
    {
        global $_GPC;

        $template_id = Yii::$app->request->input('template_id');
        $template = HubExpressTemplate::findOne($template_id);
        $express_id = $template['express_id'];
        $title      = $template['title'];
        $model = new HubExpressTemplateArea();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id,'template_id'=>$template_id]);
        }

        return $this->render('create', [
            'model' => $model,
            'title' => $title,
            'express_id' => $express_id,
            'template_id' => $template_id,
        ]);
    }

    /**
     * Updates an existing HubExpressTemplateArea model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        global $_GPC;

        $template_id = Yii::$app->request->input('template_id');
        $template = HubExpressTemplate::findOne($template_id);
        $express_id = $template['express_id'];
        $title      = $template['title'];

        $model = $this->findModel($id);
        
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id,'template_id'=>$template_id]);
        }

        return $this->render('update', [
            'model' => $model,
            'title' => $title,
            'express_id' => $express_id,
            'template_id' => $template_id,
        ]);
    }

    /**
     * Deletes an existing HubExpressTemplateArea model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        global $_GPC;

        $template_id = Yii::$app->request->input('template_id');
        
        $this->findModel($id)->delete();

        return $this->redirect(['index','template_id'=>$template_id]);
    }

    /**
     * Finds the HubExpressTemplateArea model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HubExpressTemplateArea the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubExpressTemplateArea::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
