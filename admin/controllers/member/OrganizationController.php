<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-11-13 16:02:53
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-13 17:19:52
 */

namespace admin\controllers\member;

use admin\controllers\AController;
use common\helpers\ArrayHelper;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use common\models\MemberOrganization;
use common\models\searchs\MemberOrganizationSearch;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * OrganizationController implements the CRUD actions for MemberOrganization model.
 */
class OrganizationController extends AController
{
    public string $modelSearchName = 'MemberOrganizationSearch';

    public $modelClass = '';

    /**
     * Lists all MemberOrganization models.
     *
     * @return array
     */
    public function actionIndex()
    {
        $searchModel = new MemberOrganizationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $list = [];
        $dataProviders = ArrayHelper::objectToarray($dataProvider);
        $parentMent = $dataProviders['allModels'];
        foreach ($parentMent as $key => &$value) {
            $value['id'] = $value['group_id'];
            $value['label'] = $value['item_name'];
        }
        $list = ArrayHelper::itemsMerge($parentMent, 0, 'group_id', 'group_pid', 'children');

        return ResultHelper::json(200, '获取成功', [
            'list' => $list,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MemberOrganization model.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $view = $this->findModel($id);

        return ResultHelper::json(200, '获取成功', $view);
    }

    /**
     * Creates a new MemberOrganization model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate()
    {
        $model = new MemberOrganization();

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
     * Updates an existing MemberOrganization model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return array
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
     * Deletes an existing MemberOrganization model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return ResultHelper::json(200, '删除成功');
    }

    /**
     * Finds the MemberOrganization model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return MemberOrganization the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MemberOrganization::findOne($id)) !== null) {
            return ResultHelper::json(200, '获取成功',(array)$model);
        }

        return ResultHelper::json(500, '请检查数据是否存在');
    }
}
