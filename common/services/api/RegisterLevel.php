<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-04-20 20:25:49
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-09 18:17:39
 */

namespace common\services\api;

use common\services\BaseService;
use diandi\addons\models\Bloc;
use diandi\addons\models\enums\RegisterLevelStatus;

class RegisterLevel extends BaseService
{
    public static function isRegister($userInfo, $bloc_id)
    {
        global  $_GPC;

        if (empty($userInfo)) {
            return false;
        }
        $group_bloc_id = Bloc::find()->where(['bloc_id' => $bloc_id])->select(['group_bloc_id'])->scalar();
        $group_bloc_id = $group_bloc_id === 0 ? $bloc_id : $group_bloc_id; //0集团就是自己
        $register_level = Bloc::find()->where(['bloc_id' => $group_bloc_id])->select(['register_level'])->scalar();

        switch ($register_level) {
            case RegisterLevelStatus::GROUP:
                return  $userInfo['bloc_id'] == $group_bloc_id;
                break;
            case RegisterLevelStatus::BLOC:
                return $userInfo['bloc_id'] == $bloc_id;
                break;
            case RegisterLevelStatus::STORE:

                return  $userInfo['store_id'] == Yii::$app->request->input('store_id');
                break;
            default:
                return  $userInfo['bloc_id'] == $bloc_id;
                break;
        }
    }
}
