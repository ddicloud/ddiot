<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-07-18 09:49:34
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-08 16:47:31
 */

namespace common\plugins\diandi_cloud\admin;

use common\plugins\diandi_cloud\models\CloudAuthDomain;
use common\plugins\diandi_cloud\models\searchs\CloudAuthDomain as CloudAuthDomainSearch;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * AuthDomainController implements the CRUD actions for CloudAuthDomain model.
 */
class AuthDomainController extends AController
{
    public string $modelSearchName = 'CloudAuthDomainSearch';

    public $modelClass = '';

    /**
     * @SWG\Get(path="/diandi_cloud/auth-domain/index",
     *    tags={"授权域名"},
     *    summary="授权域名列表 - 筛选【CloudAuthDomainSearch|MemberSearch[username|mobile]】",
     *    @SWG\Response(response = 200, description = "授权域名列表",),
     * )
     */
    public function actionIndex()
    {
        $searchModel = new CloudAuthDomainSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @SWG\Get(path="/diandi_cloud/auth-domain/view/{id}",
     *    tags={"授权域名"},
     *    summary="授权域名详情",
     *    @SWG\Response(response = 200, description = "授权域名",),
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
     * @SWG\Post(path="/diandi_cloud/auth-domain/create",
     *    tags={"授权域名"},
     *    summary="创建授权域名",
     *    @SWG\Response(response = 200, description = "创建授权域名"),
     *    @SWG\Parameter(in="formData", name="member_id", type="integer", description="会员ID[dd_member]", required=true),
     *    @SWG\Parameter(in="formData", name="status", type="string", description="域名状态【1:正常，2:禁用, 3:欠费】", required=true),
     *    @SWG\Parameter(in="formData", name="domin_url", type="string", description="域名【Http://test.com】", required=true),
     *    @SWG\Parameter(in="formData", name="start_time", type="string", description="开始时间[yyyy-MM-dd HH:mm:ss]", required=true),
     *    @SWG\Parameter(in="formData", name="end_time", type="string", description="结束时间[yyyy-MM-dd HH:mm:ss]", required=true),
     * )
     */
    public function actionCreate()
    {
        $model = new CloudAuthDomain();

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
     * @SWG\Put(path="/diandi_cloud/auth-domain/update/{id}",
     *    tags={"授权域名"},
     *    summary="更新授权域名",
     *    @SWG\Response(response = 200, description = "更新授权域名"),
     *    @SWG\Parameter(in="formData", name="member_id", type="integer", description="会员ID[dd_member]", required=true),
     *    @SWG\Parameter(in="formData", name="status", type="string", description="域名状态【1:正常，2:禁用, 3:欠费】", required=true),
     *    @SWG\Parameter(in="formData", name="domin_url", type="string", description="域名【Http://test.com】", required=true),
     *    @SWG\Parameter(in="formData", name="start_time", type="string", description="开始时间[yyyy-MM-dd HH:mm:ss]", required=true),
     *    @SWG\Parameter(in="formData", name="end_time", type="string", description="结束时间[yyyy-MM-dd HH:mm:ss]", required=true),
     * )
     */
    public function actionUpdate($id)
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
     * @SWG\Delete(path="/diandi_cloud/auth-domain/delete/{id}",
     *    tags={"授权域名"},
     *    summary="删除授权域名",
     *    @SWG\Response(response = 200, description = "删除授权域名"),
     * )
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return ResultHelper::json(200, '删除成功');
    }

    /**
     * Finds the CloudAuthDomain model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return CloudAuthDomain the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = CloudAuthDomain::find()->andWhere(['id' => $id])->with('member')->asArray()->one();
        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
