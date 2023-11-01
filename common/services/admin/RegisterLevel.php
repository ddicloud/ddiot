<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-04-20 20:25:49
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-04-22 02:38:49
 */

namespace common\services\admin;

use common\services\BaseService;
use diandi\addons\models\Bloc;
use diandi\addons\models\enums\RegisterLevelStatus;

class RegisterLevel extends BaseService
{

    public static function isRegister($userInfo, $bloc_id): bool
    {
        
        $group_bloc_id = Bloc::find()->where(['bloc_id' => $bloc_id])->select(['group_bloc_id'])->scalar();
        $register_level = Bloc::find()->where(['bloc_id' => $group_bloc_id])->select(['register_level'])->scalar();

        return match ($register_level) {
            RegisterLevelStatus::BLOC => $userInfo && $userInfo['bloc_id'] == $bloc_id,
            RegisterLevelStatus::STORE => $userInfo && $userInfo['store_id'] ==\Yii::$app->request->input('store_id',0),
            default => $userInfo && $userInfo['bloc_id'] == $group_bloc_id,
        };
    }
}
