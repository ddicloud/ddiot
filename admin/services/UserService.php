<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-04-20 20:25:49
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-26 16:40:48
 */

namespace admin\services;

use admin\models\addons\models\Bloc;
use admin\models\DdApiAccessToken;
use admin\models\User;
use common\helpers\ErrorsHelper;
use common\helpers\loggingHelper;
use common\models\enums\UserStatus;
use common\services\BaseService;
use diandi\addons\models\AddonsUser;
use diandi\addons\models\DdAddons;
use diandi\addons\models\UserBloc;
use diandi\admin\acmodels\AuthItem;
use diandi\admin\acmodels\AuthUserGroup;
use diandi\admin\models\Assignment;
use diandi\admin\models\AuthAssignmentGroup;
use Yii;

class UserService extends BaseService
{
    public static function deleteUser($user_id)
    {
        $where = [];
        $where['user_id'] = $user_id;
        $AuthAssignmentGroup = AuthAssignmentGroup::findOne($where);
        if ($AuthAssignmentGroup) {
            $AuthAssignmentGroup->delete();
        }

        $AddonsUser = AddonsUser::findOne($where);
        if ($AddonsUser) {
            $AddonsUser->delete();
        }

        $User = User::findOne($user_id);
        if ($User) {
            $User->delete();
        }

        $DdApiAccessToken = DdApiAccessToken::findOne($where);
        if ($DdApiAccessToken) {
            $DdApiAccessToken->delete();
        }

        $UserBloc = UserBloc::findOne($where);
        if ($UserBloc) {
            $UserBloc->delete();
        }
    }

    public static function deleteFile()
    {
        // dd_upload_file_user
    }

    public static function upStatus($user_id, $type)
    {
        $list = UserStatus::getConstantsByName();
        $user = User::findOne($user_id);
        $user->status = $list[$type];

        return  $user->update();
    }

    /**
     * 用户注册完成后需要做的事情汇总.
     *
     * @param [type] $user_id
     *
     * @return void
     * @date 2022-10-26
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public static function initUserAuth($user_id)
    {
        // 初始权限组
        self::initGroup($user_id);
        // 创建公司
        self::SignBindBloc($user_id);
    }

    public static function initGroup($user_id)
    {
        $authManager = Yii::$app->getAuthManager();
        $defaultRoles = $authManager->defaultRoles;
        $default_group_ids = AuthUserGroup::find()->where(['name' => $defaultRoles])->select('item_id')->column();
        $model = new Assignment([
            'id' => $user_id,
            'is_sys' => 3,
            ]);

        $model->assign([
            'role' => $default_group_ids,
        ]);

        $key = 'auth_'.$user_id.'_'.'initmenu';
        Yii::$app->cache->delete($key);
    }

    /**
     * 创建用户公司进行绑定.
     *
     * @return void
     * @date 2022-08-28
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public static function SignBindBloc($user_id, $is_default = 1)
    {
        $transaction = Bloc::getDb()->beginTransaction();

        try {
            $have_user = User::findOne($user_id);
            if (!empty($have_user)) {
                // 创建公司
                $bloc = new Bloc();
                $blocData = [
                    'business_name' => '您的公司名称',
                    'pid' => (int) $have_user['parent_bloc_id'],
                    'is_group' => 0,
                    'province' => 0,
                    'city' => 0,
                    'district' => 0,
                    'status' => 0,
                    'address' => '',
                    'register_level' => 0,
                    'longitude' => '',
                    'latitude' => '',
                ];
                $bloc->load($blocData, '');
                // 绑定用户
                if ($bloc->save()) {
                    $bloc_id = $bloc->bloc_id;
                    $BlocUser = new UserBloc();
                    $data = [
                        'user_id' => $user_id,
                        'bloc_id' => $bloc_id,
                        'status' => 0,
                        'is_default' => $is_default,
                    ];
                    $BlocUser->load($data, '');
                    if (!$BlocUser->save()) {
                        $msg = ErrorsHelper::getModelError($BlocUser);
                        ErrorsHelper::throwError(0, $msg);
                    } else {
                        // 更新用户bloc_id
                        $userModel = User::findOne($user_id);
                        $userModel->bloc_id = $bloc_id;
                        $userModel->update();
                    }
                } else {
                    $msg = ErrorsHelper::getModelError($bloc);
                    ErrorsHelper::throwError(0, $msg);
                }
            }

            $transaction->commit();
        } catch (\Exception $e) {
            loggingHelper::writeLog('admin', 'SignBindBloc', 'Exception错误', $e);
            // 删除用户
            self::deleteUser($user_id);
            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            loggingHelper::writeLog('admin', 'SignBindBloc', 'Throwable错误', $e);
            // 删除用户
            self::deleteUser($user_id);
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * 给创建用户授权整个应用的权限.
     *
     * @return void
     * @date 2022-10-26
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public static function AssignmentPermissionByUid($user_id, $addons_identifie)
    {
        loggingHelper::writeLog('StoreService', 'createStore', 'AssignmentPermissionByUid', [
            'user_id' => $user_id,
            'addons_identifie' => $addons_identifie,
        ]);

        $items['permission'] = AuthItem::find()->where([
            'module_name' => $addons_identifie,
            'parent_id' => 0,
            'permission_type' => 1,
            'is_sys' => 0,
            ])->select('id')->asArray()->all();
        $class = Yii::$app->getUser()->identityClass ?: 'diandi\admin\models\User';
        $user = $class::findIdentity($user_id);
        // 获取原先的权限集
        $model = new Assignment([
            'id' => $user_id,
            'type' => 1, //0 系统，1模块
            ], $user);
        $itemsModel = $model->getItems(3); //3代表获取所有
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
        $assigneds['addons'] = $AddonsUser::find()->alias('u')->joinWith('addons as a')->where(['u.user_id' => $user_id, 'a.mid' => $addons_mids])->select('a.mid')->indexBy('a.mid')->column();

        // 商户权限
        $UserBloc = new UserBloc();
        $assigneds['store'] = $UserBloc::find()->alias('u')->joinWith('store as s')->where(['u.user_id' => $user_id, 's.store_id' => $store_ids])->select('s.store_id')->indexBy('s.store_id')->column();

        $keyList = [
            'addons',
            'permission',
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

        $assigned_ids = $assigned['permission'];
        $authItems = $items ? $items['permission'] : [];

        // 增加查看插件的权限
        $add_ids = array_diff($authItems, $assigned_ids);
        $addList = DdAddons::find()->where(['mid' => $add_ids])->asArray()->all();

        loggingHelper::writeLog('StoreService', 'createStore', 'AssignmentPermissionByUid', [
            'user_id' => $user_id,
            'addons_identifie' => $addons_identifie,
        ]);
        foreach ($addList as $key => $value) {
            $_AddonsUser = clone $AddonsUser;
            $data = [
                 'user_id' => $user_id,
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
             'user_id' => $user_id,
             'module_name' => $deleteList,
         ]);

        // 授权插件的权限
        $model = new Assignment([
            'id' => $user_id,
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

        $key = 'auth_'.$user_id.'_'.'initmenu';
        Yii::$app->cache->delete($key);
    }
}
