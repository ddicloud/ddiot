<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-11 22:12:57
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-11 22:14:16
 */
 

namespace common\plugins\diandi_hub\backend\member;

use Yii;
use common\plugins\diandi_hub\models\level\DiandiHubLevelCondition;
use common\plugins\diandi_hub\models\Searchs\level\DiandiHubLevelCondition as DiandiHubLevelConditionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BaseController;
use common\plugins\diandi_hub\models\enums\LevelStatus;
use common\plugins\diandi_hub\models\level\HubLevel;
use common\plugins\diandi_hub\services\levelService;

/**
 * ConditionController implements the CRUD actions for DiandiHubLevelCondition model.
 */
class ConditionController extends BaseController
{
    public $modelSearchName = "DiandiHubLevelConditionSearch
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
     * Lists all DiandiHubLevelCondition models.
     * @return array
     */
    public function actionIndex()
    {
        global $_GPC;
        $levelnum = intval(Yii::$app->request->input('levelnum'));
        $searchModel = new DiandiHubLevelConditionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $levels = HubLevel::find()->indexBy('levelnum')->asArray()->all();
       
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'levelnum' => $levelnum,
            'levels' => $levels,

        ]);
    }

    /**
     * Displays a single DiandiHubLevelCondition model.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        global $_GPC;
        $levelnum = intval(Yii::$app->request->input('levelnum'));

        return $this->render('view', [
            'model' => $this->findModel($id),
            'levelnum' => $levelnum,

        ]);
    }

    /**
     * Creates a new DiandiHubLevelCondition model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return array
     */
    public function actionCreate()
    {
        global $_GPC;
        $levelnum = intval(Yii::$app->request->input('levelnum'));

        $model = new DiandiHubLevelCondition();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id,'levelnum' => $levelnum,]);
        }

        $levels = LevelStatus::listData();

        return $this->render('create', [
            'model' => $model,
            'levelnum' => $levelnum,
            'levels' => $levels,
        ]);
    }

    /**
     * Updates an existing DiandiHubLevelCondition model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        global $_GPC;
        $levelnum = intval(Yii::$app->request->input('levelnum'));
        $levels = LevelStatus::listData();

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id,'levelnum' => $levelnum]);
        }

       

        return $this->render('update', [
            'model' => $model,
            'levelnum' => $levelnum,
            'levels' => $levels,
        ]);
    }

    /**
     * Deletes an existing DiandiHubLevelCondition model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        global $_GPC;
        $levelnum = intval(Yii::$app->request->input('levelnum'));

        $this->findModel($id)->delete();

        return $this->redirect(['index','levelnum' => $levelnum]);
    }

    /**
     * Finds the DiandiHubLevelCondition model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DiandiHubLevelCondition the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DiandiHubLevelCondition::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
