<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-03 16:36:46
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-25 17:30:15
 */

namespace admin\controllers\auth;

use admin\controllers\AController;
use admin\models\auth\AuthRoute;
use common\helpers\ArrayHelper as HelpersArrayHelper;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use diandi\addons\models\DdAddons;
use diandi\admin\acmodels\AuthItem as AcmodelsAuthItem;
use diandi\admin\acmodels\AuthItemChild;
use diandi\admin\components\Configs;
use diandi\admin\components\Helper;
use diandi\admin\components\Item;
use diandi\admin\models\AuthItem;
use diandi\admin\models\AuthItemModel;
use diandi\admin\models\searchs\AuthItemSearch;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * PermissionController implements the CRUD actions for AuthItem model.
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 *
 * @since 1.0
 */
class PermissionController extends AController
{
    public $modelClass = 'diandi\admin\models\AuthItem';

    public $enableCsrfValidation = false;

    public $is_sys;

    public $module_name;

    public $parent_type = 0; //0:系统,1模块

    public function actions()
    {
        $this->module_name = Yii::$app->request->get('module_name', 'sys');
        $this->is_sys = $this->module_name == 'sys' ? 1 : 0;
    }

    /**
     * {@inheritdoc}
     */
    public function labels()
    {
        return [
            'Item' => 'Permission',
            'Items' => 'Permissions',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return Item::TYPE_PERMISSION;
    }

    /**
     * Lists all AuthItem models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $authManager = Configs::authManager();
        $where = ['is_sys' => $this->is_sys, 'module_name' => $this->module_name]; //简化权限管理
        $searchModel = new AuthItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        $DdAddons = new DdAddons();
        $addons = [];
        $addons = $DdAddons->find()->indexBy('identifie')->select(['title'])->asArray()->column();
        $addons['sys'] = '系统';
        $dataProvider = HelpersArrayHelper::objectToarray($dataProvider);

        $parentMent = $dataProvider['allModels'];

        foreach ($parentMent as $key => &$value) {
            $value['addons'] = $addons[$value['module_name']];

            if ($value['is_sys'] == 1) {
                $module_name = $addons[$value['module_name']];
                $value['name'] = $module_name.'-'.$value['name'];
            }
        }

        $list = HelpersArrayHelper::itemsMerge($parentMent, 0, 'id', 'parent_id', 'children');

        if (!empty($parentMent) && empty($list)) {
            $list = $parentMent;
        }

        return ResultHelper::json(200, '获取成功', [
            'list' => $list,
            'dataProvider' => $dataProvider,
            'addons' => $addons,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionAddons()
    {
        $DdAddons = new DdAddons();
        $addons = [];
        $addon['sys'] = '系统';

        $addons = $DdAddons->find()->indexBy('identifie')->select(['title'])->asArray()->column();

        return ResultHelper::json(200, '获取成功', array_merge($addon, $addons));
    }

    public function actionLevels()
    {
        global $_GPC;
        $DdAddons = new DdAddons();
        $addons = [];
        $addons = $DdAddons->find()->indexBy('identifie')->select(['title'])->asArray()->column();
        $addons['sys'] = '系统';

        $where = ['permission_type' => 1, 'parent_id' => 0];
        if (isset($_GPC['is_sys'])) {
            $where['is_sys'] = (int) $_GPC['is_sys'];
        }
        // 权限只能是2级，不能是三级
        $parentMent = AuthItemModel::find()->where($where)->select(['id', 'id as value', 'parent_id', 'name as label', 'module_name', 'is_sys'])->asArray()->all();

        foreach ($parentMent as $key => &$value) {
            if ($value['is_sys'] == 1) {
                $module_name = $addons[$value['module_name']];
                $value['label'] = $module_name.'-'.$value['label'];
            }
        }

        $levels = HelpersArrayHelper::itemsMerge($parentMent, 0, 'id', 'parent_id', 'children');

        return ResultHelper::json(200, '获取成功', $levels);
    }

    public function actionRule()
    {
        // 获取所有的权限规则
        $Rules = Configs::authManager()->getRules();

        $Rule = HelpersArrayHelper::objectToarray($Rules);

        foreach ($Rule as $key => $value) {
            $item = [
                'value' => $key,
                'text' => $value['name'],
            ];
            $rulesSelect[] = $item;
        }

        return ResultHelper::json(200, '获取成功', $rulesSelect);
    }

    public function actionRoute()
    {
        $list = AuthRoute::find()->select(['name as label', 'id'])->limit(10)->asArray()->all();

        return ResultHelper::json(200, '获取成功', $list);
    }

    /**
     * Displays a single AuthItem model.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        global $_GPC;
        $permission_type = $_GPC['permission_type'];
        $module_name = $_GPC['module_name'];

        $model = $this->findModel($id);
        $list = $model->getAdminItems($permission_type);
        $assigneds = $availables = [];
        $assigned = $list['assigned'];

        $available = $list['available'];
        foreach ($available as $key => $value) {
            $value = ArrayHelper::toArray($value);
            foreach ($value as $k => &$val) {
                $val['key'] = $val['id'];
                $val['label'] = $val['name'];
                if ($module_name != $val['module_name']) {
                    unset($value[$k]);
                }
            }
            $available[$key] = array_values($value);
            unset($value);
        }

        foreach ($assigned as $key => &$value) {
            $value = ArrayHelper::toArray($value);

            foreach ($value as $k => &$val) {
                $val['key'] = $val['id'];
                $val['label'] = $val['name'];
                $assigneds[$key][] = $val['item_id'];
            }
            $assigned[$key] = array_values($value);
            unset($value);
        }

        foreach ($list['all'] as $key => $value) {
            $value = ArrayHelper::toArray($value);
            foreach ($value as $k => &$val) {
                $val['key'] = $val['id'];
                $val['label'] = $val['name'];
                if ($module_name != $val['module_name']) {
                    unset($value[$k]);
                }
            }
            $all[$key] = array_values($value);
        }

        return ResultHelper::json(200, '获取成功', [
            'all' => $all,
            'assigneds' => $assigned,
            'assignedKey' => $assigneds,
            'availables' => $available,
        ]);
    }

    /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        global $_GPC;

        $model = new AcmodelsAuthItem();

        $module_name = $this->module_name;

        if (Yii::$app->request->isPost) {
            $data = Yii::$app->getRequest()->post();

            if ($model->load($data, '') && $model->save()) {
                return ResultHelper::json(200, '提交成功');
            } else {
                $msg = ErrorsHelper::getModelError($model);

                return ResultHelper::json(400, $msg);
            }
        }

        // $parentMent = AuthItemModel::find()->where(['module_name'=>$module_name])->asArray()->all();
        // $parentItem =  HelpersArrayHelper::itemsMergeDropDown(HelpersArrayHelper::itemsMerge($parentMent,0,"id",'parent_id','-'),"id",'name');

        // $addons = DdAddons::find()->asArray()->all();
    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionUpdateitem()
    {
        global $_GPC;
        $id = $_GPC['id'];
        $model = $this->findModel($id);
        if (yii::$app->request->isPost) {
            $data = yii::$app->request->post();

            if ($model->load($data, '') && $model->save()) {
                return ResultHelper::json(200, '编辑成功');
            } else {
                $msg = ErrorsHelper::getModelError($model);

                return ResultHelper::json(400, $msg);
            }
        }
    }

    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        Configs::authManager()->remove($model->item);
        Helper::invalidate();
        $module_name = $this->module_name;

        return ResultHelper::json(200, '删除成功');
    }

    public function actionChange()
    {
        global $_GPC;
        $id = $_GPC['id'];
        $items = $_GPC['items'];

        if (empty($id)) {
            return ResultHelper::json(400, '参数ID不能为空');
        }

        if (empty($items)) {
            return ResultHelper::json(400, '参数items不能为空');
        }

        $model = $this->findModel($id);

        if (key_exists('route', $items) && !empty($items)) {
            $list = $items['route'];
            $remove_ids = AuthItemChild::find()->where([
                'parent_id' => $id,
                'child_type' => 0,
                ])->andWhere(['not in', 'item_id', $list])->select('item_id')->asArray()->column();
            if (!empty($remove_ids)) {
                $model->removeChildren(['route' => $remove_ids]);
            }

            $have_ids = AuthItemChild::find()->where([
                'parent_id' => $id,
                'child_type' => 0,
                ])->select('item_id')->asArray()->column();

            $add_ids = array_diff($list, $have_ids);

            if (!empty($add_ids)) {
                $model->addChildren(['route' => $add_ids]);
            }

            return ResultHelper::json(200, '操作成功');
        } elseif (key_exists('permission', $items) && !empty($items)) {
            $list = $items['permission'];
            $remove_ids = AuthItemChild::find()->where([
                'parent_id' => $id,
                'child_type' => 1,
                ])->andWhere(['not in', 'item_id', $list])->select('item_id')->asArray()->column();
            if (!empty($remove_ids)) {
                $model->removeChildren(['permission' => $remove_ids]);
            }

            $have_ids = AuthItemChild::find()->where([
                'parent_id' => $id,
                'child_type' => 1,
                ])->select('item_id')->asArray()->column();

            $add_ids = array_diff($list, $have_ids);

            if (!empty($add_ids)) {
                $model->addChildren(['permission' => $add_ids]);
            }

            return ResultHelper::json(200, '操作成功');
        }
    }

    /**
     * Assign items.
     *
     * @param string $id
     *
     * @return array
     */
    public function actionAssign($id)
    {
        $items = Yii::$app->getRequest()->post('items', []);
        $model = $this->findModel($id);
        $success = $model->addChildren($items);
        if (!$success) {
            $msg = ErrorsHelper::getModelError($model);
        }

        return ResultHelper::json(200, '操作成功');

        // return array_merge($model->getItems(), ['success' => $success,'error'=>$msg]);
    }

    /**
     * Assign or remove items.
     *
     * @param string $id
     *
     * @return array
     */
    public function actionRemove($id)
    {
        $items = Yii::$app->getRequest()->post('items', []);
        $model = $this->findModel($id);
        $success = $model->removeChildren($items);

        return ResultHelper::json(200, '移除成功');

        // return array_merge($model->getItems(), ['success' => $success]);
    }

    /**
     * {@inheritdoc}
     */
    public function getViewPath()
    {
        return $this->module->getViewPath().DIRECTORY_SEPARATOR.'item';
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param string $id
     *
     * @return AuthItem the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $auth = Configs::authManager();
        $item = $auth->getPermission($id);

        if ($item) {
            $item->is_sys = 3;

            return new AuthItem($item);
        } else {
            throw new NotFoundHttpException('请检查数据是否存在');
        }
    }
}
