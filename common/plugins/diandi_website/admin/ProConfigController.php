<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-06 15:07:41
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-07 14:22:38
 */

namespace common\plugins\diandi_website\admin;

use common\plugins\diandi_website\models\searchs\WebsiteProConfig as WebsiteProConfigSearch;
use common\plugins\diandi_website\models\WebsiteProConfig;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * ProConfigController implements the CRUD actions for WebsiteProConfig model.
 */
class ProConfigController extends AController
{
    public string $modelSearchName = 'WebsiteProConfigSearch';

    public $modelClass = '';

    public function actionIndex()
    {
        $searchModel = new WebsiteProConfigSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @SWG\Get(path="/diandi_website/pro-config/view",
     *    tags={"产品全局配置"},
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

        $where['store_id'] =\Yii::$app->request->input('store_id',0);
        $view = WebsiteProConfig::find()->where(['store_id' =>\Yii::$app->request->input('store_id',0)])->asArray()->one();
        // if ($view) {
        //     $view['image_a'] = ImageHelper::tomedia($view['image_a']);
        //     $view['image_b'] = ImageHelper::tomedia($view['image_b']);
        //     $view['image_c'] = ImageHelper::tomedia($view['image_c']);
        //     $view['image_d'] = ImageHelper::tomedia($view['image_d']);
        // }

        return ResultHelper::json(200, '获取成功', $view);
    }

    /**
     * @SWG\Post(path="/diandi_website/pro-config/create",
     *    tags={"产品全局配置"},
     *    summary="添加/编辑",
     *     @SWG\Response(
     *         response = 200,
     *         description = "添加/编辑",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="image_a",
     *     type="string",
     *     description="公众号演示二维码",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="image_b",
     *     type="string",
     *     description="商城二维码",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="image_c",
     *     type="string",
     *     description="官方公众号二维码",
     *     required=false,
     *   ),
     *    @SWG\Parameter(
     *     in="formData",
     *     name="image_d",
     *     type="string",
     *     description="官方商城二维码",
     *     required=false,
     *   ),
     * )
     */
    public function actionCreate()
   {

        $data = Yii::$app->request->post();
        $website_model = new WebsiteProConfig();
        $where['store_id'] =\Yii::$app->request->input('store_id',0);
        $is_add = $website_model->find()->where(['store_id' =>\Yii::$app->request->input('store_id',0)])->asArray()->one();

        if ($is_add) {
            WebsiteProConfig::updateAll($data, ['id' => $is_add['id']]);

            return ResultHelper::json(200, '编辑成功');
        } else {
            if ($website_model->load($data, '') && $website_model->save()) {
                return ResultHelper::json(200, '创建成功', $website_model);
            } else {
                $msg = ErrorsHelper::getModelError($website_model);

                return ResultHelper::json(400, $msg);
            }
        }
    }

    /**
     * Updates an existing WebsiteProConfig model.
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
     * Deletes an existing WebsiteProConfig model.
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
     * Finds the WebsiteProConfig model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return WebsiteProConfig the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WebsiteProConfig::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
