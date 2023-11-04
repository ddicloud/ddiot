<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-17 09:49:08
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-23 15:27:15
 */

namespace addons\diandi_tea\admin\marketing;

use addons\diandi_tea\models\config\TeaHourse;
use addons\diandi_tea\models\marketing\TeaCoupon;
use addons\diandi_tea\models\searchs\marketing\TeaCoupon as TeaCouponSearch;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

/**
 * CouponController implements the CRUD actions for TeaCoupon model.
 */
class CouponController extends AController
{
    public string $modelSearchName = 'TeaCoupon';

    public $modelClass = '';

    /**
     * @SWG\Get(path="/diandi_tea/marketing/coupon/index",
     *    tags={"营销卡券"},
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
     *     name="CouponAar[name]",
     *     type="string",
     *     description="卡券名",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="CouponAar[type]",
     *     type="integer",
     *     description="卡券类型1：代金券 2：时长卡  3：次卡 4：折扣券 5：体验券",
     *     required=false,
     *   )
     * )
     */
    public function actionIndex(): array
    {
        $searchModel = new TeaCouponSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        //  var_dump($dataProvider);die;
        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @SWG\Get(path="/diandi_tea/marketing/coupon/view",
     *    tags={"营销卡券"},
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
        $view = $this->findModel($id)->toArray();
        if (!empty($view['use_hourse'])) {
            $view['use_hourse'] = explode(',', $view['use_hourse']);

            $houser = TeaHourse::find()->select('name')->where(['id' => $view['use_hourse']])->asArray()->all();
            $houser = array_column($houser, 'name');
            $view['hourse_name'] = implode(',', $houser);
        } else {
            $view['hourse_name'] = '';
        }

        return ResultHelper::json(200, '获取成功', $view);
    }

    /**
     * @SWG\Post(path="/diandi_tea/marketing/coupon/create",
     *    tags={"营销卡券"},
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
     *     name="name",
     *     type="string",
     *     description="卡券名",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="type",
     *     type="integer",
     *     description="卡券类型1：代金券 2：时长卡  3：次卡 4：折扣券 5：体验券",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="explain",
     *     type="string",
     *     description="卡券说明",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="price",
     *     type="number",
     *     description="卡券金额",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="use_start",
     *     type="integer",
     *     description="时间限制-开始时间（只要小时和分钟）",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="use_end",
     *     type="integer",
     *     description="时间限制-结束时间（只要小时和分钟）",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="enable_start",
     *     type="integer",
     *     description="有效期开始时间",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="enable_end",
     *     type="integer",
     *     description="有效期结束时间",
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
     *     name="max_time",
     *     type="string",
     *     description="消费时长",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="enable_start",
     *     type="string",
     *     description="适用店铺",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="enable_week",
     *     type="string",
     *     description="适用星期(分别对应1~7）",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="third_party",
     *     type="string",
     *     description="第三方编号",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="all_num",
     *     type="integer",
     *     description="总发放量",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="max_num",
     *     type="integer",
     *     description="最多可购买数量",
     *     required=false,
     *   )
     * )
     */
    public function actionCreate(): array
   {
        $model = new TeaCoupon();

            $data = Yii::$app->request->post();
            if ($data['type'] == 1) {
                if (empty($data['cash'])) {
                    return ResultHelper::json(400, '缺少代金券金额！');
                }
            } elseif ($data['type'] == 4) {
                if (empty($data['discount'])) {
                    return ResultHelper::json(400, '缺少折扣券折扣！');
                }
            } else {
                if (empty($data['max_time'])) {
                    return ResultHelper::json(400, '缺少消费时长！');
                }
            }

            if ($data['type'] == 5) {
                $is_have = TeaCoupon::find()->select('id')
                    ->where(['bloc_id' =>\Yii::$app->request->input('bloc_id',0), 'store_id' =>\Yii::$app->request->input('store_id',0), 'type' => 5])->asArray()->one();
                if ($is_have['id']) {
                    return ResultHelper::json(400, '已有体验券');
                }
                if (!empty($data['use_hourse'])) {
                    if (count(explode(',', $data['use_hourse'])) > 1) {
                        return ResultHelper::json(400, '体验券只可选择单个房间使用');
                    }
                }
            }
            // if (is_array($data['use_hourse'])) {
            //     $data['use_hourse'] = implode(',', array_unique($data['use_hourse']));
            // } else {
            //     $data['use_hourse'] = '';
            // }
            if ($model->load($data, '') && $model->save()) {
                return ResultHelper::json(200, '创建成功', $model->toArray());
            } else {
                $msg = ErrorsHelper::getModelError($model);

                return ResultHelper::json(400, $msg);
            }
    }

    /**
     * @SWG\Post(path="/diandi_tea/marketing/coupon/update",
     *    tags={"营销卡券"},
     *    summary="更新卡券",
     *     @SWG\Response(
     *         response = 200,
     *         description = "更新卡券",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *    @SWG\Parameter(
     *     in="query",
     *     name="id",
     *     type="integer",
     *     description="卡券id",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="name",
     *     type="string",
     *     description="卡券名",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="type",
     *     type="integer",
     *     description="卡券类型1：代金券 2：时长卡  3：次卡 4：折扣券 5：体验券",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="explain",
     *     type="string",
     *     description="卡券说明",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="price",
     *     type="number",
     *     description="卡券金额",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="use_start",
     *     type="integer",
     *     description="时间限制-开始时间（只要小时和分钟）",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="use_end",
     *     type="integer",
     *     description="时间限制-结束时间（只要小时和分钟）",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="enable_start",
     *     type="integer",
     *     description="有效期开始时间",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="enable_end",
     *     type="integer",
     *     description="有效期结束时间",
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
     *     name="max_time",
     *     type="string",
     *     description="消费时长",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="enable_start",
     *     type="string",
     *     description="适用店铺",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="enable_week",
     *     type="string",
     *     description="适用星期(分别对应1~7）",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="third_party",
     *     type="string",
     *     description="第三方编号",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="all_num",
     *     type="integer",
     *     description="总发放量",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="max_num",
     *     type="integer",
     *     description="最多可购买数量",
     *     required=false,
     *   )
     * )
     */
    public function actionUpdate($id): array
   {

        try {
            $model = $this->findModel($id);
            $data = Yii::$app->request->post();
            if ($data['type'] == 1) {
                if (empty($data['cash'])) {
                    return ResultHelper::json(400, '缺少代金券金额！');
                }
            } elseif ($data['type'] == 4) {
                if (empty($data['discount'])) {
                    return ResultHelper::json(400, '缺少折扣券折扣！');
                }
            } else {
                if (empty($data['max_time'])) {
                    return ResultHelper::json(400, '缺少消费时长！');
                }
            }
            if ($data['type'] == 5) {
                $is_have = TeaCoupon::find()->select('id')
                    ->where(['store_id' =>\Yii::$app->request->input('store_id',0), 'type' => 5])->asArray()->one();
                if ($is_have['id'] && $is_have['id'] != $data['id']) {
                    return ResultHelper::json(400, '已有体验券');
                }
                if (is_array($data['use_hourse'])) {
                    if (count($data['use_hourse']) > 1) {
                        return ResultHelper::json(400, '体验券只可选择单个房间使用');
                    }
                }
            }
            // if (is_array($data['use_hourse'])) {
            //     $data['use_hourse'] = implode(',', array_unique($data['use_hourse']));
            // } else {
            //     $data['use_hourse'] = '';
            // }

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

    /**
     * @SWG\Get(path="/diandi_tea/marketing/coupon/delete",
     *    tags={"营销卡券"},
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
        } catch (StaleObjectException|NotFoundHttpException $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        } catch (\Throwable $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);

        }

        return ResultHelper::json(200, '删除成功');
    }

    /**
     * Finds the TeaCoupon model based on its primary key value.
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
        if (($model = TeaCoupon::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
