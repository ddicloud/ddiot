<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-18 17:47:15
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-24 11:51:48
 */

namespace addons\diandi_tea\admin\order;

use addons\diandi_tea\models\enums\CouponType;
use addons\diandi_tea\models\order\TeaCouponBuyList;
use addons\diandi_tea\models\searchs\order\TeaCouponBuyList as TeaCouponBuyListSearch;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

/**
 * CouponBuyListController implements the CRUD actions for TeaCouponBuyList model.
 */
class CouponBuyListController extends AController
{
    public string $modelSearchName = 'TeaCouponBuyList';

    public $modelClass = '';

    /**
     * @SWG\Get(path="/diandi_tea/order/coupon-buy-list/index",
     *    tags={"卡券购买"},
     *    summary="列表数据",
     *     @SWG\Response(
     *         response = 200,
     *         description = "列表数据",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *    @SWG\Parameter(
     *     in="query",
     *     name="CouponAar[coupon_name]",
     *     type="string",
     *     description="卡券名",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="CouponAar[coupon_type]",
     *     type="integer",
     *     description="卡券类型1：代金券 2：时长卡  3：次卡 4：折扣券 5：体验券",
     *     required=false,
     *   )
     * )
     */
    public function actionIndex(): array
    {
        $searchModel = new TeaCouponBuyListSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @SWG\Get(path="/diandi_tea/order/coupon-buy-list/view",
     *    tags={"卡券购买"},
     *    summary="卡券详情",
     *     @SWG\Response(
     *         response = 200,
     *         description = "卡券详情",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     * )
     */
    public function actionView($id): array
    {
        try {
            $view = TeaCouponBuyList::find()->where(['id' => $id])->with(['member'])->asArray()->one();
            $couponType = CouponType::listData();
            $view['coupon_type'] = $couponType[$view['coupon_type']];

            return ResultHelper::json(200, '获取成功', $view);
        } catch (NotFoundHttpException $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        }

    }

    /**
     * Creates a new TeaCouponBuyList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate(): array
    {
        $model = new TeaCouponBuyList();

        $data = Yii::$app->request->post();

        if ($model->load($data, '') && $model->save()) {
            return ResultHelper::json(200, '创建成功', $model->toArray());
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }

    }

    /**
     * Updates an existing TeaCouponBuyList model.
     * If the update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id): array
    {
        $model = $this->findModel($id);

        $data = Yii::$app->request->post();

        if ($model->load($data, '') && $model->save()) {
            return ResultHelper::json(200, '编辑成功', $model->toArray());
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }

    }

    /**
     * @SWG\Get(path="/diandi_tea/order/coupon-buy-list/delete",
     *    tags={"卡券购买"},
     *    summary="购买记录删除",
     *     @SWG\Response(
     *         response = 200,
     *         description = "购买记录删除",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     * )
     */
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
     * Finds the TeaCouponBuyList model based on its primary key value.
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
        if (($model = TeaCouponBuyList::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
