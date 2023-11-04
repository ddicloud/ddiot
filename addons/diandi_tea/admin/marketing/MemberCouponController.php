<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-26 10:34:11
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-24 11:09:32
 */

namespace addons\diandi_tea\admin\marketing;

use addons\diandi_tea\models\enums\CouponType;
use addons\diandi_tea\models\enums\ReceiveType;
use addons\diandi_tea\models\marketing\TeaMemberCoupon;
use addons\diandi_tea\models\searchs\marketing\TeaMemberCoupon as TeaMemberCouponSearch;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

/**
 * MemberCouponController implements the CRUD actions for TeaMemberCoupon model.
 */
class MemberCouponController extends AController
{
    public string $modelSearchName = 'TeaMemberCoupon';

    public $modelClass = '';

    /**
     * @SWG\Get(path="/diandi_tea/marketing/member-coupon/index",
     *    tags={"会员卡券"},
     *    summary="列表详情",
     *     @SWG\Response(
     *         response = 200,
     *         description = "列表详情",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     * )
     */
    public function actionIndex(): array
    {
        $searchModel = new TeaMemberCouponSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @SWG\Get(path="/diandi_tea/marketing/member-coupon/view",
     *    tags={"会员卡券"},
     *    summary="卡券详情",
     *     @SWG\Response(
     *         response = 200,
     *         description = "卡券详情",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *    @SWG\Parameter(
     *     in="query",
     *     name="type",
     *     type="integer",
     *     description="卡券类型1：代金券 2：时长卡  3：次卡 4：折扣券 5：体验券",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="id",
     *     type="integer",
     *     description="id",
     *     required=false,
     *   ),
     * )
     */
    public function actionView($id): array
    {
         try {
             $view = $this->findModel($id)->toArray();
             $list = TeaMemberCoupon::find()->with('member')->where(['id' => $id])->asArray()->one();

             $CouponType = CouponType::listData();
             $ReceiveType = ReceiveType::listData();
             $list['coupon_type'] = $CouponType[$list['coupon_type']];
             $list['receive_type'] = $ReceiveType[$list['receive_type']];

             return ResultHelper::json(200, '获取成功', $list);
        } catch (NotFoundHttpException $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        }

    }

    /**
     * @SWG\Post(path="/diandi_tea/marketing/member-coupon/create",
     *    tags={"会员卡券"},
     *    summary="创建卡券",
     *     @SWG\Response(
     *         response = 200,
     *         description = "创建卡券",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *    @SWG\Parameter(
     *     in="query",
     *     name="coupon_type",
     *     type="integer",
     *     description="卡券类型1：代金券 2：时长卡  3：次卡 4：折扣券 5：体验券",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="member_id",
     *     type="integer",
     *     description="用户id：4691",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="coupon_name",
     *     type="string",
     *     description="卡券名称",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="coupon_id",
     *     type="integer",
     *     description="卡券id",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="buy_time",
     *     type="string",
     *     description="购买时间",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="use_num",
     *     type="integer",
     *     description="使用次数",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="surplus_num",
     *     type="integer",
     *     description="剩余次数",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="receive_type",
     *     type="integer",
     *     description="领取方式：1.领取 2.购买 3.充值赠送",
     *     required=false,
     *   ),
     * )
     */
    public function actionCreate(): array
    {
        $model = new TeaMemberCoupon();

        $data = Yii::$app->request->post();

        if ($model->load($data, '') && $model->save()) {
            return ResultHelper::json(200, '创建成功', $model->toArray());
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }
    }

    /**
     * @SWG\Post(path="/diandi_tea/marketing/member-coupon/update",
     *    tags={"会员卡券"},
     *    summary="编辑卡券",
     *     @SWG\Response(
     *         response = 200,
     *         description = "编辑卡券",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *    @SWG\Parameter(
     *     in="query",
     *     name="coupon_type",
     *     type="integer",
     *     description="卡券类型1：代金券 2：时长卡  3：次卡 4：折扣券 5：体验券",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="member_id",
     *     type="integer",
     *     description="用户id：4691",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="coupon_name",
     *     type="string",
     *     description="卡券名称",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="coupon_id",
     *     type="integer",
     *     description="卡券id",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="buy_time",
     *     type="string",
     *     description="购买时间",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="use_num",
     *     type="integer",
     *     description="使用次数",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="surplus_num",
     *     type="integer",
     *     description="剩余次数",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="receive_type",
     *     type="integer",
     *     description="领取方式：1.领取 2.购买 3.充值赠送",
     *     required=false,
     *   ),
     * )
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
     * @SWG\Get(path="/diandi_tea/marketing/member-coupon/create",
     *    tags={"会员卡券"},
     *    summary="删除卡券",
     *     @SWG\Response(
     *         response = 200,
     *         description = "删除卡券",
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
            return ResultHelper::json(200, '删除成功');

        } catch (StaleObjectException|NotFoundHttpException $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        } catch (\Throwable $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);

        }

    }

    /**
     * Finds the TeaMemberCoupon model based on its primary key value.
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
        if (($model = TeaMemberCoupon::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
