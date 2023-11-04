<?php
/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-02 08:17:45
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-06-15 16:34:14
 */
 

namespace addons\diandi_integral\admin\order;

use Yii;

use addons\diandi_integral\models\IntegralDelivery;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;
use addons\diandi_integral\models\searchs\IntegralDeliverySearch;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use common\models\DdRegion;

/**
 * DdDeliveryController implements the CRUD actions for DdDelivery model.
 */
class DdDeliveryController extends AController
{
    public string $modelSearchName = 'DdDeliverySearch';
    

    public function actions(): array
    {
        $actions = parent::actions();
        $actions['get-region'] = [
            'class' => \diandi\region\RegionAction::class,
            'model' => DdRegion::class
        ];
        return $actions;
    }


    public function actionIndex(): array
    {
        $searchModel = new IntegralDeliverySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200,'获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($id): array
    {
        $model = IntegralDelivery::find()->where(['id'=>$id])->asArray()->one();

        $model['blocs'] = [$model['bloc_id'],$model['store_id']];

        return ResultHelper::json(200,'获取成功', [
            'model' => $model,
        ]);
    }

    public function actionCreate(): array
   {
        $model = new IntegralDelivery();

        $data = \Yii::$app->request->input();
        $blocs =\Yii::$app->request->input('blocs');
        $data['bloc_id'] = $blocs[0];
        $data['store_id']= $blocs[1];

        unset($data['region_id']);
        $data['province'] = Yii::$app->request->post()['region_id'][0];
        $data['city'] = Yii::$app->request->post()['region_id'][1];
        $data['district'] = Yii::$app->request->post()['region_id'][2];
        if ($model->load($data,'') && $model->save()) {
            return ResultHelper::json(200,'添加成功');
        }else{
            $msg = ErrorsHelper::getModelError($model);
            return ResultHelper::json(400, $msg);
        }

        
    }


    public function actionUpdate($id): array
   {

        try {
            $model = $this->findModel($id);
            $data = \Yii::$app->request->input();
            $blocs =\Yii::$app->request->input('blocs');
            $data['bloc_id'] = $blocs[0];
            $data['store_id']= $blocs[1];
            if ($model->load($data,'') && $model->save()) {
                return ResultHelper::json(200,'编辑成功');
            }else{
                $message = ErrorsHelper::getModelError($model);
                return ResultHelper::json(401,$message);
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

        return ResultHelper::json(200,'获取成功', ['index']);
    }

    /**
     * Finds the DdDelivery model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return array|ActiveRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): array|\yii\db\ActiveRecord
    {
        if (($model = IntegralDelivery::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('请检查数据是否存在');
    }
}
