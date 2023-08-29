<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-27 09:43:08
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-27 18:23:20
 */


namespace addons\diandi_website\admin;

use Yii;
use addons\diandi_website\models\SolutionCate;
use addons\diandi_website\models\searchs\SolutionCateSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\BaseController;
use admin\controllers\AController;
use common\helpers\ResultHelper;
use common\helpers\ErrorsHelper;


/**
 * SolutioncateController implements the CRUD actions for SolutionCate model.
 */
class SolutioncateController extends AController
{
    public string $modelSearchName = "SolutionCateSearch";

    public $modelClass = '';


    /**
     * @SWG\Get(path="/diandi_website/solutioncate/index",
     *    tags={"解决方案分类 - 202206"},
     *    summary="列表",
     *     @SWG\Response(
     *         response = 200,
     *         description = "解决方案分类列表",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     * )
     */
    public function actionIndex()
    {
        $searchModel = new SolutionCateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @SWG\Get(path="/diandi_website/solutioncate/view/{id}",
     *    tags={"解决方案分类 - 202206"},
     *    summary="详情",
     *     @SWG\Response(
     *         response = 200,
     *         description = "解决方案分类详情",
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
     * @SWG\Post(path="/diandi_website/solutioncate/create",
     *    tags={"解决方案分类 - 202206"},
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
     *     name="name",
     *     type="string",
     *     description="名称",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="des",
     *     type="string",
     *     description="描述",
     *     required=true,
     *   ),
     * )
     */
    public function actionCreate()
    {
        $model = new SolutionCate();

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
     * @SWG\Post(path="/diandi_website/solutioncate/update/{id}",
     *    tags={"解决方案分类 - 202206"},
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
     *     name="name",
     *     type="string",
     *     description="名称",
     *     required=true,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="des",
     *     type="string",
     *     description="描述",
     *     required=true,
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
     * @SWG\Delete(path="/diandi_website/solutioncate/delete/{id}",
     *    tags={"解决方案分类 - 202206"},
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
     * Finds the SolutionCate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SolutionCate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SolutionCate::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
