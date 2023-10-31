<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-06 23:40:45
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-26 14:59:40
 */

namespace common\plugins\diandi_hub\admin\express;

use common\plugins\diandi_hub\models\express\HubExpressCompany;
use common\plugins\diandi_hub\models\express\HubExpressTemplateArea;
use common\plugins\diandi_hub\models\Searchs\express\HubExpressCompany as HubExpressCompanySearch;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * ExpressController implements the CRUD actions for HubExpressCompany model.
 */
class ExpressController extends AController
{
    public string $modelSearchName = 'HubExpressCompanySearch';

    /**
     * Lists all HubExpressCompany models.
     *
     * @return array
     */
    public function actionIndex()
    {
        $searchModel = new HubExpressCompanySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HubExpressCompany model.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return ResultHelper::json(200, '获取成功', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionInit()
    {
        $express = HubExpressCompany::find()->where(['status' => 1])->asArray()->all();
        return ResultHelper::json(200, '获取成功', [
            'express' => $express,
        ]);
    }

    /**
     * Creates a new HubExpressCompany model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate()
    {
        $model = new HubExpressCompany();

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return ResultHelper::json(200, '新建成功', [
                'model' => $model,
            ]);
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(401, $msg);
        }
    }

    /**
     * Updates an existing HubExpressCompany model.
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

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return ResultHelper::json(200, '新建成功', [
                'model' => $model,
            ]);
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(401, $msg);
        }
    }

    /**
     * Deletes an existing HubExpressCompany model.
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
        HubExpressTemplateArea::deleteAll(['template_id' => $id]);

        return $this->redirect(['index']);
    }

    /**
     * Finds the HubExpressCompany model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return HubExpressCompany the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubExpressCompany::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
