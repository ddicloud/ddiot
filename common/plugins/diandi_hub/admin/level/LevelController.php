<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-01 11:49:31
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-26 11:31:53
 */

namespace common\plugins\diandi_hub\admin\level;

use common\plugins\diandi_hub\models\enums\LevelStatus;
use common\plugins\diandi_hub\models\level\HubLevel;
use common\plugins\diandi_hub\models\Searchs\level\HubLevelSearch;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * LevelController implements the CRUD actions for HubLevel model.
 */
class LevelController extends AController
{
    /**
     * Lists all HubLevel models.
     *
     * @return array
     */
    public function actionIndex()
    {
        $searchModel = new HubLevelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HubLevel model.
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

    public function actionDetail()
    {
        global $_GPC;
        $id =\Yii::$app->request->input('id');
        $detail = $this->findModel($id);

        return ResultHelper::json(200, '获取成功', $detail);
    }

    public function actionCreateInit()
    {
        $model = new HubLevel();
        // 所有等级数据
        $levels = LevelStatus::listData();
        // 使用了的等级数据
        $levelHave = HubLevel::find()->select(['levelnum', 'levelname'])->indexBy('levelnum')->asArray()->all();

        $arr = [];
        foreach ($levels as $key => $value) {
            if (empty($levelHave[$key])) {
                $arr[] = [
                    'text' => $value,
                    'value' => $key,
                ];
            }
        }

        return ResultHelper::json(200, '获取成功', [
            'levels' => $arr,
        ]);
    }

    /**
     * Creates a new HubLevel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate()
    {
        $model = new HubLevel();

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return ResultHelper::json(200, '编辑成功', []);
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg, Yii::$app->request->post());
        }
    }

    /**
     * Updates an existing HubLevel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        global $_GPC;

        $id =\Yii::$app->request->input('id');
        $model = $this->findModel($id);
        if ($model->load($_GPC, '') && $model->save()) {
            return ResultHelper::json(200, '编辑成功', []);
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg, Yii::$app->request->post());
        }
    }

    /**
     * Deletes an existing HubLevel model.
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

        return ResultHelper::json(200, '删除成功');
    }

    /**
     * Finds the HubLevel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return HubLevel the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubLevel::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
