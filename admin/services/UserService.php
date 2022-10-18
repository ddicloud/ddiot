<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-04-20 20:25:49
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-18 11:24:41
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
use diandi\addons\models\UserBloc;
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

    public static function initGroup($user_id)
    {
        $authManager = Yii::$app->getAuthManager();
        $defaultRoles = $authManager->defaultRoles;
        $default_group_ids = AuthUserGroup::find()->where(['name' => $defaultRoles])->select('id')->column();
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
}
