<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-04-27 03:17:29
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-07-18 17:11:06
 */

namespace admin\controllers;

use admin\services\StoreService;
use common\helpers\CacheHelper;
use common\helpers\ErrorsHelper;
use common\helpers\ImageHelper;
use common\helpers\LevelTplHelper;
use common\helpers\ResultHelper;
use common\models\UserBloc;
use diandi\addons\models\Bloc;
use diandi\addons\models\BlocStore;
use diandi\addons\models\searchs\BlocStoreSearch;
use diandi\addons\models\StoreCategory;
use diandi\addons\models\StoreLabel;
use diandi\addons\models\StoreLabelLink;
use diandi\admin\models\AuthAssignmentGroup;
use Yii;
use yii\db\ActiveRecord;
use yii\db\StaleObjectException;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class StoreController extends AController
{
    public $modelClass = '';
    protected array $authOptional = ['*'];

    public int $bloc_id;

    public array $extras = [];

    public int $searchLevel = 0;

    public function actionInfo(): array
    {
        $store_id = Yii::$app->params['store_id'];
        $store = Yii::$app->service->commonGlobalsService->getStoreDetail($store_id);
        if (!$store) {
            return ResultHelper::json(400, '商户或不存在，请检查配置参数', $store);
        }
        $bloc_id = $store['bloc_id'];
        $config = Yii::$app->service->commonGlobalsService->getConf($bloc_id);
        $store['config'] = $config;

        return ResultHelper::json(200, '获取成功', $store);
    }

    public function actionDetailinfo(): array
    {
        global $_GPC;
        $store_id = $_GPC['store_id'];
        $store = Yii::$app->service->commonGlobalsService->getStoreDetail($store_id);

        if (!$store) {
            return ResultHelper::json(400, '商户或不存在，请检查配置参数', $store);
        }

        return ResultHelper::json(200, '获取成功', $store);
    }

    public function actionCate(): array
    {
        global $_GPC;
        $parent_id = $_GPC['parent_id'];

        $list = Yii::$app->service->commonStoreService->getCate($parent_id);

        return ResultHelper::json(200, '获取成功', $list);
    }

    public function actionList(): array
    {
        global $_GPC;

        $category_pid = $_GPC['category_pid'];
        $category_id = $_GPC['category_id'];
        $keywords = $_GPC['keywords'];
        $longitude = $_GPC['longitude'];
        $latitude = $_GPC['latitude'];
        $label_id = intval($_GPC['label_id']);

        $page = $_GPC['page'] ?? 1;
        $pageSize = $_GPC['pageSize'] ?? 10;

        $list = Yii::$app->service->commonStoreService->list($category_pid, $category_id, $longitude, $latitude, $keywords, $label_id, $page, $pageSize);

        return ResultHelper::json(200, '获取成功', $list);
    }

    public function actionDetail()
    {
    }

    public function actionBlocs(): array
    {
        global $_GPC;

        $business_name = $_GPC['business_name'];

        $store_name = $_GPC['store_name'];

        $user_id = Yii::$app->user->id;
        $group = AuthAssignmentGroup::find()->where(['user_id' => $user_id])->asArray()->all();
        $where = [];
        $list = [];
        Yii::$app->params['userBloc'] = [];

        $defaultRoles = Yii::$app->authManager->defaultRoles;

        // 确定我的权限角色与系统默认有交集，name就显示所有集团
        $diff = array_intersect($defaultRoles, array_column($group, 'item_name'));

        if (empty($diff)) {
            if (!empty($user_id)) {
                $where = ['user_id' => $user_id];
            }

            if (!empty($business_name)) {
                $where = ['like', 'c.business_name', $business_name];
            }

            if (!empty($store_name)) {
                $where = ['like', 'c.name', $store_name];
            }

            $UserBloc = new UserBloc();
            $bloc_ids = $UserBloc->find()->alias('a')->where($where)->joinWith('bloc as c')->select(['a.bloc_id'])->limit(5)->asArray()->all();


            foreach ($bloc_ids as $value) {
                $value['bloc']['store'][] = $value['store'];
                $list[$value['bloc_id']] = $value['bloc'];
            }
            Yii::$app->params['userBloc'] = array_values($list);
        } else {
            $Bloc = new Bloc();
            $whereStore = [];
            if (!empty($business_name)) {
                $where = ['like', 'business_name', $business_name];
            }

            if (!empty($store_name)) {
                $whereStore = ['like', 'name', $store_name];
            }

            $list = $Bloc->find()
                ->with(['store' => function ($query) use ($whereStore) {
                    return $query->where($whereStore)->limit(12);
                }])
                ->where($where)
                ->limit(6)
                ->asArray()
                ->all();

            Yii::$app->params['userBloc'] = $list;
        }

        $cacheClass = new CacheHelper();
        $key = '';
        $cacheClass->set($key, $list);

        $blocs = Yii::$app->params['userBloc'];
        foreach ($blocs as &$value) {
            if (!empty($value['store'])) {
                foreach ($value['store'] as &$val) {
                    $val['logo'] = ImageHelper::tomedia($val['logo']);
                }
            }
        }

        return ResultHelper::json(200, '获取成功', $blocs);
    }

    /**
     * Lists all BlocStore models.
     *
     * @return array
     */
    public function actionIndex(): array
    {
        $bloc_id = $this->bloc_id ?? Yii::$app->params['bloc_id'];

        $searchModel = new BlocStoreSearch([
            'bloc_id' => $bloc_id,
        ]);

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return ResultHelper::json(200, '获取成功', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return StoreCategory[]|string
     */
    public function actionChildcate(): array|string
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = Yii::$app->request->post();
        $parent_id = $data['parent_id'];
        return StoreCategory::findAll(['parent_id' => $parent_id]);
    }


    /**
     * Displays a single BlocStore model.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id): array
    {
        $model = $this->findModel($id);
        $model['extra'] = unserialize($model['extra']);

        return ResultHelper::json(200, '获取成功', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new BlocStore model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return array
     * @throws HttpException
     */
    public function actionCreate(): array
    {
        global $_GPC;
        if ($this->module->id == 'addons') {
            // 校验数量限制
            $storeNum = StoreService::checkStoreNum($_GPC['bloc_id']);
            if (!$storeNum) {
                return ResultHelper::json(400, '超过最大商户添加数量');
            }
            $model = new BlocStore([
                'extras' => $this->extras,
            ]);

            $modelcate = new StoreCategory();

            $Helper = new LevelTplHelper([
                'pid' => 'parent_id',
                'cid' => 'category_id',
                'title' => 'name',
                'model' => $modelcate,
                'id' => 'category_id',
            ]);
            $link = new StoreLabelLink();

            if (Yii::$app->request->isPost) {
                $data = Yii::$app->request->post();
                // $data['BlocStore']['lng_lat'] = implode(',',$data['BlocStore']['lng_lat']);
                if ($model->load($data) && $model->save()) {
                    $StoreLabelLink = $_GPC['StoreLabelLink'];

                    if (!empty($StoreLabelLink['label_id'])) {
                        foreach ($StoreLabelLink['label_id'] as $label_id) {
                            $_link = clone  $link;
                            $bloc_id = $model->bloc_id;
                            $store_id = $model->store_id;
                            $data = [
                                'bloc_id' => $bloc_id,
                                'store_id' => $store_id,
                                'label_id' => $label_id,
                            ];
                            $_link->setAttributes($data);
                            $_link->save();
                        }
                    }

                    return ResultHelper::json(200, '获取成功',[ 'id' => $model->store_id, 'bloc_id' => $model->bloc_id]);
                } else {
                    $msg = ErrorsHelper::getModelError($model);
                    throw new HttpException(400, $msg);
                }
            }

            $labels = StoreLabel::find()->select(['id', 'name'])->indexBy(
                'id'
            )->asArray()->all();

            $linkValue = [];

            return ResultHelper::json(200, '获取成功', [
                'link' => $link,
                'linkValue' => $linkValue,
                'labels' => $labels,
                'model' => $model,
                'Helper' => $Helper,
                'bloc_id' => $this->bloc_id,
            ]);
        } else {
            throw new HttpException('400', '请在公司管理中添加商户');
        }
    }

    /**
     * Updates an existing BlocStore model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id): array
    {
        global $_GPC;

        $model = $this->findModel($id);
        $model['extra'] = unserialize($model['extra']);
        $link = new StoreLabelLink();

        $bloc_id = $model->bloc_id;
        $store_id = $model->store_id;

        if ($model->load(Yii::$app->request->post(), '') && $model->save()) {
            $StoreLabelLink = $_GPC['StoreLabelLink'];
            $link->deleteAll([
                'store_id' => $store_id,
            ]);

            if (!empty($StoreLabelLink['label_id'])) {
                foreach ($StoreLabelLink['label_id'] as $label_id) {
                    $_link = clone  $link;
                    $data = [
                        'bloc_id' => $bloc_id,
                        'store_id' => $store_id,
                        'label_id' => $label_id,
                    ];
                    $_link->setAttributes($data);
                    $_link->save();
                }
            }

            return ResultHelper::json(200, '修改成功');
        } else {
            $error = ErrorsHelper::getModelError($model);

            return ResultHelper::json(400, $error);
        }
    }

    /**
     * Deletes an existing BlocStore model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws StaleObjectException
     */
    public function actionDelete($id): array
    {
        $this->findModel($id)->delete();
        $bloc_id = $this->bloc_id;

        return ResultHelper::json(200, '获取成功', ['bloc_id' => $bloc_id]);
    }


    /**
     * Finds the BlocStore model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return array|ActiveRecord the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): array|\yii\db\ActiveRecord
    {
        $BlocStore = new BlocStore([
            'extras' => $this->extras,
        ]);
        if (($model = $BlocStore::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('校验数据是否存在');
    }
}
