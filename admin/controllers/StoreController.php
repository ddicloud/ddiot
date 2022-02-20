<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-04-27 03:17:29
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-01-20 00:35:01
 */

namespace admin\controllers;

use common\helpers\CacheHelper;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use common\models\UserBloc;
use diandi\addons\models\Bloc;
use diandi\admin\models\AuthAssignmentGroup;
use Yii;

class StoreController extends AController
{
    public $modelClass = '';
    protected $authOptional = ['*'];

    public function actionInfo()
    {
        global $_GPC;
        $store_id = Yii::$app->params['store_id'];
        $store = Yii::$app->service->commonGlobalsService->getStoreDetail($store_id);

        if (!$store) {
            return ResultHelper::json(400, '商户或不存在，请检查配置参数', $store);
        }

        $bloc_id = $store['bloc_id'];
        $config    = Yii::$app->service->commonGlobalsService->getConf($bloc_id);
        $store['config']   = $config;
        return ResultHelper::json(200, '获取成功', $store);
    }

    public function actionDetailinfo()
    {
        global $_GPC;
        $store_id = $_GPC['store_id'];
        $store = Yii::$app->service->commonGlobalsService->getStoreDetail($store_id);

        if (!$store) {
            return ResultHelper::json(400, '商户或不存在，请检查配置参数', $store);
        }

        return ResultHelper::json(200, '获取成功', $store);
    }

    public function actionCate()
    {
        global $_GPC;
        $parent_id = $_GPC['parent_id'];

        $list = Yii::$app->service->commonStoreService->getCate($parent_id);

        return ResultHelper::json(200, '获取成功', $list);
    }

    public function actionList()
    {
        global $_GPC;
        $logPath = Yii::getAlias('@runtime/StoreService/list/'.date('Y/md').'.log');

        $category_pid = $_GPC['category_pid'];
        $category_id = $_GPC['category_id'];
        $keywords = $_GPC['keywords'];
        $longitude = $_GPC['longitude'];
        $latitude = $_GPC['latitude'];
        $label_id = intval($_GPC['label_id']);

        $page = $_GPC['page'];
        $pageSize = $_GPC['pageSize'];

        $list = Yii::$app->service->commonStoreService->list($category_pid, $category_id, $longitude, $latitude, $keywords, $label_id, $page, $pageSize);

        return ResultHelper::json(200, '获取成功', $list);
    }

    public function actionDetail()
    {
    }

    public function actionBlocs()
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
            $bloc_ids = $UserBloc->find()->alias('a')->where($where)->joinWith('bloc as c')->joinWith('store as s')->select(['a.bloc_id', 'a.store_id'])->limit(5)->asArray()->all();

            foreach ($bloc_ids as $key => $value) {
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
        $cacheClass->set($key, $list);

        $blocs = Yii::$app->params['userBloc'];
        foreach ($blocs as $key => &$value) {
            if (!empty($value['store'])) {
                foreach ($value['store'] as $k => &$val) {
                    $val['logo'] = ImageHelper::tomedia($val['logo']);
                }
            }
        }

        return ResultHelper::json(200, '获取成功', $blocs);
    }
}
