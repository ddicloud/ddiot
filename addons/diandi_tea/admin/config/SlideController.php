<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-25 15:15:13
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-24 11:09:18
 */

namespace addons\diandi_tea\admin\config;

use addons\diandi_tea\models\config\TeaSlide;
use addons\diandi_tea\models\searchs\config\TeaSlide as TeaSlideSearch;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

/**
 * SlideController implements the CRUD actions for TeaSlide model.
 */
class SlideController extends AController
{
    public string $modelSearchName = 'TeaSlide';

    public $modelClass = '';

    /**
     * @SWG\Get(path="/diandi_tea/config/slide/index",
     *    tags={"幻灯片"},
     *    summary="列表数据",
     *     @SWG\Response(
     *         response = 200,
     *         description = "列表数据",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     * )
     */
    public function actionIndex(): array
    {
        $searchModel = new TeaSlideSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @SWG\Get(path="/diandi_tea/config/slide/view",
     *    tags={"幻灯片"},
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
    public function actionView($id): array
    {
         try {
            $view = $this->findModel($id)->toArray();
        } catch (NotFoundHttpException $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        }

        return ResultHelper::json(200, '获取成功', $view);
    }

    /**
     * @SWG\Post(path="/diandi_tea/config/slide/create",
     *    tags={"幻灯片"},
     *    summary="创建",
     *     @SWG\Response(
     *         response = 200,
     *         description = "创建",
     *     ),
     *     @SWG\Parameter(ref="#/parameters/access-token"),
     *     @SWG\Parameter(ref="#/parameters/bloc-id"),
     *     @SWG\Parameter(ref="#/parameters/store-id"),
     *    @SWG\Parameter(
     *     in="query",
     *     name="slide",
     *     type="string",
     *     description="幻灯片",
     *     required=false,
     *   ),
     * )
     */
    public function actionCreate(): array
    {
        $model = new TeaSlide();

        $data = Yii::$app->request->post();

        if ($model->load($data, '') && $model->save()) {
            return ResultHelper::json(200, '创建成功', $model->toArray());
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }
    }

    /**
     * @SWG\Post(path="/diandi_tea/config/slide/update",
     *    tags={"幻灯片"},
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
     *     name="slide",
     *     type="string",
     *     description="幻灯片",
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
     * @SWG\Get(path="/diandi_tea/config/slide/delete",
     *    tags={"幻灯片"},
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
     * Finds the TeaSlide model based on its primary key value.
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
        if (($model = TeaSlide::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
