<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2023-01-31 08:18:52
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-03-14 16:24:54
 */


namespace common\plugins\diandi_hub\admin;

use Yii;
use common\plugins\diandi_hub\models\HubMessages;
use common\plugins\diandi_hub\models\HubMessagesRead;
use common\plugins\diandi_hub\models\Searchs\HubMessagesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BaseController;
use admin\controllers\AController;
use common\helpers\ResultHelper;
use common\helpers\ErrorsHelper;


/**
 * MessagesController implements the CRUD actions for HubMessages model.
 */
class MessagesController extends AController
{
    public string $modelSearchName = "HubMessagesSearch";

    public $modelClass = '';


    /**
     * Lists all HubMessages models.
     * @return mixed
     */
    public function actionIndex()
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
     * @return mixed
     */
    public function actionList()
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
     * Displays a single HubMessages model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUserView($id)
    {
        $model = $this->findModel($id);
        if ($model) {
            HubMessages::updateAllCounters(['view' => 1], ['id' => $id]);
            $read = HubMessagesRead::find()->where(['admin_id' => \Yii::$app->user->identity->user_id, 'message_id' => $model->id])->one();
            if (!$read) {
                $readModel = new HubMessagesRead;
                $readModel->admin_id = \Yii::$app->user->identity->user_id;
                $readModel->message_id = $model->id;
                $readModel->save(false);
            }
        }
        return ResultHelper::json(200, '获取成功', [
            'data' => $model,
            'unread' => HubMessages::countUnread(\Yii::$app->user->identity->user_id)
        ]);
    }

    /**
     * Displays a single HubMessages model.
     * @return mixed
     */
    public function actionUnread()
    {
        return ResultHelper::json(200, '获取成功', ['unread' => HubMessages::countUnread(\Yii::$app->user->identity->user_id) ?: 0]);
    }

    /**
     * Creates a new HubMessages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new HubMessages();

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
     * Updates an existing HubMessages model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
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
     * Deletes an existing HubMessages model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return ResultHelper::json(200, '删除成功');
    }

    /**
     * Finds the HubMessages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HubMessages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubMessages::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionRead($id)
    {
        $exists = HubMessages::find()->where(['id' => $id])->exists();
        if ($exists) {
            HubMessages::updateAllCounters(['view' => 1], ['id' => $id]);
            $read = HubMessagesRead::find()->where(['admin_id' => \Yii::$app->user->identity->user_id, 'message_id' => $id])->one();
            if (!$read) {
                $readModel = new HubMessagesRead;
                $readModel->admin_id = \Yii::$app->user->identity->user_id;
                $readModel->message_id = $id;
                $readModel->save(false);
            }
        }
        return ResultHelper::json(200, '阅读成功！');
    }
}
