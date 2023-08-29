<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-04 23:37:25
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-08 16:22:12
 */

namespace admin\controllers\member;

use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use common\models\DdMemberAccount;
use common\models\searchs\DdMemberAccount as DdMemberAccountSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * AccountController implements the CRUD actions for DdMemberAccount model.
 */
class AccountController extends AController
{
    public $modelClass = '';

    public string $modelSearchName = 'DdMemberAccountSearch';

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'delete' => ['POST'],
            ],
        ];

        return $behaviors;
    }

    /**
     * Lists all DdMemberAccount models.
     *
     * @return array
     */
    public function actionIndex(): array
    {
        $searchModel = new DdMemberAccountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DdMemberAccount model.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id): array
    {
        return ResultHelper::json(200, '获取成功', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new DdMemberAccount model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate(): array
    {
        $model = new DdMemberAccount();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return ResultHelper::json(200, '获取成功', [
                'model' => $model,
            ]);
        }else{
            $msg = ErrorsHelper::getModelError($model);
            return ResultHelper::json(500,$msg);
        }


    }

    /**
     * Updates an existing DdMemberAccount model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id): array
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return ResultHelper::json(200, '获取成功', [
                'model' => $model,
            ]);
        }else {
            $msg = ErrorsHelper::getModelError($model);
            return ResultHelper::json(500, $msg);
        }
    }

    /**
     * Deletes an existing DdMemberAccount model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id): array
    {
        $this->findModel($id)->delete();

        return ResultHelper::json(200, '删除成功');
    }

    /**
     * Finds the DdMemberAccount model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return array the loaded model
     */
    protected function findModel($id): array
    {
        if (($model = DdMemberAccount::findOne($id)) !== null) {
            return ResultHelper::json(200, '获取成功',(array)$model);
        }

        return ResultHelper::json(500, '请检查数据是否存在');
    }
}
