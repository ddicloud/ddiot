<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-11 16:41:45
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-22 17:50:49
 */

namespace common\plugins\diandi_hub\admin\setting;

use common\plugins\diandi_hub\models\pickup\HubShopAreas;
use common\plugins\diandi_hub\models\Searchs\pickup\HubShopAreas as PickupHubShopAreas;
use admin\controllers\AController;
use common\helpers\LevelTplHelper;
use common\helpers\ResultHelper;
use common\models\DdRegion;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * AreaController implements the CRUD actions for DdShopAreas model.
 */
class AreaController extends AController
{
    public string $modelSearchName = 'DdShopAreas';

    /**
     * Lists all DdShopAreas models.
     *
     * @return array
     */
    public function actionIndex()
    {
        $searchModel = new PickupHubShopAreas();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200,'获取成功',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DdShopAreas model.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return ResultHelper::json(200,'获取成功',[
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new DdShopAreas model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate()
    {
        $model = new HubShopAreas();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->area_id]);
        }

        $region = new DdRegion();
        $Helper = new LevelTplHelper([
            'pid' => 'pid',
            'cid' => 'id',
            'title' => 'name',
            'model' => $region,
            'id' => 'id',
        ]);

        return ResultHelper::json(200,'获取成功',[
            'model' => $model,
            'Helper' => $Helper,
            'region' => $region,
        ]);
    }

    /**
     * Updates an existing DdShopAreas model.
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
            return $this->redirect(['view', 'id' => $model->area_id]);
        }
        $region = new DdRegion();
        $Helper = new LevelTplHelper([
            'pid' => 'pid',
            'cid' => 'id',
            'title' => 'name',
            'model' => $region,
            'id' => 'id',
        ]);

        return ResultHelper::json(200,'获取成功',[
            'model' => $model,
            'Helper' => $Helper,
            'region' => $region,
        ]);
    }

    /**
     * 设置默认.
     *
     * @return void
     */
    public function actionSetdefault()
    {
        if (Yii::$app->request->isPost) {
            $pk = Yii::$app->request->post('pk');
            $id = unserialize(base64_decode($pk));
            $files = Yii::$app->request->post('name');
            $value = Yii::$app->request->post('value');
            $DdShopAreas = new HubShopAreas();

            HubShopAreas::updateAll([
                $files => 0,
            ], [
                'bloc_id' => Yii::$app->params['bloc_id'],
                'store_id' => Yii::$app->params['store_id'],
            ]);
            $Res = HubShopAreas::updateAll([$files => $value == '是' ? 1 : 0], ['area_id' => $id]);

            return ResultHelper::json(200, '修改成功', []);
        }
    }

    /**
     * Deletes an existing DdShopAreas model.
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
 return ResultHelper::json(200,'删除成功');
    }

    /**
     * Finds the DdShopAreas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return DdShopAreas the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubShopAreas::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
