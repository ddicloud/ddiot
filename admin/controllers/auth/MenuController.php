<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-28 16:42:33
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-10-27 17:29:30
 */

namespace admin\controllers\auth;

use admin\controllers\AController;
use admin\models\auth\AuthRoute;
use common\helpers\ArrayHelper as HelpersArrayHelper;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use diandi\addons\models\searchs\DdAddons;
use diandi\admin\components\Helper;
use diandi\admin\models\Menu;
use diandi\admin\models\searchs\Menu as MenuSearch;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * MenuController implements the CRUD actions for Menu model.
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 *
 * @since 1.0
 */
class MenuController extends AController
{
    public $modelClass = '';

    public $modelSearchName = 'Menu';

    /**
     * Lists all Menu models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        $DdAddons = new DdAddons();
        $addons = [];
        $addons = $DdAddons->find()->indexBy('identifie')->select(['title'])->asArray()->column();
        $addons['sys'] = '系统';
        $dataProvider = HelpersArrayHelper::objectToarray($dataProvider);

        $parentMent = $dataProvider['allModels'];

        foreach ($parentMent as $key => &$value) {
            $value['addons'] = $addons[$value['module_name']];
            if ($value['type'] == 1) {
                $module_name = $addons[$value['module_name']];
                $value['name'] = $module_name.'-'.$value['name'];
                $value['label'] = $module_name.'-'.$value['name'];
            } else {
                $value['label'] = $value['name'];
            }
        }

        $list = HelpersArrayHelper::itemsMerge($parentMent, 0, 'id', 'parent', 'children');

        return ResultHelper::json(200, '获取成功', [
            'list' => $list,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Menu model.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        $view = $this->findModel($id);

        return ResultHelper::json(200, '获取成功', $view);
    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        global $_GPC;

        $model = new Menu();

        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            $data['parent'] = intval($data['parent']);
            $data['order'] = intval($data['order']);
            $data['is_sys'] = $_GPC['module_name'] == 'sys' || empty($_GPC['module_name']) ? 'system' : 'addons';
            $data['route'] = AuthRoute::find()->where(['id' => $_GPC['route_id']])->select('name')->scalar();

            if ($model->load($data, '') && $model->save()) {
                Helper::invalidate();

                return ResultHelper::json(200, '创建成功', $model);
            } else {
                $msg = ErrorsHelper::getModelError($model);

                return ResultHelper::json(400, $msg);
            }
        }
    }

    public function actionLevels()
    {
        $addons = DdAddons::find()->asArray()->all();
        $parentMent = Menu::find()->where(['is_sys' => 'system'])->asArray()->all();
        $parentMenu = HelpersArrayHelper::itemsMergeDropDown(HelpersArrayHelper::itemsMerge($parentMent, 0, 'id', 'parent', '-'), 'id', 'name');

        return ResultHelper::json(200, '获取成功', [
            'addons' => $addons,
            'parentMenu' => $parentMenu,
        ]);
    }

    public function actionRoute()
    {
        global $_GPC;
        $name = $_GPC['name'];
        $module_name = $_GPC['module_name'];
        $route_type = $_GPC['route_type'];
        $limit = $_GPC['limit'];

        $where = [];
        if (!empty($name)) {
            $li = explode('/', $name);
            $likeName = str_replace(end($li), '', $name);
            $where = ['like', 'name', $likeName];
        }

        if (!empty($module_name)) {
            $where['module_name'] = $module_name;
        }

        if (!empty($route_type)) {
            $where['route_type'] = $route_type;
        }

        $query = AuthRoute::find()->where($where)->orderBy('name')->select(['name as label', 'id', 'name', 'pid']);

        if (!empty($limit)) {
            $query->limit($limit);
        }

        $lists = $query->asArray()->all();

        // $lists = HelpersArrayHelper::itemsMerge($list, 0, "id", 'pid', 'childen');

        return ResultHelper::json(200, '获取成功', $lists);
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        global $_GPC;

        $model = $this->findModel($id);

        if (Yii::$app->request->isPut) {
            $data = Yii::$app->request->post();
            $data['route'] = AuthRoute::find()->where(['id' => $_GPC['route_id']])->select('name')->scalar();

            if ($model->menuParent) {
                $model->parent_name = $model->menuParent->name;
            }

            if ($model->load($data, '') && $model->save()) {
                Helper::invalidate();

                return ResultHelper::json(200, '更新成功', $model);
            } else {
                $msg = ErrorsHelper::getModelError($model);

                return ResultHelper::json(400, $msg);
            }
        }
    }

    public function actionUpdateFiles()
    {
        if (Yii::$app->request->isPost) {
            $pk = Yii::$app->request->post('pk');
            $id = unserialize(base64_decode($pk));

            $model = $this->findModel($id);

            $files = Yii::$app->request->post('name');
            $value = Yii::$app->request->post('value');
            $Res = $model->updateAll([$files => $value], ['id' => $id]);

            return true;
        }
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Helper::invalidate();

        return ResultHelper::json(200, '删除成功');
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return Menu the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('请检查数据是否存在');
        }
    }
}
