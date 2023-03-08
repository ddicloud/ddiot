<?php
/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-04-14 00:49:51
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-03-08 19:20:09
 */

namespace admin\controllers\auth;

use admin\controllers\AController;
use common\helpers\ErrorsHelper;
use common\helpers\ResultHelper;
use common\models\UserBloc;
use diandi\addons\models\AddonsUser;
use diandi\addons\models\Bloc;
use diandi\addons\models\BlocStore;
use diandi\addons\models\DdAddons;
use diandi\admin\models\Assignment;
use diandi\admin\models\searchs\Assignment as AssignmentSearch;
use Yii;
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

    public $userClassName;
    public $idField = 'id';
    public $usernameField = 'username';
    public $fullnameField;
    public $searchClass;
    public $extraColumns = [];

    public $type;

    public $module_name;

    public $searchLevel = 0;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        if ($this->userClassName === null) {
            $this->userClassName = Yii::$app->getUser()->identityClass;
            $this->userClassName = $this->userClassName ?: 'diandi\admin\models\User';
        }
        $this->module_name = Yii::$app->request->get('module_name', 'sys');
        $this->type = $this->module_name == 'sys' ? 0 : 1;
    }

    /**
     * Lists all Assignment models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        if ($this->searchClass === null) {
            $searchModel = new AssignmentSearch();
            $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams(), $this->userClassName, $this->usernameField);
        } else {
            $class = $this->searchClass;
            $searchModel = new $class();
            $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
        }

        return $this->render('index', [
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
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $items = $model->getItems(3);
        $all = $items['all'];
        // 所有应用
        $all['addons'] = DdAddons::find()->asArray()->all();
        $addons_mids = array_column($all['addons'], 'mid');
        // 所有商户
        $list = Bloc::find()->with(['store'])->asArray()->all();
        foreach ($list as $key => &$value) {
            $value['label'] = $value['business_name'];
            $value['id'] = $value['bloc_id'];
            $store = $value['store'];
            // 需要把商户的权限交给公司，把公司权限授权出去
            // if (!empty($value['store'])) {
            foreach ($store as $k => &$val) {
                $val['label'] = $val['name'];
                $val['id'] = $val['store_id'];
                $store_ids[] = $val['store_id'];
            }
            $value['children'] = $store;
            $lists[] = $value;
            // } else {
            //     unset($list[$key]);
            // }
        }
        unset($value);
        $all['store'] = $list;
        $alls = [];

        $assigneds = $items['assigned'];
        // 用户的应用权限
        $assigneds['addons'] = AddonsUser::find()->alias('u')->joinWith('addons as a')->where(['u.user_id' => $id, 'a.mid' => $addons_mids])->select('a.mid')->indexBy('a.mid')->column();

        $assigneds['store'] = UserBloc::find()->alias('u')->joinWith('store as s')->where(['u.user_id' => $id, 's.store_id' => $store_ids])->select('s.store_id')->indexBy('s.store_id')->column();

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
        foreach ($keyDiff as $key => $value) {
            $assigned[$value] = [];
        }

        foreach ($all as $key => $value) {
            $alls[$key] = array_values($value);
        }

        return ResultHelper::json(200, '获取成功', [
            'all' => $alls,
            'assigned' => $assigned,
        ]);
    }

    public function actionChange()
    {
        global $_GPC;
        $id = $_GPC['id'];
        $items = $_GPC['items'];
        $type = $_GPC['type'];

        if (empty($id)) {
            return ResultHelper::json(400, '参数id不能为空');
        }

        if (empty($type)) {
            return ResultHelper::json(400, '参数type不能为空');
        }

        // 获取原先的权限集
        $model = $this->findModel($id);
        $itemsModel = $model->getItems(3);
        $all = $itemsModel['all'];
        // 所有应用
        $all['addons'] = DdAddons::find()->asArray()->all();
        $addons_mids = array_column($all['addons'], 'mid');
        // 所有商户
        $list = Bloc::find()->with(['store'])->asArray()->all();
        foreach ($list as $key => &$value) {
            $value['label'] = $value['business_name'];
            $value['id'] = $value['bloc_id'];
            $store = $value['store'];
            if (!empty($value['store'])) {
                foreach ($store as $k => &$val) {
                    $val['label'] = $val['name'];
                    $val['id'] = $val['store_id'];
                    $store_ids[] = $val['store_id'];
                }
                $value['children'] = $store;
                $lists[] = $value;
            } else {
                unset($list[$key]);
            }
        }
        $assigneds = $itemsModel['assigned'];
        // 用户的应用权限
        $AddonsUser = new AddonsUser();
        $assigneds['addons'] = $AddonsUser::find()->alias('u')->joinWith('addons as a')->where(['u.user_id' => $id, 'a.mid' => $addons_mids])->select('a.mid')->indexBy('a.mid')->column();

        // 商户权限
        $UserBloc = new UserBloc();
        $assigneds['store'] = $UserBloc::find()->alias('u')->joinWith('store as s')->where(['u.user_id' => $id, 's.store_id' => $store_ids])->select('s.store_id')->indexBy('s.store_id')->column();

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
        foreach ($keyDiff as $key => $value) {
            $assigned[$value] = [];
        }

        $assigned_ids = $assigned[$type];
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
                foreach ($addList as $key => $value) {
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

                foreach ($addList as $key => $value) {
                    $_UserBloc = clone $UserBloc;
                    $data = [
                        'user_id' => $id,
                        'bloc_id' => $value['bloc_id'],
                        'store_id' => $value['store_id'],
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
                    'store_id' => $delete_ids,
                ]);
                break;
            case 'bloc':
                //授权的公司
                $add_ids = $assigned['bloc'];

                $addList = Bloc::find()->where(['bloc_id' => $add_ids])->asArray()->all();

                foreach ($addList as $key => $value) {
                    $_UserBloc = clone $UserBloc;
                    $data = [
                        'user_id' => $id,
                        'bloc_id' => $value['bloc_id'],
                        'store_id' => 0,
                        'status' => 0,
                    ];
                    $_UserBloc->setAttributes($data);
                    if (!$_UserBloc->save()) {
                        $msg = ErrorsHelper::getModelError($_UserBloc);
                        throw new \Exception($msg);
                    }
                }
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
     * @param string $id
     *
     * @return array
     */
    public function actionAssign($id)
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
     * @param string $id
     *
     * @return array
     */
    public function actionRevoke($id)
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

    /**
     * Finds the Assignment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return Assignment the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $class = $this->userClassName;
        if (($user = $class::findIdentity($id)) !== null) {
            return new Assignment([
                'id' => $id,
                'type' => $this->type,
            ], $user);
        } else {
            throw new NotFoundHttpException('请检查数据是否存在');
        }
    }
}
