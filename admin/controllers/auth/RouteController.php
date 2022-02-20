<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-05-17 15:15:38
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-09 11:39:41
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
use yii\web\NotFoundHttpException;

/**
 * RouteController implements the CRUD actions for AuthRoute model.
 */
class RouteController extends AController
{
    public $modelClass = 'admin\models\searchs\auth\AuthRoute';

    public $modelSearchName = 'AuthRouteSearch';

    protected $signOptional = ['refresh'];

    /**
     * Lists all AuthRoute models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuthRouteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAvailable()
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
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $view = $this->findModel($id);

        return ResultHelper::json(200, '获取成功', $view);
    }

    /**
     * Creates a new AuthRoute model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        global $_GPC;

        $model = new AuthRoute();

        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            $data['is_sys'] = $_GPC['module_name'] == 'sys' || empty($_GPC['module_name']) ? 1 : 0;
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

                    return ResultHelper::json(200, '创建成功', $model);
                } else {
                    $msg = ErrorsHelper::getModelError($model);

                    return ResultHelper::json(400, $msg);
                }
            } else {
                $msg = ErrorsHelper::getModelError($model);

                return ResultHelper::json(400, $msg);
            }
        }
    }

    /**
     * Updates an existing AuthRoute model.
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

                return ResultHelper::json(200, '编辑成功', $model);
            } else {
                $msg = ErrorsHelper::getModelError($model);

                return ResultHelper::json(400, $msg);
            }
        }
    }

    /**
     * Deletes an existing AuthRoute model.
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
     * Assign routes.
     *
     * @return array
     */
    public function actionAssign()
    {
        global $_GPC;
        $routes = $_GPC['routes'];
        $model = new Route();
        $Res = $model->addNew($routes);

        return ResultHelper::json(200, '添加成功', ['list' => $model->getRoutes()]);
    }

    /**
     * Remove routes.
     *
     * @return array
     */
    public function actionRemove()
    {
        $routes = Yii::$app->getRequest()->post('routes', []);
        $model = new Route();
        $model->remove($routes);

        return ResultHelper::json(200, '删除成功', ['list' => $model->getRoutes()]);
    }

    /**
     * Refresh cache.
     *
     * @return type
     */
    public function actionRefresh()
    {
        $model = new Route();
        $model->invalidate();
        $list = $model->getRoutes();

        $assigned = $list['assigned'];
        $available = $list['available'];
        $availables = array_merge($assigned, $available);

        foreach ($assigned as $key => $value) {
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
     * @return AuthRoute the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthRoute::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('请检查数据是否存在');
    }
}
