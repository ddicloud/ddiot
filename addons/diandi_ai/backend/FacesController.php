<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-09-19 08:47:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-09-19 09:37:54
 */

namespace addons\diandi_ai\backend;

use backend\controllers\BaseController;
use addons\diandi_ai\models\DdAiFaces;
use addons\diandi_ai\models\searchs\DdAiFacesSearch;
use addons\diandi_ai\models\searchs\DdAiMemberSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

/**
 * DdAiFacesController implements the CRUD actions for DdAiFaces model.
 */
class FacesController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all DdAiFaces models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DdAiFacesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DdAiFaces model.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new DdAiFaces model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DdAiFaces();

        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            if ($model->load($data) && $model->save()) {
                $model->addUser($data['DdAiFaces']['face_image'], $data['DdAiFaces']['ai_group_id'], $data['DdAiFaces']['ai_user_id']);

                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $message = $model->getErrors();

                throw new BadRequestHttpException($message);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUsers()
    {
        $searchModel = new DdAiMemberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->renderAjax('users', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing DdAiFaces model.
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

        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            if ($model->load($data) && $model->save()) {
                $model->updateUser($data['DdAiFaces']['face_image'], $data['DdAiFaces']['ai_group_id'], $data['DdAiFaces']['ai_user_id']);

                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $message = $model->getErrors();

                throw new BadRequestHttpException($message);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DdAiFaces model.
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
        $model = $this->findModel($id);

        $group_id = $model->ai_group_id;
        $faceToken = $model->face_token;
        $ai_user_id = $model->ai_user_id;

        $res = $model->faceDelete($ai_user_id, $group_id, $faceToken);
        if ($res['error_code'] == 0) {
            $this->findModel($id)->delete();
        } else {
            $message = Yii::$app->params['aierror'][$res['error_code']];

            throw new BadRequestHttpException($message);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the DdAiFaces model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return DdAiFaces the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DdAiFaces::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
