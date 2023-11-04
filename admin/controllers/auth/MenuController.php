<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-28 16:42:33
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-07-18 17:51:27
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
use yii\db\StaleObjectException;

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

    public string $modelSearchName = 'Menu';

    public int $searchLevel = 0;

    /**
     * Lists all Menu models.
     *
     * @return array
     */
    public function actionIndex(): array
    {
        $searchModel = new MenuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        $DdAddons = new DdAddons();
        $addons = $DdAddons->find()->indexBy('identifie')->select(['title'])->asArray()->column();
        $addons['sys'] = '系统';
        $dataProvider = HelpersArrayHelper::objectToarray($dataProvider);

        $parentMent = $dataProvider['allModels'];

        foreach ($parentMent as &$value) {
            $module_name = !empty($addons[$value['module_name']]) ? $addons[$value['module_name']] : '';
            $value['addons'] = $module_name;
            if ($value['type'] == 1) {
                $value['name'] = $module_name . '-' . $value['name'];
                $value['label'] = $module_name . '-' . $value['name'];
            } else {
                $value['label'] = $value['name'];
            }
        }

        $list = HelpersArrayHelper::itemsMerge($parentMent, 0, 'id', 'parent', 'children');
        if (!empty($parentMent) && empty($list)) {
            $list = $parentMent;
        }

        return ResultHelper::json(200, '获取成功', [
            'list' => $list,
            'addons' => $addons,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Menu model.
     *
     * @param int $id
     *
     * @return array
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
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate(): array
    {
        $model = new Menu();
        $data = Yii::$app->request->post();
        $data['parent'] = Yii::$app->request->post('parent',0);
        $data['order'] = Yii::$app->request->post('order',0);
        $data['is_sys'] = Yii::$app->request->post('is_sys');
        $route_id = Yii::$app->request->post('route_id',0);
        $data['route'] = AuthRoute::find()->where(['id' => $route_id])->select('name')->scalar();

        if ($model->load($data, '') && $model->save()) {
            Helper::invalidate();

            return ResultHelper::json(200, '创建成功', $model->toArray());
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }

    }

    public function actionLevels(): array
    {
        $addons = DdAddons::find()->asArray()->all();
        $parentMent = Menu::find()->where(['is_sys' => 1])->asArray()->all();
        $parentMenu = HelpersArrayHelper::itemsMergeDropDown(HelpersArrayHelper::itemsMerge($parentMent, 0, 'id', 'parent'), 'id', 'name');

        return ResultHelper::json(200, '获取成功', [
            'addons' => $addons,
            'parentMenu' => $parentMenu,
        ]);
    }

    public function actionRoute(): array
   {
        $name =\Yii::$app->request->input('name')??'';
        $module_name =\Yii::$app->request->input('module_name')??'';
        $route_type =\Yii::$app->request->input('route_type')??0;
        $limit =\Yii::$app->request->input('limit')??0;

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
     * @return array
     */
    public function actionUpdate($id): array
   {

        $model = $this->findModel($id);

            $data = Yii::$app->request->post();
            $data['route'] = AuthRoute::find()->where(['id' =>\Yii::$app->request->input('route_id')])->select('name')->scalar();

            if ($model->menuParent) {
                $model->parent_name = $model->menuParent->name;
            }

            if ($model->load($data, '') && $model->save()) {
                Helper::invalidate();

                return ResultHelper::json(200, '更新成功', $model->toArray());
            } else {
                $msg = ErrorsHelper::getModelError($model);

                return ResultHelper::json(400, $msg);
            }

    }

    public function actionUpdateFiles(): array
    {

        $pk = Yii::$app->request->post('pk');
        $id = unserialize(base64_decode($pk));

        $model = $this->findModel($id);

        $files = Yii::$app->request->post('name');
        $value = Yii::$app->request->post('value');
        $Res = $model->updateAll([$files => $value], ['id' => $id]);

        return ResultHelper::json(200, '上传成功',$Res);

    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return array
     */
    public function actionDelete($id): array
    {
        try {
            $this->findModel($id)->delete();
        } catch (StaleObjectException $e) {
            return ResultHelper::json(500, $e->getMessage());

        } catch (\Throwable $e) {
            return ResultHelper::json(500, $e->getMessage());

        }
        Helper::invalidate();

        return ResultHelper::json(200, '删除成功');
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return array|Menu
     */
    protected function findModel($id): array|\yii\db\ActiveRecord
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        } else {
            return ResultHelper::json(500, '请检查数据是否存在');
        }
    }
}
