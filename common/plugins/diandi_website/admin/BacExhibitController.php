<?php

/**
 * 后台展示
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-27 17:36:29
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-27 18:22:04
 */


namespace addons\diandi_website\admin;

use Yii;
use addons\diandi_website\models\BackendExhibit;
use addons\diandi_website\models\searchs\BackendExhibitSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BaseController;
use admin\controllers\AController;
use common\helpers\ResultHelper;
use common\helpers\ErrorsHelper;


/**
 * BacExhibitController implements the CRUD actions for BackendExhibit model.
 */
class BacExhibitController extends AController
{
    public string $modelSearchName = "BackendExhibitSearch";

    public $modelClass = '';

    /**
     * @SWG\Get(path="/diandi_website/bac-exhibit/index",
     *    tags={"后台展示 - 202206"},
     *    summary="列表",
     *     @SWG\Response(
     *         response = 200,
     *         description = "后台展示列表",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     * )
     */
    public function actionIndex()
    {
        $searchModel = new BackendExhibitSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @SWG\Get(path="/diandi_website/bac-exhibit/view/{id}",
     *    tags={"后台展示 - 202206"},
     *    summary="详情",
     *     @SWG\Response(
     *         response = 200,
     *         description = "系统价值详情",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     * )
     */
    public function actionView($id)
    {

         try {
            $view = $this->findModel($id)->toArray();
        } catch (NotFoundHttpException $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        }

        return ResultHelper::json(200, '获取成功', $view);
    }

    /**
     * @SWG\Post(path="/diandi_website/bac-exhibit/create",
     *    tags={"后台展示 - 202206"},
     *    summary="添加",
     *     @SWG\Response(
     *         response = 200,
     *         description = "添加",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="solution_id",
     *     type="integer",
     *     description="解决方案ID",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="title",
     *     type="string",
     *     description="标题",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="subtitle",
     *     type="string",
     *     description="副标题",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="icon",
     *     type="string",
     *     description="ICON",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="image",
     *     type="string",
     *     description="图片",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="link",
     *     type="string",
     *     description="链接",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="content",
     *     type="string",
     *     description="内容",
     *     required=true,
     *   ),
     * )
     */
    public function actionCreate()
    {
        $model = new BackendExhibit();

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
     * @SWG\Post(path="/diandi_website/bac-exhibit/update/{id}",
     *    tags={"后台展示 - 202206"},
     *    summary="更新",
     *     @SWG\Response(
     *         response = 200,
     *         description = "更新",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="solution_id",
     *     type="integer",
     *     description="解决方案ID",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="title",
     *     type="string",
     *     description="标题",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="subtitle",
     *     type="string",
     *     description="副标题",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="icon",
     *     type="string",
     *     description="ICON",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="image",
     *     type="string",
     *     description="图片",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="link",
     *     type="string",
     *     description="链接",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="content",
     *     type="string",
     *     description="内容",
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
     * @SWG\Delete(path="/diandi_website/bac-exhibit/delete/{id}",
     *    tags={"后台展示 - 202206"},
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
     * Finds the BackendExhibit model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BackendExhibit the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BackendExhibit::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
