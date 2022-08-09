<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-07 08:57:23
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-07 14:58:24
 */

namespace addons\diandi_website\admin;

use addons\diandi_website\models\searchs\WebsiteProH5Top as WebsiteProH5TopSearch;
use addons\diandi_website\models\WebsiteProH5Top;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * ProH5TopController implements the CRUD actions for WebsiteProH5Top model.
 */
class ProH5TopController extends AController
{
    public $modelSearchName = 'WebsiteProH5TopSearch';

    public $modelClass = '';

    /**
     * @SWG\Get(path="/diandi_website/pro-h5-top/index",
     *    tags={"h5前端界面展示"},
     *    summary="列表",
     *     @SWG\Response(
     *         response = 200,
     *         description = "列表",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     * )
     */
    public function actionIndex()
    {
        $searchModel = new WebsiteProH5TopSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @SWG\Get(path="/diandi_website/pro-h5-top/view",
     *    tags={"h5前端界面展示"},
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
        // $view->image = ImageHelper::tomedia($view->image);
        // $view->logo_a = ImageHelper::tomedia($view->logo_a);
        // $view->logo_b = ImageHelper::tomedia($view->logo_b);

        return ResultHelper::json(200, '获取成功', $view);
    }

    /**
     * @SWG\Post(path="/diandi_website/pro-h5-top/create",
     *    tags={"h5前端界面展示"},
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
     *     description="静止图片",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="logo_a",
     *     type="string",
     *     description="静止logo",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="logo_b",
     *     type="string",
     *     description="鼠标悬停logo",
     *     required=false,
     *   ),
     * )
     */
    public function actionCreate()
    {
        $model = new WebsiteProH5Top();

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
     * @SWG\Post(path="/diandi_website/pro-h5-top/update",
     *    tags={"h5前端界面展示"},
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
     *     description="静止图片",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="logo_a",
     *     type="string",
     *     description="静止logo",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="logo_b",
     *     type="string",
     *     description="鼠标悬停logo",
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
     * @SWG\Get(path="/diandi_website/pro-h5-top/delete",
     *    tags={"h5前端界面展示"},
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
     * Finds the WebsiteProH5Top model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return WebsiteProH5Top the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WebsiteProH5Top::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
