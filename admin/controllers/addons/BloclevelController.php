<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-06-03 17:40:00
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-03-14 18:57:12
 */

namespace admin\controllers\addons;

use admin\controllers\AController;
use admin\models\enums\LevelStatus;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use diandi\addons\models\BlocLevel;
use diandi\addons\models\searchs\BlocLevel as BlocLevelSearch;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * BloclevelController implements the CRUD actions for BlocLevel model.
 */
class BloclevelController extends AController
{
    public $modelSearchName = 'BlocLevel';

    public $modelClass = '';

    /**
     * Lists all BlocLevel models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BlocLevelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BlocLevel model.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $view = $this->findModel($id);

        return ResultHelper::json(200, '获取成功', $view);
    }

    /**
     * Creates a new BlocLevel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BlocLevel();

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
     * Updates an existing BlocLevel model.
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
     * Deletes an existing BlocLevel model.
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
        $this->findModel($id)->delete();

        return ResultHelper::json(200, '删除成功');
    }

    /**
     * Finds the BlocLevel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return BlocLevel the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BlocLevel::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('请检查数据是否存在');
    }

    public function actionLevels()
    {
        $list = LevelStatus::listData();

        $lists = [];

        foreach ($list as $key => $value) {
            $lists[] = [
                'text' => $value,
                'value' => $key,
            ];
        }

        return ResultHelper::json(200, '获取成功', $lists);
    }
}
