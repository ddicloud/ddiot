<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-07-18 09:49:34
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-02 09:37:33
 */

namespace common\plugins\diandi_cloud\admin;

use common\plugins\diandi_cloud\models\CloudAuthAddons;
use common\plugins\diandi_cloud\models\searchs\CloudAuthAddons as CloudAuthAddonsSearch;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

/**
 * AuthAddonsController implements the CRUD actions for CloudAuthAddons model.
 */
class AuthAddonsController extends AController
{
    public string $modelSearchName = 'CloudAuthAddonsSearch';

    public $modelClass = '';

    /**
     * @SWG\Get(path="/diandi_cloud/auth-addons/index",
     *    tags={"授权应用"},
     *    summary="授权应用列表 - 筛选【CloudAuthAddonsSearch|MemberSearch[username|mobile]】",
     *    @SWG\Response(response = 200, description = "授权应用列表",),
     * )
     */
    public function actionIndex(): array
    {
        $searchModel = new CloudAuthAddonsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @SWG\Get(path="/diandi_cloud/auth-addons/view/{id}",
     *    tags={"授权应用"},
     *    summary="授权应用详情",
     *    @SWG\Response(response = 200, description = "授权应用",),
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
     * @SWG\Post(path="/diandi_cloud/auth-addons/create",
     *    tags={"授权应用"},
     *    summary="创建授权应用",
     *    @SWG\Response(response = 200, description = "创建授权应用"),
     *    @SWG\Parameter(in="formData", name="member_id", type="integer", description="会员ID[dd_member]", required=true),
     *    @SWG\Parameter(in="formData", name="addons", type="string", description="授权模块", required=true),
     *    @SWG\Parameter(in="formData", name="start_time", type="string", description="开始时间[yyyy-MM-dd HH:mm:ss]", required=true),
     *    @SWG\Parameter(in="formData", name="end_time", type="string", description="结束时间[yyyy-MM-dd HH:mm:ss]", required=true),
     *    @SWG\Parameter(in="formData", name="domin_url", type="string", description="域名【Http://test.com】", required=true),
     * )
     */
    public function actionCreate(): array
    {
        $model = new CloudAuthAddons();

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
     * @SWG\Put(path="/diandi_cloud/auth-addons/update/{id}",
     *    tags={"授权应用"},
     *    summary="更新授权应用",
     *    @SWG\Response(response = 200, description = "更新授权应用"),
     *    @SWG\Parameter(in="formData", name="member_id", type="integer", description="会员ID[dd_member]", required=true),
     *    @SWG\Parameter(in="formData", name="addons", type="string", description="授权模块", required=true),
     *    @SWG\Parameter(in="formData", name="start_time", type="string", description="开始时间[yyyy-MM-dd HH:mm:ss]", required=true),
     *    @SWG\Parameter(in="formData", name="end_time", type="string", description="结束时间[yyyy-MM-dd HH:mm:ss]", required=true),
     *    @SWG\Parameter(in="formData", name="domin_url", type="string", description="域名【Http://test.com】", required=true),
     * )
     */
    public function actionUpdate($id): array
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPut) {
            $data = Yii::$app->request->post();
            if (isset($data['member_id'])) {
                unset($data['member_id']);
            }
            if ($model->load($data, '') && $model->save()) {
                return ResultHelper::json(200, '编辑成功', $model);
            } else {
                $msg = ErrorsHelper::getModelError($model);

                return ResultHelper::json(400, $msg);
            }
        }
    }

    /**
     * @SWG\Delete(path="/diandi_cloud/auth-addons/delete/{id}",
     *    tags={"授权应用"},
     *    summary="删除授权应用",
     *    @SWG\Response(response = 200, description = "删除授权应用"),
     * )
     */
    public function actionDelete($id): array
    {
        try {
            $this->findModel($id)->delete();
            return ResultHelper::json(200, '删除成功');

        } catch (StaleObjectException|NotFoundHttpException $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        } catch (\Throwable $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);

        }

    }

    /**
     * Finds the CloudAuthAddons model based on its primary key value.
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
        $model = CloudAuthAddons::find()->andWhere(['id' => $id])->with('member')->asArray()->one();
        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
