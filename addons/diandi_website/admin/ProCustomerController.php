<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-06 18:29:55
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-27 16:11:30
 */

namespace addons\diandi_website\admin;

use addons\diandi_website\models\searchs\WebsiteProCustomer as WebsiteProCustomerSearch;
use addons\diandi_website\models\WebsiteProCustomer;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * ProCustomerController implements the CRUD actions for WebsiteProCustomer model.
 */
class ProCustomerController extends AController
{
    public $modelSearchName = 'WebsiteProCustomerSearch';

    public $modelClass = '';

    /**
     * @SWG\Get(path="/diandi_website/pro-customer/index",
     *    tags={"客户案例"},
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
    public function actionIndex()
    {
        $searchModel = new WebsiteProCustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @SWG\Get(path="/diandi_website/pro-customer/view",
     *    tags={"客户案例"},
     *    summary="详情",
     *     @SWG\Response(
     *         response = 200,
     *         description = "详情",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     * )
     */
    public function actionView($id)
    {
        $view = $this->findModel($id);

        return ResultHelper::json(200, '获取成功', $view);
    }

    /**
     * @SWG\Post(path="/diandi_website/pro-customer/create",
     *    tags={"客户案例"},
     *    summary="添加",
     *     @SWG\Response(
     *         response = 200,
     *         description = "添加",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *    @SWG\Parameter(
     *     in="query",
     *     name="title",
     *     type="string",
     *     description="标题",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="image",
     *     type="string",
     *     description="图片",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="content",
     *     type="string",
     *     description="内容",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="link",
     *     type="string",
     *     description="链接地址",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="solution_id",
     *     type="integer",
     *     description="解决方案ID",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="is_website",
     *     type="integer",
     *     description="是否是官网（-1：否，1：是）",
     *     required=false,
     *   ),
     * )
     */
    public function actionCreate()
    {
        $model = new WebsiteProCustomer();

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
     * @SWG\Post(path="/diandi_website/pro-customer/update",
     *    tags={"客户案例"},
     *    summary="更新",
     *     @SWG\Response(
     *         response = 200,
     *         description = "更新",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *    @SWG\Parameter(
     *     in="query",
     *     name="title",
     *     type="string",
     *     description="标题",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="image",
     *     type="string",
     *     description="图片",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="content",
     *     type="string",
     *     description="内容",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="link",
     *     type="string",
     *     description="链接地址",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="solution_id",
     *     type="integer",
     *     description="解决方案ID",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="is_website",
     *     type="integer",
     *     description="是否是官网（-1：否，1：是）",
     *     required=false,
     *   ),
     * )
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
     * @SWG\Get(path="/diandi_website/pro-customer/delete",
     *    tags={"客户案例"},
     *    summary="删除",
     *     @SWG\Response(
     *         response = 200,
     *         description = "删除",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     * )
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return ResultHelper::json(200, '删除成功');
    }

    /**
     * Finds the WebsiteProCustomer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return WebsiteProCustomer the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WebsiteProCustomer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
