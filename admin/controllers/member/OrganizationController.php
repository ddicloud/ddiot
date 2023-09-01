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
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
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
    public function actionIndex(): array
    {
        $searchModel = new MemberOrganizationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProviders = ArrayHelper::objectToarray($dataProvider);
        $parentMent = $dataProviders['allModels'];
        foreach ($parentMent as &$value) {
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
     * Creates a new MemberOrganization model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate(): array
    {
        $model = new MemberOrganization();

        $data = Yii::$app->request->post();

        if ($model->load($data, '') && $model->save()) {
            return ResultHelper::json(200, '创建成功', $model->toArray());
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
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
     */
    public function actionUpdate($id): array
    {
        $model = $this->findModel($id);

            $data = Yii::$app->request->post();

            if ($model->load($data, '') && $model->save()) {
                return ResultHelper::json(200, '编辑成功', $model);
            } else {
                $msg = ErrorsHelper::getModelError($model);

                return ResultHelper::json(400, $msg);
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
     */
    public function actionDelete($id): array
    {
        try {
            $this->findModel($id)->delete();
        } catch (StaleObjectException|NotFoundHttpException $e) {
            return ResultHelper::json(500, $e->getMessage());

        } catch (\Throwable $e) {
            return ResultHelper::json(500, $e->getMessage());

        }

        return ResultHelper::json(200, '删除成功');
    }

    /**
     * Finds the MemberOrganization model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return array|ActiveRecord the loaded model
     *
     */
    protected function findModel($id): array|\yii\db\ActiveRecord
    {
        if (($model = MemberOrganization::findOne($id)) !== null) {
            return $model;
        }

        return ResultHelper::json(500, '请检查数据是否存在');
    }
}
