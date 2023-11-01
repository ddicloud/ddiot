<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-06-02 17:20:53
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-07-18 17:30:43
 */

namespace admin\controllers\addons;

use admin\controllers\AController;
use admin\models\addons\models\Bloc as BlocSearch;
use admin\models\enums\BlocStatus;
use admin\models\enums\ReglevelStatus;
use admin\services\StoreService;
use common\helpers\ArrayHelper;
use common\helpers\ErrorsHelper;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use common\models\UserStore;
use diandi\addons\models\Bloc;
use diandi\addons\models\BlocLevel;
use diandi\addons\models\BlocStore;
use diandi\addons\models\UserBloc;
use diandi\admin\models\AuthAssignmentGroup;
use Yii;
use yii\db\StaleObjectException;
use yii\web\NotFoundHttpException;

/**
 * BlocController implements the CRUD actions for Bloc model.
 */
class BlocController extends AController
{
    public string $modelSearchName = 'Bloc';

    public $modelClass = '';

    public array $extras = [];

    /**
     * Lists all Bloc models.
     *
     * @return array
     */
    public function actionIndex(): array
    {
        $searchModel = new BlocSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider = ArrayHelper::objectToarray($dataProvider);

        $parentMent = $dataProvider['allModels'];
        $lists = [];

        if ($parentMent && is_array($parentMent)) {
            $lists = ArrayHelper::itemsMerge($parentMent, 0, 'bloc_id', 'pid', 'children');

            if (empty($lists)) {
                $lists = $parentMent;
            }
        }


        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'list' => $lists,
        ]);
    }

    public function actionStoreGroup(): array
    {
        // 校验数据权限
        $user_id = Yii::$app->user->id;
        $group = AuthAssignmentGroup::find()->where(['user_id' => $user_id])->select('item_name')->column();
        $where = [];
        $lists = [];
        $defaultRoles = Yii::$app->authManager->defaultRoles;
        // 确定我的权限角色与系统默认有交集，name就显示所有集团
        if (!array_intersect($defaultRoles, $group)) {
            // 查找自己的数据
            $store_ids = UserStore::find()->where(['user_id' => $user_id])->select('store_id')->column();
            $where['s.store_id'] = $store_ids;
        }

        $list = Bloc::find()->alias('b')->joinWith('store as s')->filterWhere($where)->asArray()->all();

        foreach ($list as $key => &$value) {
            $value['label'] = $value['business_name'];
            $value['id'] = $value['bloc_id'];
            $store = $value['store'];
            if (!empty($value['store'])) {
                foreach ($store as &$val) {
                    $val['label'] = $val['name'];
                    $val['id'] = $val['store_id'];
                }
                $value['children'] = $store;
                $lists[] = $value;
            } else {
                unset($list[$key]);
            }
        }

        return ResultHelper::json(200, '获取成功', [
            'list' => $lists,
        ]);
    }

    public function actionStoreList(): array
    {
        $user_id = Yii::$app->user->id;
        $group = AuthAssignmentGroup::find()->where(['user_id' => $user_id])->select('item_name')->column();
        $where = [];
        // 确定我的权限角色与系统默认有交集，name就显示所有集团
        if (!in_array(['总管理员'], $group)) {
            // 查找自己的数据
            $store_ids = UserStore::find()->where(['user_id' => $user_id])->select('store_id')->column();
            $where['store_id'] = $store_ids;
        }

        $stores = BlocStore::find()->where($where)->with(['bloc', 'addons'])->asArray()->all();
        foreach ($stores as &$value) {
            $value['create_time'] = date('Y-m-d', $value['create_time'] ?? time());
            $value['identifie'] = $value['addons'] ? $value['addons']['identifie'] : '';
            $value['logo'] = ImageHelper::tomedia($value['logo']);
            // if (empty($value['addons'])) {
            //     unset($stores[$key]);
            // }
        }

        return ResultHelper::json(200, '获取成功', array_values($stores));
    }

    /**
     * Displays a single Bloc model.
     *
     * @param int $id
     *
     * @return array
     *
     */
    public function actionView($id): array
    {
        $view = Bloc::find()->where(['bloc_id' => $id])->asArray()->one();
        if ($view){
            $view['extra'] = !empty($view['extra']) ? unserialize($view['extra']) : $view['extra'];

            $view['provinceCityDistrict'] = [
                (int) $view['province'],
                (int) $view['city'],
                (int) $view['district'],
            ];

            $view['address'] = [
                'address' => $view['address'],
                'lng' => $view['longitude'],
                'lat' => $view['latitude'],
            ];


            return ResultHelper::json(200, '获取成功', $view);
        }else{
            return ResultHelper::json(400, '请重新授权，公司数据不存在');

        }

    }

    /**
     * Creates a new Bloc model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionCreate(): array
    {

        $model = new Bloc();

        $data = Yii::$app->request->post();

        $data['province'] = $data['provinceCityDistrict']['0'];
        $data['city'] = $data['provinceCityDistrict']['1'];
        $data['district'] = $data['provinceCityDistrict']['2'];


        if ($model->load($data, '') && $model->save()) {
            return ResultHelper::json(200, '创建成功', $model->toArray());
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }

    }

    /**
     * Updates an existing Bloc model.
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

        $data['province'] = $data['provinceCityDistrict']['0'];
        $data['city'] = $data['provinceCityDistrict']['1'];
        $data['district'] = $data['provinceCityDistrict']['2'];

        if ($model->load($data, '') && $model->save()) {
            return ResultHelper::json(200, '编辑成功', $model->toArray());
        } else {
            $msg = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $msg);
        }

    }

    /**
     * Deletes an existing Bloc model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     * @throws StaleObjectException|\Throwable
     */
    public function actionDelete($id): array
    {
        $this->findModel($id)->delete();

        return ResultHelper::json(200, '删除成功');
    }

    /**
     * Finds the Bloc model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return array|Bloc
     *
     */
    protected function findModel($id): array|\yii\db\ActiveRecord
    {
        if (($model = Bloc::findOne($id)) !== null) {

            return $model;

        }
        return ResultHelper::json(500, '请检查数据是否存在');
    }

    /**
     * Creates a new Bloc model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionParentbloc(): array
    {
        $model = new Bloc([
            'extras' => $this->extras,
        ]);

        $parents = $model->find()->select(['bloc_id', 'pid', 'business_name as label', 'bloc_id as id'])->asArray()->all();

        $parentBloc = ArrayHelper::itemsMerge($parents, 0, 'bloc_id', 'pid', 'children');

        return ResultHelper::json(200, '获取成功', $parentBloc);
    }

    /**
     * Creates a new Bloc model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     */
    public function actionChildbloc(): array
    {
        global $_GPC;

        $model = new Bloc([
            'extras' => $this->extras,
        ]);

        $where = [];

        $where['pid'] = Yii::$app->params['bloc_id'];

        if (!empty(Yii::$app->request->input('level_num'))) {
            $where['level_num'] = Yii::$app->request->input('level_num');
        }

        $childs = $model->find()->where($where)->select(['bloc_id', 'pid', 'business_name as label', 'bloc_id as id'])->asArray()->all();

        return ResultHelper::json(200, '获取成功', $childs);
    }

    /**
     * Updates an existing Bloc model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return array
     *
     */
    public function actionStores(int $id): array
    {
        $stores = BlocStore::find()->where(['bloc_id' => $id])->asArray()->all();

        return ResultHelper::json(200, '获取成功', $stores);
    }

    public function actionReglevel(): array
    {
        $list = ReglevelStatus::listData();

        $lists = [];

        foreach ($list as $key => $value) {
            $lists[] = [
                'text' => $value,
                'value' => $key,
            ];
        }

        return ResultHelper::json(200, '获取成功', $lists);
    }

    public function actionBlocstatus(): array
    {
        $list = BlocStatus::listData();

        $lists = [];

        foreach ($list as $key => $value) {
            $lists[] = [
                'text' => $value,
                'value' => $key,
            ];
        }

        return ResultHelper::json(200, '获取成功', $lists);
    }

    public function actionLevels(): array
    {

        $levels = BlocLevel::find()->select(['level_num as value', 'name as text'])->asArray()->all();

        return ResultHelper::json(200, '获取成功', $levels);
    }

    public function actionBlocStore(): array
    {
        $list = StoreService::getStoresAndBloc();

        return ResultHelper::json(200, '获取成功', $list);
    }
}
