<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-21 16:15:18
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-09 11:03:40
 */

namespace addons\diandi_tea\admin\config;

use addons\diandi_tea\models\config\TeaGlobalConfig;
use addons\diandi_tea\models\searchs\config\TeaGlobalConfig as TeaGlobalConfigSearch;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

/**
 * GlobalConfigController implements the CRUD actions for TeaGlobalConfig model.
 */
class GlobalConfigController extends AController
{
    public string $modelSearchName = 'TeaGlobalConfig';

    public $modelClass = '';

    public function actionIndex(): array
   {
        //$where['store_id'] =\Yii::$app->request->input('store_id',0);
        $searchModel = new TeaGlobalConfigSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id): array
    {
         try {
            $view = $this->findModel($id)->toArray();
        } catch (NotFoundHttpException $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        }

        return ResultHelper::json(200, '获取成功', $view);
    }


    public function actionCreate(): array
   {

        $model = new TeaGlobalConfig();
        $data = Yii::$app->request->post();
        $where['store_id'] =\Yii::$app->request->input('store_id',0);
        $is_add = $model->find()->where(['store_id' =>\Yii::$app->request->input('store_id',0)])->asArray()->one();

        //print_r($is_add);die;
        if ($is_add) {
            TeaGlobalConfig::updateAll($data, ['id' => $is_add['id']]);

            return ResultHelper::json(200, '编辑成功');
        } else {
            if ($model->load($data, '') && $model->save()) {
                return ResultHelper::json(200, '创建成功', $model->toArray());
            } else {
                $msg = ErrorsHelper::getModelError($model);

                return ResultHelper::json(400, $msg);
            }
        }
    }

    /**
     * Deletes an existing TeaGlobalConfig model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
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
     * Finds the TeaGlobalConfig model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return array|ActiveRecord the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): array|\yii\db\ActiveRecord
    {
        if (($model = TeaGlobalConfig::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
