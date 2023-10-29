<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-07-18 09:49:34
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-08 16:47:49
 */

namespace common\plugins\diandi_cloud\admin;

use common\plugins\diandi_cloud\models\CloudAuthUser;
use common\plugins\diandi_cloud\models\searchs\CloudAuthUser as CloudAuthUserSearch;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * AuthUserController implements the CRUD actions for CloudAuthUser model.
 */
class AuthUserController extends AController
{
    public string $modelSearchName = 'CloudAuthUserSearch';

    public $modelClass = '';

    /**
     * @SWG\Get(path="/diandi_cloud/auth-user/index",
     *    tags={"授权用户"},
     *    summary="授权用户列表 - 筛选【CloudAuthUserSearch|MemberSearch[username|mobile]】",
     *    @SWG\Response(response = 200, description = "授权用户列表",),
     * )
     */
    public function actionIndex()
    {
        $searchModel = new CloudAuthUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @SWG\Get(path="/diandi_cloud/auth-user/view/{id}",
     *    tags={"授权用户"},
     *    summary="授权用户详情",
     *    @SWG\Response(response = 200, description = "授权用户",),
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
     * @SWG\Post(path="/diandi_cloud/auth-user/create",
     *    tags={"授权用户"},
     *    summary="创建授权用户",
     *    @SWG\Response(response = 200, description = "创建授权用户"),
     *    @SWG\Parameter(in="formData", name="member_id", type="integer", description="会员ID[dd_member]", required=true),
     *    @SWG\Parameter(in="formData", name="email", type="string", description="邮箱", required=true),
     *    @SWG\Parameter(in="formData", name="mobile", type="string", description="手机号", required=true),
     *    @SWG\Parameter(in="formData", name="username", type="string", description="真实姓名", required=true),
     *    @SWG\Parameter(in="formData", name="status", type="string", description="用户状态【1:正常，2:禁用, 3:欠费】", required=true),
     * )
     */
    public function actionCreate()
    {
        $model = new CloudAuthUser();

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
     * @SWG\Put(path="/diandi_cloud/auth-user/update/{id}",
     *    tags={"授权用户"},
     *    summary="更新授权用户",
     *    @SWG\Response(response = 200, description = "更新授权用户"),
     *    @SWG\Parameter(in="formData", name="member_id", type="integer", description="会员ID[dd_member] - 不可编辑", required=false),
     *    @SWG\Parameter(in="formData", name="email", type="string", description="邮箱", required=true),
     *    @SWG\Parameter(in="formData", name="mobile", type="string", description="手机号", required=true),
     *    @SWG\Parameter(in="formData", name="username", type="string", description="真实姓名", required=true),
     *    @SWG\Parameter(in="formData", name="status", type="string", description="用户状态【1:正常，2:禁用, 3:欠费】", required=true),
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
     * @SWG\Delete(path="/diandi_cloud/auth-user/delete/{id}",
     *    tags={"授权用户"},
     *    summary="删除授权用户",
     *    @SWG\Response(response = 200, description = "删除授权用户"),
     * )
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return ResultHelper::json(200, '删除成功');
    }

    /**
     * Finds the CloudAuthUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return CloudAuthUser the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = CloudAuthUser::find()->andWhere(['id' => $id])->with('member')->asArray()->one();
        if ($model !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
