<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-07-06 15:33:40
 * @Last Modified by:   Radish <minradish@163.com>
 * @Last Modified time: 2022-10-13 09:29:38
 */

namespace common\plugins\diandi_cloud\admin;

use common\plugins\diandi_cloud\models\CloudAddonsCate;
use common\plugins\diandi_cloud\models\searchs\CloudAddonsCateSearch;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\web\NotFoundHttpException;

class AddonsCateController extends AController
{
    public string $modelSearchName = 'CloudAddonsCateSearch';

    public $modelClass = '';

    /**
     * @SWG\Get(path="/diandi_cloud/addons-cate/index",
     *    tags={"应用分类"},
     *    summary="应用分类列表",
     *     @SWG\Response(
     *         response = 200,
     *         description = "应用分类列表",
     *     ),
     * )
     */
    public function actionIndex(): array
    {
        $searchModel = new CloudAddonsCateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionList(): array
    {
        $searchModel = new CloudAddonsCateSearch();
        $dataProvider = $searchModel->list(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @SWG\Get(path="/diandi_cloud/addons-cate/view/{id}",
     *    tags={"应用分类"},
     *    summary="应用分类详情",
     *     @SWG\Response(
     *         response = 200,
     *         description = "应用分类详情",
     *     ),
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
     * @SWG\Post(path="/diandi_cloud/addons-cate/create",
     *    tags={"应用分类"},
     *    summary="创建应用分类",
     *    @SWG\Response(response = 200, description = "创建应用分类"),
     *    @SWG\Parameter(in="formData", name="name", type="string", description="分类名称", required=true),
     *    @SWG\Parameter(in="formData", name="pid", type="integer", description="父级分类ID", required=true),
     *    @SWG\Parameter(in="formData", name="sort", type="integer", description="排序值", required=true),
     * )
     */
    public function actionCreate(): array
    {
        $model = new CloudAddonsCate();

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
     * @SWG\Put(path="/diandi_cloud/addons-cate/update/{id}",
     *    tags={"应用分类"},
     *    summary="更新应用分类",
     *    @SWG\Response(response = 200, description = "更新应用分类"),
     *    @SWG\Parameter(in="formData", name="name",type="string", description="分类名称", required=true),
     *    @SWG\Parameter(in="formData", name="pid",type="integer", description="父级分类ID", required=true),
     *    @SWG\Parameter(in="formData", name="sort",type="integer", description="排序值", required=true),
     * )
     */
    public function actionUpdate($id): array
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
     * @SWG\Delete(path="/diandi_cloud/addons-cate/delete/{id}",
     *    tags={"应用分类"},
     *    summary="删除应用分类",
     *    @SWG\Response(response = 200, description = "删除应用分类"),
     * )
     */
    public function actionDelete($id): array
    {
        $this->findModel($id)->delete();

        return ResultHelper::json(200, '删除成功');
    }

    /**
     * Finds the CloudAddonsCate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return CloudAddonsCate the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): array|\yii\db\ActiveRecord
    {
        if (($model = CloudAddonsCate::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
