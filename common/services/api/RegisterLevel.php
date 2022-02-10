<<<<<<< HEAD
<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-04-20 20:25:49
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-04-22 02:38:03
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
        $group_bloc_id = Bloc::find()->where(['bloc_id' => $bloc_id])->select(['group_bloc_id'])->scalar();
        $register_level = Bloc::find()->where(['bloc_id' => $group_bloc_id])->select(['register_level'])->scalar();

        switch ($register_level) {
            case RegisterLevelStatus::GROUP:

                return  $userInfo && $userInfo['bloc_id'] == $group_bloc_id;

                break;
            case RegisterLevelStatus::BLOC:
                return  $userInfo  && $userInfo['bloc_id'] == $bloc_id;

                break;
            case RegisterLevelStatus::STORE:
                return  $userInfo && $userInfo['store_id'] == $_GPC['store_id'];

                break;
            default:
                return  $userInfo && $userInfo['bloc_id'] == $group_bloc_id;

                break;
        }
    }
}
=======
<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-04-20 20:25:49
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-04-22 02:38:03
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
        $group_bloc_id = Bloc::find()->where(['bloc_id' => $bloc_id])->select(['group_bloc_id'])->scalar();
        $register_level = Bloc::find()->where(['bloc_id' => $group_bloc_id])->select(['register_level'])->scalar();

        switch ($register_level) {
            case RegisterLevelStatus::GROUP:

                return  $userInfo && $userInfo['bloc_id'] == $group_bloc_id;

                break;
            case RegisterLevelStatus::BLOC:
                return  $userInfo  && $userInfo['bloc_id'] == $bloc_id;

                break;
            case RegisterLevelStatus::STORE:
                return  $userInfo && $userInfo['store_id'] == $_GPC['store_id'];

                break;
            default:
                return  $userInfo && $userInfo['bloc_id'] == $group_bloc_id;

                break;
        }
    }
}
>>>>>>> d297d66878f9a3a9fe2acdd0ff835b199c9f0bb4
