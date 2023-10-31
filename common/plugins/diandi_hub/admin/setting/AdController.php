<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-10 23:50:31
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-25 18:37:13
 */

namespace common\plugins\diandi_hub\admin\setting;

use common\plugins\diandi_hub\models\advertising\HubLocationAd;
use common\plugins\diandi_hub\models\enums\locationType;
use common\plugins\diandi_hub\models\goods\HubGoodsBaseGoods;
use common\plugins\diandi_hub\models\Searchs\location\HubLocationAd as HubLocationAdSearch;
use common\plugins\diandi_hub\services\LocationService;
use admin\controllers\AController;
use common\helpers\ArrayHelper;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * AdController implements the CRUD actions for HubLocationAd model.
 */
class AdController extends AController
{
    public string $modelSearchName = 'HubLocationAdSearch';

    /**
     * Lists all HubLocationAd models.
     *
     * @return array
     */
    public function actionIndex()
    {
        $searchModel = new HubLocationAdSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HubLocationAd model.
     *
     * @param int $id
     *
     * @return array|null
     *
     */
    public function actionView($id): ?array
    {
        $info = HubLocationAd::find()->where(['id' => $id])->asArray()->one();
        $info['goods_name'] = HubGoodsBaseGoods::find()->where(['goods_id' => $info['goods_id']])->asArray()->one()['goods_name'];

        return ResultHelper::json(200, '获取成功', [
            'model' => $info,
        ]);
    }

    /**
     * Creates a new HubLocationAd model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate()
    {
        $model = new HubLocationAd();

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            return ResultHelper::json(200, '新建成功', [
                'model' => $model,
            ]);
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(401, $msg);
        }

        $type = locationType::getValueByName('图片');

        $locations = LocationService::getLocation($type);

        return ResultHelper::json(200, '获取成功', [
            'model' => $model,
            'locations' => ArrayHelper::map($locations, 'id', 'name'),
        ]);
    }

    /**
     * Updates an existing HubLocationAd model.
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

        $type = locationType::getValueByName('图片');

        $locations = LocationService::getLocation($type);

        return ResultHelper::json(200, '获取成功', [
            'model' => $model,
            'locations' => ArrayHelper::map($locations, 'id', 'name'),
        ]);
    }

    /**
     * Deletes an existing HubLocationAd model.
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
     * Finds the HubLocationAd model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return HubLocationAd the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubLocationAd::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
