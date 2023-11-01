<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-11 22:13:39
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-01 18:37:27
 */
 

namespace common\plugins\diandi_hub\backend\member;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BaseController;
use common\plugins\diandi_hub\models\enums\LevelStatus;
use common\plugins\diandi_hub\models\level\butionLevelEarningsConf;
use common\plugins\diandi_hub\models\Searchs\level\butionLevelEarningsConf as LevelButionLevelEarningsConf;

/**
 * EarningsconfController implements the CRUD actions for butionLevelEarningsConf model.
 */
class EarningsconfController extends BaseController
{
    public $modelSearchName = "butionLevelEarningsConfSearch
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
     * Lists all butionLevelEarningsConf models.
     * @return array
     */
    public function actionIndex()
    {
        global $_GPC;
        $levelnum = intval(Yii::$app->request->input('levelnum'));

        $searchModel = new LevelButionLevelEarningsConf();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'levelnum' => $levelnum,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single butionLevelEarningsConf model.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        global $_GPC;
        $levelnum = intval(Yii::$app->request->input('levelnum'));
        
        return $this->render('view', [
            'levelnum' => $levelnum,
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new butionLevelEarningsConf model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return array
     */
    public function actionCreate()
    {
        global $_GPC;
        $levelnum = intval(Yii::$app->request->input('levelnum'));

        $model = new butionLevelEarningsConf();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id,'levelnum' => $levelnum]);
        }
        $levels = LevelStatus::listData();

        return $this->render('create', [
            'model' => $model,
            'levelnum' => $levelnum,
            'levels' => $levels,
        ]);
    }

    /**
     * Updates an existing butionLevelEarningsConf model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        global $_GPC;

        $model = $this->findModel($id);
        $levelnum = intval(Yii::$app->request->input('levelnum'));

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id,'levelnum' => $levelnum]);
        }
        $levels = LevelStatus::listData();

        return $this->render('update', [
            'model' => $model,
            'levelnum' => $levelnum,
            'levels' => $levels,
        ]);
    }

    /**
     * Deletes an existing butionLevelEarningsConf model.
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
     * Finds the butionLevelEarningsConf model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return butionLevelEarningsConf the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = butionLevelEarningsConf::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
