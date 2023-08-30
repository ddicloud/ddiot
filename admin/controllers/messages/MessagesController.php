<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-10-18 17:50:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-03-10 16:06:38
 */
namespace admin\controllers\messages;

use admin\controllers\AController;
use admin\models\message\HubMessages;
use admin\models\message\HubMessagesRead;
use admin\models\message\Searchs\HubMessagesSearch;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\db\Exception;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

/**
 * MessagesController implements the CRUD actions for HubMessages model.
 */
class MessagesController extends AController
{
    public string $modelSearchName = "HubMessagesSearch";

    public $modelClass = '';

    // 根据公司检索字段,不参与检索设置为false
    public string $blocField = '';

    // 根据商户检索字段,不参与检索设置为false
    public string $storeField = '';

    /**
     * Lists all HubMessages models.
     * @return array
     */
    public function actionIndex(): array
    {
        $searchModel = new HubMessagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all HubMessages models.
     * @return array
     */
    public function actionList(): array
    {
        $searchModel = new HubMessagesSearch();
        $dataProvider = $searchModel->searchList(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HubMessages model.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id): array
    {

        $view = $this->findModel($id);

        return ResultHelper::json(200, '获取成功', $view);
    }

    /**
     * Displays a single HubMessages model.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException|\yii\db\Exception if the model cannot be found
     */
    public function actionUserView(int $id): array
    {
        $model = $this->findModel($id);
        if ($model) {
            HubMessages::updateAllCounters(['view' => 1], ['id' => $id]);
            $read = null;
            if (!empty(Yii::$app->user->identity->user_id)) {
                $read = HubMessagesRead::find()->where(['admin_id' => Yii::$app->user->identity->user_id, 'message_id' => $model->id??0])->one();
            }
            if (!$read) {
                $readModel = new HubMessagesRead;
                    $readModel->admin_id = Yii::$app->user->identity->user_id??0;

                $readModel->message_id = $model->id??0;
                $readModel->save(false);
            }
        }
        return ResultHelper::json(200, '获取成功', [
            'data' => $model,
            'unread' => HubMessages::countUnread(Yii::$app->user->identity->user_id??0),
        ]);
    }

    /**
     * Displays a single HubMessages model.
     * @return array
     * @throws Exception
     */
    public function actionUnread(): array
    {
        return ResultHelper::json(200, '获取成功', ['unread' => HubMessages::countUnread(Yii::$app->user->identity->user_id??0) ?: 0]);
    }

    /**
     * Creates a new HubMessages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return array
     */
    public function actionCreate(): array
    {
        $model = new HubMessages();

            $data = Yii::$app->request->post();

            if ($model->load($data, '') && $model->save()) {

                return ResultHelper::json(200, '创建成功', (array)$model);
            } else {
                $msg = ErrorsHelper::getModelError($model);
                return ResultHelper::json(400, $msg);
            }

    }

    /**
     * Updates an existing HubMessages model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return array
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id): array
    {
        $model = $this->findModel($id);

            $data = Yii::$app->request->post();

            if ($model->load($data, '') && $model->save()) {

                return ResultHelper::json(200, '编辑成功', $model);
            } else {
                $msg = ErrorsHelper::getModelError($model);
                return ResultHelper::json(400, $msg);
            }

    }

    /**
     * Deletes an existing HubMessages model.
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
     * Finds the HubMessages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HubMessages|array
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): array|\yii\db\ActiveRecord
    {
        if (($model = HubMessages::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionRead($id): array
    {
        $exists = HubMessages::find()->where(['id' => $id])->exists();
        if ($exists) {
            HubMessages::updateAllCounters(['view' => 1], ['id' => $id]);
            $read = HubMessagesRead::find()->where(['admin_id' => Yii::$app->user->identity->user_id??0, 'message_id' => $id])->one();
            if (!$read) {
                $readModel = new HubMessagesRead;
                $readModel->admin_id = Yii::$app->user->identity->user_id??0;
                $readModel->message_id = $id;
                $readModel->save(false);
            }
        }
        return ResultHelper::json(200, '阅读成功！');
    }
}
