<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-11 22:12:57
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-22 14:16:36
 */

namespace common\plugins\diandi_hub\admin\member;

use common\plugins\diandi_hub\models\enums\LevelStatus;
use common\plugins\diandi_hub\models\level\DiandiHubLevelCondition;
use common\plugins\diandi_hub\models\level\HubLevel;
use common\plugins\diandi_hub\models\Searchs\level\DiandiHubLevelCondition as DiandiHubLevelConditionSearch;
use admin\controllers\AController;
use common\helpers\ResultHelper;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * ConditionController implements the CRUD actions for DiandiHubLevelCondition model.
 */
class ConditionController extends AController
{
    public string $modelSearchName = 'DiandiHubLevelConditionSearch
';

    /**
     * Lists all DiandiHubLevelCondition models.
     *
     * @return array
     */
    public function actionIndex()
   {
        $levelnum = intval(Yii::$app->request->input('levelnum'));
        $searchModel = new DiandiHubLevelConditionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $levels = HubLevel::find()->indexBy('levelnum')->asArray()->all();

        return ResultHelper::json(200,'获取成功',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'levelnum' => $levelnum,
            'levels' => $levels,
        ]);
    }

    /**
     * Displays a single DiandiHubLevelCondition model.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
   {
        $levelnum = intval(Yii::$app->request->input('levelnum'));

        return ResultHelper::json(200,'获取成功',[
            'model' => $this->findModel($id),
            'levelnum' => $levelnum,
        ]);
    }

    /**
     * Creates a new DiandiHubLevelCondition model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate()
   {
        $levelnum = intval(Yii::$app->request->input('levelnum'));

        $model = new DiandiHubLevelCondition();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'levelnum' => $levelnum]);
        }

        $levels = LevelStatus::listData();

        return ResultHelper::json(200,'获取成功',[
            'model' => $model,
            'levelnum' => $levelnum,
            'levels' => $levels,
        ]);
    }

    /**
     * Updates an existing DiandiHubLevelCondition model.
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
        $levelnum = intval(Yii::$app->request->input('levelnum'));
        $levels = LevelStatus::listData();

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'levelnum' => $levelnum]);
        }

        return ResultHelper::json(200,'获取成功',[
            'model' => $model,
            'levelnum' => $levelnum,
            'levels' => $levels,
        ]);
    }

    /**
     * Deletes an existing DiandiHubLevelCondition model.
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
        $levelnum = intval(Yii::$app->request->input('levelnum'));

        $this->findModel($id)->delete();

        return $this->redirect(['index', 'levelnum' => $levelnum]);
    }

    /**
     * Finds the DiandiHubLevelCondition model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return DiandiHubLevelCondition the loaded model
     *
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
