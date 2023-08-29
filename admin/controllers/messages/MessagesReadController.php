<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-10-18 17:50:23
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-03-10 16:06:46
 */
namespace admin\controllers\messages;

use admin\controllers\AController;
use admin\models\message\HubMessagesRead;
use admin\models\message\Searchs\HubMessagesReadSearch;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\db\StaleObjectException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * MessagesReadController implements the CRUD actions for HubMessagesRead model.
 */
class MessagesReadController extends AController
{
    public string $modelSearchName = "HubMessagesReadSearch";

    public $modelClass = '';

    // 根据公司检索字段,不参与检索设置为false
    public string $blocField = '';

    // 根据商户检索字段,不参与检索设置为false
    public string $storeField = '';

    /**
     * Lists all HubMessagesRead models.
     * @return array
     */
    public function actionIndex(): array
    {
        $searchModel = new HubMessagesReadSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HubMessagesRead model.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id): array
    {

        $view = $this->findModel($id);

        return ResultHelper::json(200, '获取成功', (array)$view);
    }

    /**
     * Creates a new HubMessagesRead model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return array
     */
    public function actionCreate(): array
    {
        $model = new HubMessagesRead();

        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();

            if ($model->load($data, '') && $model->save()) {

                return ResultHelper::json(200, '创建成功', (array)$model);
            } else {
                $msg = ErrorsHelper::getModelError($model);
                return ResultHelper::json(400, $msg);
            }
        }
    }

    /**
     * Updates an existing HubMessagesRead model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id): array
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPut) {
            $data = Yii::$app->request->post();

            if ($model->load($data, '') && $model->save()) {

                return ResultHelper::json(200, '编辑成功', (array)$model);
            } else {
                $msg = ErrorsHelper::getModelError($model);
                return ResultHelper::json(400, $msg);
            }
        }
    }

    /**
     * Deletes an existing HubMessagesRead model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionDelete($id): array
    {
        $this->findModel($id)->delete();

        return ResultHelper::json(200, '删除成功');
    }

    /**
     * Finds the HubMessagesRead model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return array the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): array
    {
        if (($model = HubMessagesRead::findOne($id)) !== null) {
            return ResultHelper::json(200, '获取成功',(array)$model);
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
