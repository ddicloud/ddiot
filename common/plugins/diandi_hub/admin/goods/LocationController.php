<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-05 12:42:03
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-26 18:07:17
 */

namespace common\plugins\diandi_hub\admin\goods;

use common\plugins\diandi_hub\models\advertising\HubLocation;
use common\plugins\diandi_hub\models\advertising\HubLocationAd;
use common\plugins\diandi_hub\models\advertising\HubLocationGoods;
use common\plugins\diandi_hub\models\enums\locationPage;
use common\plugins\diandi_hub\models\enums\locationStyle;
use common\plugins\diandi_hub\models\goods\HubGoodsBaseGoods;
use common\plugins\diandi_hub\models\Searchs\location\LocationSearch;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\web\NotFoundHttpException;
use yii2mod\editable\EditableAction;

/**
 * LocationController implements the CRUD actions for HubLocation model.
 */
class LocationController extends AController
{
    public string $modelSearchName = 'LocationSearch';

    public function actions()
    {
        return [
            'change-order' => [
                'class' => EditableAction::class,
                'modelClass' => HubLocation::class,
            ],
        ];
    }

    /**
     * Lists all HubLocation models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        global  $_GPC;

        $searchModel = new LocationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HubLocation model.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = HubLocation::find()->where(['id' => $id])->asArray()->one();
        $model['goods_name'] = HubGoodsBaseGoods::find()->select(['goods_name'])->where(['goods_id' => $model['goods_id']])->asArray()->one()['goods_name'];

        return ResultHelper::json(200, '获取成功', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new HubLocation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        global $_GPC;
        $model = new HubLocation();
        if ($model->load($_GPC, '') && $model->save()) {
            return ResultHelper::json(200, '新建成功', [
                'model' => $model,
            ]);
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(401, $msg);
        }
    }

    /**
     * Updates an existing HubLocation model.
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
        global $_GPC;
        $model = $this->findModel($id);

        if ($model->load($_GPC, '') && $model->save()) {
            // 更新该位置下的商品和图片广告位对应的mark
            $mark = $_GPC['HubLocation']['mark'];
            HubLocationGoods::updateAll(['mark' => $mark], ['location_id' => $id]);
            HubLocationAd::updateAll(['mark' => $mark], ['location_id' => $id]);
        }

        $pages = locationPage::listData();

        $styles = locationStyle::listData();

        return ResultHelper::json(200, '获取成功', [
            'model' => $model,
            'pages' => $pages,
            'styles' => $styles,
        ]);
    }

    /**
     * Deletes an existing HubLocation model.
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
     * Finds the HubLocation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return HubLocation the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HubLocation::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
