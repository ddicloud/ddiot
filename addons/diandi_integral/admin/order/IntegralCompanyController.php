<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-30 10:38:54
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-06-15 16:36:20
 */


namespace addons\diandi_integral\admin\order;

use Yii;
use addons\diandi_integral\models\IntegralCompany;
use addons\diandi_integral\models\searchs\IntegralCompanySearch;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;
use admin\controllers\AController;
use common\helpers\ResultHelper;
use common\helpers\ErrorsHelper;


/**
 * IntegralCompanyController implements the CRUD actions for IntegralCompany model.
 */
class IntegralCompanyController extends AController
{
    public string $modelSearchName = "IntegralCompanySearch";

    public $modelClass = '';


    public function actionIndex(): array
    {
        $searchModel = new IntegralCompanySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($id): array
    {
        $view = IntegralCompany::find()->where(['id' => $id])->asArray()->one();
        $view['blocs'] = [$view['bloc_id'], $view['store_id']];

        return ResultHelper::json(200, '获取成功', $view);

    }


    public function actionCreate(): array
   {

        $model = new IntegralCompany();

        $data = Yii::$app->request->post();
        $blocs =\Yii::$app->request->input('blocs');
        $data['bloc_id'] = $blocs[0];
        $data['store_id'] = $blocs[1];
        if ($model->load($data, '') && $model->save()) {

            return ResultHelper::json(200, '创建成功', $model->toArray());
        } else {
            $msg = ErrorsHelper::getModelError($model);
            return ResultHelper::json(400, $msg);
        }


    }


    public function actionUpdate($id): array
   {
        try {
            $model = $this->findModel($id);
            $data = Yii::$app->request->post();

            $blocs =\Yii::$app->request->input('blocs');
            $data['bloc_id'] = $blocs[0];
            $data['store_id'] = $blocs[1];

            if ($model->load($data, '') && $model->save()) {

                return ResultHelper::json(200, '编辑成功', $model);
            } else {
                $msg = ErrorsHelper::getModelError($model);
                return ResultHelper::json(400, $msg);
            }
        } catch (NotFoundHttpException $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        }


    }


    public function actionDelete($id): array
    {
        try {
            $this->findModel($id)->delete();
        } catch (StaleObjectException|NotFoundHttpException $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        } catch (\Throwable $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);

        }

        return ResultHelper::json(200, '删除成功');
    }

    /**
     * Finds the IntegralCompany model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return array|ActiveRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): array|\yii\db\ActiveRecord
    {
        if (($model = IntegralCompany::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('请检查数据是否存在');
    }
}
