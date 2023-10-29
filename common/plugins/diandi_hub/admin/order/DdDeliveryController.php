<?php
/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-02 08:17:45
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-22 17:47:00
 */

namespace common\plugins\diandi_hub\admin\order;

use common\plugins\diandi_hub\models\order\HubDelivery;
use common\plugins\diandi_hub\models\Searchs\pickup\HubDeliverySearch;
use admin\controllers\AController;
use common\helpers\ResultHelper;
use common\models\DdRegion;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * DdDeliveryController implements the CRUD actions for DdDelivery model.
 */
class DdDeliveryController extends AController
{
    public string $modelSearchName = 'DdDeliverySearch';

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
     * Lists all DdDelivery models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HubDeliverySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200,'获取成功',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DdDelivery model.
     *
     * @param int $id
     *
     * @return mixed
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
     * Creates a new DdDelivery model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new HubDelivery();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->delivery_id]);
        }

        return ResultHelper::json(200,'获取成功',[
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DdDelivery model.
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
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->delivery_id]);
        }

        return ResultHelper::json(200,'获取成功',[
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DdDelivery model.
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
        $this->findModel($id)->delete();
 return ResultHelper::json(200,'删除成功');
    }

    /**
     * Finds the DdDelivery model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return DdDelivery the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubDelivery::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
