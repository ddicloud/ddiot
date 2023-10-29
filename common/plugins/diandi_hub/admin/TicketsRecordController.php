<?php

namespace common\plugins\diandi_hub\admin;

use Yii;
use common\plugins\diandi_hub\models\HubTicketsRecord;
use common\plugins\diandi_hub\models\Searchs\HubTicketsRecordSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BaseController;
use admin\controllers\AController;
use common\helpers\ResultHelper;
use common\helpers\ErrorsHelper;
use common\plugins\diandi_hub\models\enums\{
    TicketsRecordType,
};
use common\plugins\diandi_hub\services\TicketsRecordService;

/**
 * TicketsRecordController implements the CRUD actions for HubTicketsRecord model.
 */
class TicketsRecordController extends AController
{
    public string $modelSearchName = "HubTicketsRecordSearch";

    public $modelClass = '';


    /**
     * Lists all HubTicketsRecord models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HubTicketsRecordSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HubTicketsRecord model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

         try {
            $view = $this->findModel($id)->toArray();
        } catch (NotFoundHttpException $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        }

        return ResultHelper::json(200, '获取成功', $view);
    }

    /**
     * Creates a new HubTicketsRecord model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new HubTicketsRecord();

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

    public function actionSend()
    {
        $data = Yii::$app->request->post();
        $data['send_id'] = \Yii::$app->user->identity->user_id;
        $data['type'] = TicketsRecordType::DEV_SENDS;
        list($bool, $model) = TicketsRecordService::create($data);
        if ($bool) {
            $data['id'] = $model->id;
            return ResultHelper::json(200, '创建成功！', $model->getAttributes());
        } else {
            return ResultHelper::json(400, current($model->getFirstErrors()), $model->getErrors());
        }
    }

    /**
     * Updates an existing HubTicketsRecord model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionUpdate($id)
    // {
    //     $model = $this->findModel($id);


    //     if (Yii::$App->request->isPut) {
    //         $data = Yii::$App->request->post();

    //         if ($model->load($data, '') && $model->save()) {

    //             return ResultHelper::json(200, '编辑成功', $model);
    //         } else {
    //             $msg = ErrorsHelper::getModelError($model);
    //             return ResultHelper::json(400, $msg);
    //         }
    //     }
    // }

    /**
     * Deletes an existing HubTicketsRecord model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->delete();

    //     return ResultHelper::json(200, '删除成功');
    // }

    /**
     * Finds the HubTicketsRecord model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HubTicketsRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubTicketsRecord::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
