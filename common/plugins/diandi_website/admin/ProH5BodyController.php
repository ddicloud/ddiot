<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-06 18:39:07
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-07 14:58:15
 */

namespace common\plugins\diandi_website\admin;

use common\plugins\diandi_website\models\searchs\WebsiteProH5Body as WebsiteProH5BodySearch;
use common\plugins\diandi_website\models\WebsiteProH5Body;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * ProH5BodyController implements the CRUD actions for WebsiteProH5Body model.
 */
class ProH5BodyController extends AController
{
    public string $modelSearchName = 'WebsiteProH5BodySearch';

    public $modelClass = '';

    /**
     * @SWG\Get(path="/diandi_website/pro-h5-body/index",
     *    tags={"h5界面展示"},
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
        $searchModel = new WebsiteProH5BodySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @SWG\Get(path="/diandi_website/pro-h5-body/view",
     *    tags={"h5界面展示"},
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
         try {
            $view = $this->findModel($id)->toArray();
        } catch (NotFoundHttpException $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        }

        // $view->image_a = ImageHelper::tomedia($view->image_a);
        // $view->image_b = ImageHelper::tomedia($view->image_b);

        return ResultHelper::json(200, '获取成功', $view);
    }

    /**
     * @SWG\Post(path="/diandi_website/pro-h5-body/create",
     *    tags={"h5界面展示"},
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
     *     name="content",
     *     type="string",
     *     description="内容",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="image_a",
     *     type="string",
     *     description="a图",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="image_b",
     *     type="string",
     *     description="b图",
     *     required=false,
     *   ),
     * )
     */
    public function actionCreate()
    {
        $model = new WebsiteProH5Body();

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
     * @SWG\Post(path="/diandi_website/pro-h5-body/update",
     *    tags={"h5界面展示"},
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
     *     name="content",
     *     type="string",
     *     description="内容",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="image_a",
     *     type="string",
     *     description="a图",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="query",
     *     name="image_b",
     *     type="string",
     *     description="b图",
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
     * @SWG\Get(path="/diandi_website/pro-h5-body/delete",
     *    tags={"h5界面展示"},
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
     * Finds the WebsiteProH5Body model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return WebsiteProH5Body the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WebsiteProH5Body::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
