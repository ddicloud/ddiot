<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-04-21 23:05:20
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 17:01:55
 */

namespace admin\controllers\website;

use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use common\models\DdWebsiteSlide;
use common\models\searchs\DdWebsiteSlideSearch;
use Yii;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

/**
 * DdWebsiteSlideController implements the CRUD actions for DdWebsiteSlide model.
 */
class DdWebsiteSlideController extends AController
{
    public $modelClass = '';

    protected array $authOptional = [];

    public int $searchLevel = 0;

    /**
     * Lists all DdWebsiteSlide models.
     *
     * @return array
     */
    public function actionIndex(): array
    {

        $searchModel = new DdWebsiteSlideSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DdWebsiteSlide model.
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
     * Creates a new DdWebsiteSlide model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate(): array
    {
        $model = new DdWebsiteSlide();

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return ResultHelper::json(200, '获取成功', [
                'model' => $model,
            ]);
        }else{
            $msg = ErrorsHelper::getModelError($model);
            return ResultHelper::json(400,$msg);
        }

    }

    /**
     * Updates an existing DdWebsiteSlide model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateitem(): array
    {
        global $_GPC;

        $id = Yii::$app->request->input('id');

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return ResultHelper::json(200, '获取成功', [
                'model' => $model,
            ]);
        }else{
            $msg = ErrorsHelper::getModelError($model);
            return ResultHelper::json(400,$msg);
        }
    }

    /**
     * Deletes an existing DdWebsiteSlide model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionDeleteitem(): array
    {
        global $_GPC;

        $id = Yii::$app->request->input('id');
        $this->findModel($id)->delete();

        return ResultHelper::json(200, '删除成功');
    }

    /**
     * Finds the DdWebsiteSlide model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return array|DdWebsiteSlide
     *
     */
    protected function findModel($id): array|\yii\db\ActiveRecord
    {
        if (($model = DdWebsiteSlide::findOne($id)) !== null) {
            return $model;
        }

        return ResultHelper::json(500, '请检查数据是否存在');
    }
}
