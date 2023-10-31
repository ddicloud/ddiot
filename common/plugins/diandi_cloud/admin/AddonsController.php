<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-07-07 09:25:04
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-02-20 10:27:41
 */

namespace common\plugins\diandi_cloud\admin;

use common\plugins\diandi_cloud\models\CloudAddons;
use common\plugins\diandi_cloud\models\searchs\CloudAddonsSearch;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use diandi\addons\models\DdAddons;
use Yii;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

class AddonsController extends AController
{
    public string $modelSearchName = 'CloudAddonsSearch';

    public $modelClass = '';

    public function actionList(): array
    {
        $list = DdAddons::find()->asArray()->all();
        return ResultHelper::json(200, '获取成功', $list);
    }

    /**
     * @SWG\Get(path="/diandi_cloud/addons/index",
     *    tags={"应用"},
     *    summary="应用列表",
     *    @SWG\Response(response = 200, description = "应用列表",),
     * )
     */
    public function actionIndex(): array
    {
        $searchModel = new CloudAddonsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @SWG\Get(path="/diandi_cloud/addons/view/{id}",
     *    tags={"应用"},
     *    summary="应用详情",
     *    @SWG\Response(response = 200, description = "应用",),
     * )
     */
    public function actionView($id): array
    {
        if (($model = CloudAddons::find()->andWhere(['id' => $id])->with(['cate', 'ddAddons'])->asArray()->one()) !== null) {
            return ResultHelper::json(200, '获取成功', $model);
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @SWG\Post(path="/diandi_cloud/addons/create",
     *    tags={"应用"},
     *    summary="创建应用",
     *    @SWG\Response(response = 200, description = "创建应用"),
     *    @SWG\Parameter(in="formData", name="is_nav", type="integer", description="是否导航(-1:否, 1:是)", required=true),
     *    @SWG\Parameter(in="formData", name="identifie", type="string", description="英文标识", required=true),
     *    @SWG\Parameter(in="formData", name="type", type="string", description="模块类型", required=true),
     *    @SWG\Parameter(in="formData", name="title", type="string", description="名称", required=true),
     *    @SWG\Parameter(in="formData", name="version", type="string", description="版本", required=true),
     *    @SWG\Parameter(in="formData", name="ability", type="string", description="简介", required=true),
     *    @SWG\Parameter(in="formData", name="description", type="string", description="描述", required=true),
     *    @SWG\Parameter(in="formData", name="author", type="string", description="作者", required=true),
     *    @SWG\Parameter(in="formData", name="url", type="string", description="社区地址", required=true),
     *    @SWG\Parameter(in="formData", name="settings", type="string", description="配置", required=true),
     *    @SWG\Parameter(in="formData", name="logo", type="string", description="logo", required=true),
     *    @SWG\Parameter(in="formData", name="versions", type="string", description="适应的软件版本", required=true),
     *    @SWG\Parameter(in="formData", name="is_install", type="integer", description="是否安装(-1:未安装, 1:已安装)", required=true),
     *    @SWG\Parameter(in="formData", name="parent_mids", type="integer", description="父应用ID", required=true),
     *    @SWG\Parameter(in="formData", name="cate_id", type="integer", description="分类ID", required=true),
     *    @SWG\Parameter(in="formData", name="applets", type="string", description="小程序二维码", required=true),
     * )
     */
    public function actionCreate(): array
    {
        $model = new CloudAddons();

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
     * @SWG\Put(path="/diandi_cloud/addons/update/{id}",
     *    tags={"应用"},
     *    summary="更新应用",
     *    @SWG\Response(response = 200, description = "更新应用"),
     *    @SWG\Parameter(in="formData", name="is_nav", type="integer", description="是否导航(-1:否, 1:是)", required=true),
     *    @SWG\Parameter(in="formData", name="identifie", type="string", description="英文标识", required=true),
     *    @SWG\Parameter(in="formData", name="type", type="string", description="模块类型", required=true),
     *    @SWG\Parameter(in="formData", name="title", type="string", description="名称", required=true),
     *    @SWG\Parameter(in="formData", name="version", type="string", description="版本", required=true),
     *    @SWG\Parameter(in="formData", name="ability", type="string", description="简介", required=true),
     *    @SWG\Parameter(in="formData", name="description", type="string", description="描述", required=true),
     *    @SWG\Parameter(in="formData", name="author", type="string", description="作者", required=true),
     *    @SWG\Parameter(in="formData", name="url", type="string", description="社区地址", required=true),
     *    @SWG\Parameter(in="formData", name="settings", type="string", description="配置", required=true),
     *    @SWG\Parameter(in="formData", name="logo", type="string", description="logo", required=true),
     *    @SWG\Parameter(in="formData", name="versions", type="string", description="适应的软件版本", required=true),
     *    @SWG\Parameter(in="formData", name="is_install", type="integer", description="是否安装(-1:未安装, 1:已安装)", required=true),
     *    @SWG\Parameter(in="formData", name="parent_mids", type="integer", description="父应用ID", required=true),
     *    @SWG\Parameter(in="formData", name="cate_id", type="integer", description="分类ID", required=true),
     *    @SWG\Parameter(in="formData", name="applets", type="string", description="小程序二维码", required=true),
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
     * @SWG\Delete(path="/diandi_cloud/addons/delete/{id}",
     *    tags={"应用"},
     *    summary="删除应用",
     *    @SWG\Response(response = 200, description = "删除应用"),
     * )
     */
    public function actionDelete($id): array
    {
        $this->findModel($id)->delete();

        return ResultHelper::json(200, '删除成功');
    }

    /**
     * Finds the CloudAddons model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return array|ActiveRecord the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): array|ActiveRecord
    {
        if (($model = CloudAddons::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
