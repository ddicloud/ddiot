<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-04-21 23:05:20
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 17:01:50
 */

namespace admin\controllers\website;

use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use common\models\DdWebsiteContact;
use common\models\DdWebsiteContactSearch;
use Yii;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

/**
 * DdWebsiteContactController implements the CRUD actions for DdWebsiteContact model.
 */
class DdWebsiteContactController extends AController
{
    public $modelClass = '';

    public int $searchLevel = 0;



    /**
     * Lists all DdWebsiteContact models.
     *
     * @return array
     */
    public function actionIndex(): array
    {
        $searchModel = new DdWebsiteContactSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DdWebsiteContact model.
     *
     * @param int $id
     *
     * @return array
     *
     */
    public function actionView($id): array
    {
        return ResultHelper::json(200, '获取成功', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new DdWebsiteContact model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate(): array
    {
        $model = new DdWebsiteContact();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return ResultHelper::json(200, '获取成功', [
                'model' => $model,
            ]);
        }else{
            $msg = ErrorsHelper::getModelError($model);
            return ResultHelper::json(500, $msg);
        }
    }

    /**
     * Updates an existing DdWebsiteContact model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return array
     *
     */
    public function actionUpdate($id): array
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return ResultHelper::json(200, '获取成功', [
                'model' => $model,
            ]);
        }else{
            $msg = ErrorsHelper::getModelError($model);
            return ResultHelper::json(500, $msg);
        }
    }

    /**
     * Deletes an existing DdWebsiteContact model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return array
     *
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
     * Finds the DdWebsiteContact model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return array|DdWebsiteContact
     *
     */
    protected function findModel($id): array|\yii\db\ActiveRecord
    {
        if (($model = DdWebsiteContact::findOne($id)) !== null) {
            return $model;
        }

        return ResultHelper::json(500, '请检查数据是否存在');
    }
}
