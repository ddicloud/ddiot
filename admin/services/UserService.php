<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-04-20 20:25:49
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-28 08:16:02
 */

namespace admin\services;

use admin\models\addons\models\Bloc;
use admin\models\DdApiAccessToken;
use common\models\enums\UserStatus;
use admin\models\User;
use common\helpers\ErrorsHelper;
use common\helpers\loggingHelper;
use common\models\DdStoreUser;
use common\services\BaseService;
use diandi\addons\components\BlocUser;
use diandi\addons\models\AddonsUser;
use diandi\addons\models\UserBloc;
use diandi\admin\acmodels\AuthUserGroup;
use diandi\admin\models\User as ModelsUser;

class UserService extends BaseService
{
    public static function deleteUser($user_id)
    {
        $where = [];
        $where['user_id'] = $user_id;
        AuthUserGroup::findOne($where)->delete();
        AddonsUser::findOne($where)->delete();
        DdStoreUser::findOne($where)->delete();
        User::findOne($user_id)->delete();
        DdApiAccessToken::findOne($where)->delete();
        UserBloc::findOne($where)->delete();
    }

    public static function deleteFile()
    {
        // dd_upload_file_user
    }

    public static function upStatus($user_id,$type)
    {
        $list = UserStatus::getConstantsByName();
        $user = User::findOne($user_id);
        $user->status = $list[$type];
        return  $user->update();
    }

    /**
     * 创建用户公司进行绑定
     * @return void
     * @date 2022-08-28
     * @example
     * @author Wang Chunsheng
     * @since
     */
    public static function SignBindBloc($user_id,$is_default = 1)
    {
        $transaction = Bloc::getDb()->beginTransaction();

        try {
            $have_user = ModelsUser::find()->where(['id'=>$user_id])->asArray()->one();
            if(!empty($have_user)){
                // 创建公司
                $bloc = new Bloc();
                $bloc->load([
                    'business_name'=>''
                ],'');
                // 绑定用户
                if($bloc->save()){
                    $BlocUser = new UserBloc();
                    $data = [
                        'user_id'=>$user_id,
                        'status'=>0,
                        'is_default'=>$is_default
                    ];
                    $BlocUser->load($data,'');
                    if(!$BlocUser->save()){
                        $msg = ErrorsHelper::getModelError($BlocUser);
                        ErrorsHelper::throwError(0,$msg);
                    } 
                }else{
                    $msg = ErrorsHelper::getModelError($bloc);
                    ErrorsHelper::throwError(0,$msg);
                }
    
            }

            $transaction->commit();
        } catch (\Exception $e) {
            loggingHelper::writeLog('admin', 'SignBindBloc', 'Exception错误', $e);

            $transaction->rollBack();
            throw $e;
        } catch (\Throwable $e) {
            loggingHelper::writeLog('admin', 'SignBindBloc', 'Throwable错误', $e);

            $transaction->rollBack();
            throw $e;
        }
      
    }
}
