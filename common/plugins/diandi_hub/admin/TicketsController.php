<?php

namespace common\plugins\diandi_hub\admin;

use Yii;
use common\plugins\diandi_hub\models\HubTickets;
use common\plugins\diandi_hub\models\Searchs\HubTicketsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BaseController;
use admin\controllers\AController;
use common\helpers\ResultHelper;
use common\helpers\ErrorsHelper;
use common\plugins\diandi_hub\services\TicketsService;


/**
 * HubTicketsController implements the CRUD actions for HubTickets model.
 */
class TicketsController extends AController
{
    public string $modelSearchName = "HubTicketsSearch";

    public $modelClass = '';


    /**
     * Lists all HubTickets models.
     * @return array
     */
    public function actionIndex(): array
    {
        $searchModel = new HubTicketsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HubTickets model.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $view = $this->findArray($id);

        return ResultHelper::json(200, '获取成功', $view);
    }

    /**
     * Creates a new HubTickets model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return array
     */
    public function actionCreate()
    {
        $model = new HubTickets();

        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();

            if ($model->load($data, '') && $model->save()) {

                return ResultHelper::json(200, '创建成功', $model);
            } else {
                $msg = ErrorsHelper::getModelError($model);
                return ResultHelper::json(400, $msg);
            }
        }
    }

    /**
     * Updates an existing HubTickets model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);


        if (Yii::$app->request->isPut) {
            $data = Yii::$app->request->post();

            if ($model->load($data, '') && $model->save()) {

                return ResultHelper::json(200, '编辑成功', $model);
            } else {
                $msg = ErrorsHelper::getModelError($model);
                return ResultHelper::json(400, $msg);
            }
        }
    }

    /**
     * Deletes an existing HubTickets model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->delete();

    //     return ResultHelper::json(200, '删除成功');
    // }

    /**
     * Finds the HubTickets model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HubTickets the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubTickets::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findArray($id)
    {
        if (($model = HubTickets::find()->where(['id' => $id])->with(['order', 'goods'])->asArray()->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionStatus($id)
    {
        $temp = \Yii::$app->request->post();
        $where = [
            'id' => $id,
        ];
        list($bool, $model) = TicketsService::updateStatus($where, $temp['status'] ?? -1);
        if ($bool) {
            return ResultHelper::json(200, '修改成功！', $model->getAttributes());
        } else {
            return ResultHelper::json(400, current($model->getFirstErrors()), $model->getErrors());
        }
    }
}
