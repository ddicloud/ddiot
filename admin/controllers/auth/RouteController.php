<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-05-17 15:15:38
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 16:46:45
 */

namespace admin\controllers\auth;

use admin\controllers\AController;
use admin\models\auth\AuthRoute;
use admin\models\searchs\auth\AuthRoute as AuthRouteSearch;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use diandi\admin\acmodels\AuthItem;
use diandi\admin\models\Route;
use Yii;
use yii\db\StaleObjectException;

/**
 * RouteController implements the CRUD actions for AuthRoute model.
 */
class RouteController extends AController
{
    public $modelClass = 'admin\models\searchs\auth\AuthRoute';

    public string $modelSearchName = 'AuthRouteSearch';

    protected array $signOptional = ['refresh'];

    public int $searchLevel = 0;

    /**
     * Lists all AuthRoute models.
     *
     * @return array
     */
    public function actionIndex(): array
    {
        $searchModel = new AuthRouteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAvailable(): array
    {
        $model = new Route();
        $list = $model->getRoutes();

        $available = $list['available'];

        return ResultHelper::json(200, '获取成功', $available);
    }

    /**
     * Displays a single AuthRoute model.
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

        return ResultHelper::json(200, '获取成功', (array)$view);
    }

    /**
     * Creates a new AuthRoute model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate(): array
    {

        $model = new AuthRoute();

        $data = Yii::$app->request->post();
        $module_name = Yii::$app->request->input('module_name', 'sys');

        $data['is_sys'] = $module_name == 'sys' ? 1 : 0;
        if ($model->load($data, '') && $model->save()) {
            // 给item同步添加数据
            $AcmodelsAuthItem = new AuthItem();
            $items = [
                'permission_type' => 0,
                'name' => $model->name,
                'is_sys' => $model->is_sys,
                'parent_id' => 0,
                'permission_level' => 0,
                'module_name' => $model->module_name,
            ];
            if ($AcmodelsAuthItem->load($items, '') && $AcmodelsAuthItem->save()) {
                $model->updateAll([
                    'item_id' => $AcmodelsAuthItem->id,
                ], [
                    'id' => $model->id,
                ]);

                return ResultHelper::json(200, '创建成功', $model->toArray());
            } else {
                $msg = ErrorsHelper::getModelError($model);

                return ResultHelper::json(400, $msg);
            }
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }

    }

    /**
     * Updates an existing AuthRoute model.
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

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            $AcmodelsAuthItem = new AuthItem();
            $items = [
                'permission_type' => 0,
                'name' => $model->name,
                'is_sys' => $model->is_sys,
                'permission_level' => 0,
                'module_name' => $model->module_name,
            ];
            $AcmodelsAuthItem->updateAll($items, [
                'id' => $model->item_id,
            ]);

            return ResultHelper::json(200, '编辑成功', $model->toArray());
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }

    }

    /**
     * Deletes an existing AuthRoute model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionDelete($id): array
    {
        $this->findModel($id)->delete();

        return ResultHelper::json(200, '删除成功');
    }

    /**
     * Assign routes.
     *
     * @return array
     */
    public function actionAssign(): array
    {
        $routes = \Yii::$app->request->input('routes');
        $model = new Route();
        $Res = $model->addNew($routes);

        return ResultHelper::json(200, '添加成功', ['list' => $model->getRoutes(), 'Res' => $Res]);
    }

    /**
     * Remove routes.
     *
     * @return array
     */
    public function actionRemove(): array
    {
        $routes = Yii::$app->getRequest()->post('routes', []);
        $model = new Route();
        $model->remove($routes);

        return ResultHelper::json(200, '删除成功', ['list' => $model->getRoutes()]);
    }

    /**
     * Refresh cache.
     *
     * @return array
     */
    public function actionRefresh(): array
    {
        $model = new Route();
        $model->invalidate();
        $list = $model->getRoutes();

        $assigned = $list['assigned'];
        $available = $list['available'];
        $availables = array_merge($assigned, $available);
        $assigneds = [];
        foreach ($assigned as $value) {
            $assigneds[] = array_search($value, $availables);
        }

        return ResultHelper::json(200, '刷新成功', [
            'assigneds' => $assigneds,
            'availables' => $availables,
        ]);
    }

    /**
     * Finds the AuthRoute model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return AuthRoute|array
     *
     */
    protected function findModel($id): array|\yii\db\ActiveRecord
    {
        if (($model = AuthRoute::findOne(['id' => $id])) !== null) {
            return $model;
        }

        return ResultHelper::json(500, '请检查数据是否存在');
    }
}
