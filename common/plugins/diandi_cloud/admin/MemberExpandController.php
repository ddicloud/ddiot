<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-10-18 17:50:15
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 17:03:28
 */

namespace common\plugins\diandi_cloud\admin;

use common\plugins\diandi_cloud\models\enums\MemberAudit;
use common\plugins\diandi_cloud\models\enums\MemberCertStatus;
use common\plugins\diandi_cloud\models\MemberExpand;
use common\plugins\diandi_cloud\models\searchs\MemberExpandSearch;
use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * MemberExpandController implements the CRUD actions for MemberExpand model.
 */
class MemberExpandController extends AController
{
    public string $modelSearchName = 'MemberExpandSearch';

    public $modelClass = '';

    /**
     * Lists all MemberExpand models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MemberExpandSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MemberExpand model.
     *
     * @param int $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $view = $this->findArray($id);

        return ResultHelper::json(200, '获取成功', $view);
    }

    /**
     * Creates a new MemberExpand model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MemberExpand();

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
     * Updates an existing MemberExpand model.
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
     * Deletes an existing MemberExpand model.
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
     * Finds the MemberExpand model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return MemberExpand the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findArray($id)
    {
        if (($model = MemberExpand::find()->where(['member_id' => $id])->with(['member'])->asArray()->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Finds the MemberExpand model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return MemberExpand the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MemberExpand::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionAudit($id)
    {
        $model = $this->findModel($id);
        if ($model->audit == MemberAudit::WAIT) {
            switch (Yii::$app->request->post('audit')) {
                case MemberAudit::PASS:
                    $model->audit = MemberAudit::PASS;
                    $model->cert_type = $model->audit_type;
                    $model->cert_status = MemberCertStatus::VALID;
                    break;

                case MemberAudit::OVERRULE:
                    $model->audit = MemberAudit::OVERRULE;
                    $model->audit_opinion = Yii::$app->request->post('audit_opinion');
                    break;

                default:
                    return ResultHelper::json(400, '无效的审核状态', []);
                    break;
            }
            if ($model->save(false)) {
                return ResultHelper::json(200, '审核成功！', $model);
            } else {
                return ResultHelper::json(400, current($model->getFirstErrors()), $model->getErrors());
            }
        } else {
            return ResultHelper::json(400, '错误的待审核信息！', []);
        }
    }
}
