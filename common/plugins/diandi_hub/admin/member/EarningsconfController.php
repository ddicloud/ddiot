<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-11 22:13:39
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-22 17:46:36
 */

namespace common\plugins\diandi_hub\admin\member;

use common\plugins\diandi_hub\models\enums\LevelStatus;
use common\plugins\diandi_hub\models\level\butionLevelEarningsConf as ModelsLevelButionLevelEarningsConf;
use common\plugins\diandi_hub\models\member\butionLevelEarningsConf;
use common\plugins\diandi_hub\models\Searchs\level\butionLevelEarningsConf as LevelButionLevelEarningsConf;
use admin\controllers\AController;
use common\helpers\ResultHelper;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * EarningsconfController implements the CRUD actions for butionLevelEarningsConf model.
 */
class EarningsconfController extends AController
{
    public string $modelSearchName = 'butionLevelEarningsConfSearch
';

    /**
     * Lists all butionLevelEarningsConf models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        global $_GPC;
        $levelnum = intval($_GPC['levelnum']);

        $searchModel = new LevelButionLevelEarningsConf();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200,'获取成功',[
            'searchModel' => $searchModel,
            'levelnum' => $levelnum,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single butionLevelEarningsConf model.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        global $_GPC;
        $levelnum = intval($_GPC['levelnum']);

        return ResultHelper::json(200,'获取成功',[
            'levelnum' => $levelnum,
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new butionLevelEarningsConf model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        global $_GPC;
        $levelnum = intval($_GPC['levelnum']);

        $model = new ModelsLevelButionLevelEarningsConf();

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
     * Updates an existing butionLevelEarningsConf model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        global $_GPC;

        $model = $this->findModel($id);
        $levelnum = intval($_GPC['levelnum']);

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
     * Deletes an existing butionLevelEarningsConf model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        global $_GPC;
        $levelnum = intval($_GPC['levelnum']);

        $this->findModel($id)->delete();

        return $this->redirect(['index', 'levelnum' => $levelnum]);
    }

    /**
     * Finds the butionLevelEarningsConf model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return butionLevelEarningsConf the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ModelsLevelButionLevelEarningsConf::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
