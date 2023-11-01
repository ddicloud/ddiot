<?php
/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-04-14 00:49:51
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-03-13 10:43:05
 */

namespace admin\controllers\auth;

use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use common\models\UserBloc;
use common\models\UserStore;
use diandi\addons\models\AddonsUser;
use diandi\addons\models\Bloc;
use diandi\addons\models\BlocStore;
use diandi\addons\models\DdAddons;
use diandi\admin\models\Assignment;
use diandi\admin\models\searchs\Assignment as AssignmentSearch;
use Yii;
use yii\base\Exception;
use yii\base\InvalidConfigException;
use yii\web\NotFoundHttpException;

/**
 * AssignmentController implements the CRUD actions for Assignment model.
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 *
 * @since 1.0
 */
class AssignmentController extends AController
{
    public $modelClass = '';

    public mixed  $userClassName;
    public string $idField = 'id';
    public string $usernameField = 'username';

    public array $extraColumns = [];

    public int $type;

    public string $module_name;

    public int $searchLevel = 0;


    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function init(): void
    {
        $this->userClassName = Yii::$app->getUser()->identityClass;

        $this->module_name = Yii::$app->request->get('module_name', 'sys');
        $this->type = $this->module_name == 'sys' ? 0 : 1;
        parent::init();
//        if ($this->userClassName === null) {
//            $this->userClassName = Yii::$app->getUser()->identityClass;
//            $this->userClassName = $this->userClassName ?: 'diandi\admin\models\User';
//        }

    }

    /**
     * Lists all Assignment models.
     *
     * @return array
     */
    public function actionIndex(): array
    {
//        if ($this->searchClass === null) {
//
//        } else {
//            $class = $this->searchClass;
//            $searchModel = new $class();
//            $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
//        }

        $searchModel = new AssignmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams(), $this->userClassName, $this->usernameField);
        return ResultHelper::json(200, '获取成功', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'module_name' => $this->module_name,
            'idField' => $this->idField,
            'usernameField' => $this->usernameField,
            'extraColumns' => $this->extraColumns,
        ]);
    }

    /**
     * Displays a single Assignment model.
     *
     * @param int $id
     *
     * @return array
     */
    public function actionView($id): array
    {
        $model = $this->getAssigment($id);
        $items = $model->getItems(3);
        $all = $items['all'];
        // 所有应用
        $all['addons'] = DdAddons::find()->asArray()->all();
        $addons_mids = array_column($all['addons'], 'mid');
        // 所有商户
        $list = Bloc::find()->with(['store'])->asArray()->all();
//        $lists = [];
        $store_ids = [];
        foreach ($list as &$value) {
            $value['label'] = $value['business_name'];
            $value['id'] = $value['bloc_id'];
            $store = $value['store'];
            // 需要把商户的权限交给公司，把公司权限授权出去
            foreach ($store as &$val) {
                $val['label'] = $val['name'];
                $val['id'] = $val['store_id'];
                $store_ids[] = $val['store_id'];
            }
            $value['children'] = $store;
//            $lists[] = $value;
        }
        unset($value);
        $all['store'] = $list;
        $alls = [];

        $assigneds = $items['assigned'];
        // 用户的应用权限
        $assigneds['addons'] = AddonsUser::find()->alias('u')->joinWith('addons as a')->where(['u.user_id' => $id, 'a.mid' => $addons_mids])->select('a.mid')->indexBy('a.mid')->column();

        $assigneds['store'] = UserStore::find()->alias('u')->joinWith('store as s')->where(['u.user_id' => $id, 's.store_id' => $store_ids])->select('s.store_id')->indexBy('s.store_id')->column();

        $keyList = [
            'addons',
            'permission',
            'role',
            'route',
            'store',
        ];
        $assignedKey = [];
        foreach ($assigneds as $key => $value) {
            $assignedKey[] = $key;
            $assigned[$key] = array_keys($value);
        }

        $keyDiff = array_diff($keyList, $assignedKey);
        foreach ($keyDiff as $value) {
            $assigned[$value] = [];
        }

        foreach ($all as $key => $value) {
            $alls[$key] = array_values($value);
        }

        // 公司授权
        $assigned['bloc'] = UserBloc::find()->where(['user_id' => $id])->select('bloc_id')->groupBy('bloc_id')->column();

        return ResultHelper::json(200, '获取成功', [
            'all' => $alls,
            'assigned' => $assigned,
        ]);
    }

    /**
     * @throws \Exception
     */
    public function actionChange(): array
    {
        global $_GPC;
        $id = Yii::$app->request->input('id');
        $items = Yii::$app->request->input('items');
        $type = Yii::$app->request->input('type');

        if (empty($id)) {
            return ResultHelper::json(400, '参数id不能为空');
        }

        if (empty($type)) {
            return ResultHelper::json(400, '参数type不能为空');
        }

        // 获取原先的权限集
        $model = $this->getAssigment($id);
        $itemModel = $model->getItems(3);
        $all = $itemModel['all'];
        // 所有应用
        $all['addons'] = DdAddons::find()->asArray()->all();
        $addons_mid = array_column($all['addons'], 'mid');
        // 所有商户
        $list = Bloc::find()->with(['store'])->asArray()->all();
//        $lists = [];
        $store_ids = [];
        foreach ($list as $key => &$value) {
            $value['label'] = $value['business_name'];
            $value['id'] = $value['bloc_id'];
            $store = $value['store'];
            if (!empty($value['store'])) {
                foreach ($store as &$val) {
                    $val['label'] = $val['name'];
                    $val['id'] = $val['store_id'];
                    $store_ids[] = $val['store_id'];
                }
                $value['children'] = $store;
//                $lists[] = $value;
            } else {
                unset($list[$key]);
            }
        }
        $assignedAll = $itemModel['assigned'];
        // 用户的应用权限
        $AddonsUser = new AddonsUser();
        $assignedAll['addons'] = $AddonsUser::find()->alias('u')->joinWith('addons as a')->where(['u.user_id' => $id, 'a.mid' => $addons_mid])->select('a.mid')->indexBy('a.mid')->column();

        // 商户权限
        $UserStore = new UserStore();
        $assignedAll['store'] = $UserStore::find()->alias('u')->joinWith('store as s')->where(['u.user_id' => $id, 's.store_id' => $store_ids])->select('s.store_id')->indexBy('s.store_id')->column();

        $keyList = [
            'addons',
            'permission',
            'role',
            'route',
            'store',
        ];
        $assignedKey = [];
        unset($value);
        foreach ($assignedAll as $key => $value) {
            $assignedKey[] = $key;
            $assigned[$key] = array_keys($value);
        }

        $keyDiff = array_diff($keyList, $assignedKey);
        foreach ($keyDiff as $value) {
            $assigned[$value] = [];
        }

        $assigned_ids = $assigned[$type]??[];
        $authItems = $items ? $items[$type] : [];
        switch ($type) {
            case 'permission':
                $model = new Assignment([
                    'id' => $id,
                    'is_sys' => 3,
                ]);
                // 增加权限
                $add_ids = array_diff($authItems, $assigned_ids);
                $model->assign([
                    'permission' => array_values($add_ids),
                ]);
                // 删除权限
                $delete_ids = array_diff($assigned_ids, $authItems);
                $model->revoke([
                    'permission' => array_values($delete_ids),
                ]);
                break;
            case 'route':
                $model = new Assignment([
                    'id' => $id,
                    'is_sys' => 3,
                ]);
                // 增加权限
                $add_ids = array_diff($authItems, $assigned_ids);
                $model->assign([
                    'route' => array_values($add_ids),
                ]);
                // 删除权限
                $delete_ids = array_diff($assigned_ids, $authItems);
                $model->revoke([
                    'route' => array_values($delete_ids),
                ]);
                break;
            case 'role':
                $model = new Assignment([
                    'id' => $id,
                    'is_sys' => 3,
                ]);
                // 增加权限
                $add_ids = array_diff($authItems, $assigned_ids);
                $model->assign([
                    'role' => array_values($add_ids),
                ]);
                // 删除权限
                $delete_ids = array_diff($assigned_ids, $authItems);
                $model->revoke([
                    'role' => array_values($delete_ids),
                ]);
                break;
            case 'addons':
                // 增加权限
                $add_ids = array_diff($authItems, $assigned_ids);
                $addList = DdAddons::find()->where(['mid' => $add_ids])->asArray()->all();
                foreach ($addList as $value) {
                    $_AddonsUser = clone $AddonsUser;
                    $data = [
                        'user_id' => $id,
                        'is_default' => 0,
                        'type' => 1,
                        'module_name' => $value['identifie'],
                        'status' => 0,
                    ];
                    $_AddonsUser->setAttributes($data);
                    if (!$_AddonsUser->save()) {
                        $msg = ErrorsHelper::getModelError($_AddonsUser);
                        throw new \Exception($msg);
                    }
                }
                // 删除权限
                $delete_ids = array_diff($assigned_ids, $authItems);
                $deleteList = DdAddons::find()->where(['mid' => $delete_ids])->select('identifie')->column();
                $AddonsUser::deleteAll([
                    'user_id' => $id,
                    'module_name' => $deleteList,
                ]);
                break;
            case 'store':
                // 增加权限
                $add_ids = array_diff($authItems, $assigned_ids);

                $addList = BlocStore::find()->where(['store_id' => $add_ids])->asArray()->all();
                $UserStore = new UserStore();
                foreach ($addList as $value) {
                    $_UserStore = clone $UserStore;
                    $data = [
                        'user_id' => $id,
                        'bloc_id' => $value['bloc_id'],
                        'store_id' => $value['store_id'],
                        'status' => 0,
                    ];
                    $_UserStore->setAttributes($data);
                    if (!$_UserStore->save()) {
                        $msg = ErrorsHelper::getModelError($_UserStore);
                        throw new \Exception($msg);
                    }
                }
                // 删除权限
                $delete_ids = array_diff($assigned_ids, $authItems);
                $UserStore::deleteAll([
                    'user_id' => $id,
                    'store_id' => $delete_ids,
                ]);
                break;
            case 'bloc':
                //授权的公司
                $assigned_ids = UserBloc::find()->where(['user_id' => $id])->select('bloc_id')->groupBy('bloc_id')->column();
                // 过滤掉总部的权限
                $blocGroups = Bloc::find()->where(['is_group' => 1])->select('bloc_id')->column();
                if($authItems){
                    foreach ($authItems as $key => $value) {
                        if(in_array($value,$blocGroups)){
                            unset($authItems[$key]);
                        }
                    }
                }

                $add_ids = array_diff($authItems, $assigned_ids);

                $addList = Bloc::find()->where(['bloc_id' => $add_ids])->asArray()->all();
                $UserBloc = new UserBloc();
                foreach ($addList as $value) {
                    $_UserBloc = clone $UserBloc;
                    $data = [
                        'user_id' => $id,
                        'bloc_id' => $value['bloc_id'],
                        'status' => 0,
                    ];
                    $_UserBloc->setAttributes($data);
                    if (!$_UserBloc->save()) {
                        $msg = ErrorsHelper::getModelError($_UserBloc);
                        throw new \Exception($msg);
                    }
                }
                // 删除权限
                $delete_ids = array_diff($assigned_ids, $authItems);
                $UserBloc::deleteAll([
                    'user_id' => $id,
                    'bloc_id' => $delete_ids
                ]);
                break;
            default:
                break;
        }

        $key = 'auth_' . $id . '_' . 'initmenu';
        Yii::$app->cache->delete($key);

        return $this->actionView($id);
    }

    /**
     * Assign items.
     *
     * @param int $id
     *
     * @return array
     */
    public function actionAssign(int $id): array
    {
        $items = Yii::$app->getRequest()->post('items', []);

        $model = new Assignment([
            'id' => $id,
            'is_sys' => $this->is_sys,
        ]);

        $success = $model->assign($items);
        Yii::$app->getResponse()->format = 'json';

        return array_merge($model->getItems($this->is_sys), ['success' => $success]);
    }

    /**
     * Assign items.
     *
     * @param int $id
     *
     * @return array
     */
    public function actionRevoke(int $id): array
    {
        $items = Yii::$app->getRequest()->post('items', []);
        $model = new Assignment([
            'id' => $id,
            'is_sys' => $this->is_sys,
        ]);
        $success = $model->revoke($items);
        Yii::$app->getResponse()->format = 'json';

        return array_merge($model->getItems($this->is_sys), ['success' => $success]);
    }

    public function getAssigment($id): array|Assignment
    {
        $class = $this->userClassName;
        if (($user = $class::findIdentity($id)) !== null) {
            return new Assignment([
                'id' => $id,
                'type' => $this->type,
            ], $user);

        } else {
            return ResultHelper::json(500, '请检查数据是否存在');
        }
    }


}
