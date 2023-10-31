<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-11 22:12:48
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-22 14:16:30
 */

namespace common\plugins\diandi_hub\admin\member;

use common\plugins\diandi_hub\models\enums\LevelStatus;
use common\plugins\diandi_hub\models\level\HubLevelBaseConf;
use common\plugins\diandi_hub\models\Searchs\level\HubLevelBaseConf as HubLevelBaseConfSearch;
use admin\controllers\AController;
use common\helpers\ResultHelper;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * BaseconfController implements the CRUD actions for HubLevelBaseConf model.
 */
class BaseconfController extends AController
{
    public string $modelSearchName = 'HubLevelBaseConfSearch';

    /**
     * Lists all HubLevelBaseConf models.
     *
     * @return array
     */
    public function actionIndex()
    {
        global $_GPC;
        $levelnum = intval($_GPC['levelnum']);
        $searchModel = new HubLevelBaseConfSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200,'获取成功',[
            'levelnum' => $levelnum,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HubLevelBaseConf model.
     *
     * @param int $id
     *
     * @return array
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
     * Creates a new HubLevelBaseConf model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate()
    {
        global $_GPC;
        $levelnum = intval($_GPC['levelnum']);

        $model = new HubLevelBaseConf();

        $levels = LevelStatus::listData();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'levelnum' => $levelnum]);
        }

        return ResultHelper::json(200,'获取成功',[
            'levelnum' => $levelnum,
            'levels' => $levels,
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing HubLevelBaseConf model.
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
        $levelnum = intval($_GPC['levelnum']);
        $model = $this->findModel($id);

        $levels = LevelStatus::listData();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'levelnum' => $levelnum]);
        }

        return ResultHelper::json(200,'获取成功',[
            'levelnum' => $levelnum,
            'levels' => $levels,
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing HubLevelBaseConf model.
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
        global $_GPC;
        $levelnum = intval($_GPC['levelnum']);

        $this->findModel($id)->delete();

        return $this->redirect(['index', 'levelnum' => $levelnum]);
    }

    /**
     * Finds the HubLevelBaseConf model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return HubLevelBaseConf the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubLevelBaseConf::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
