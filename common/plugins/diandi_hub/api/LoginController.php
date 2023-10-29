<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-04 01:06:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-07-01 23:51:13
 */

namespace common\plugins\diandi_hub\api;

use Yii;
use api\controllers\AController;
use common\plugins\diandi_hub\models\DdShopAreas;
use common\models\DdMember;
use common\plugins\diandi_hub\services\AddressService;
use common\helpers\ResultHelper;
use common\models\DdUserAddress;

/**
 * Class AddressController
 */
class LoginController extends AController
{
    public $modelClass = '\common\models\Member';

    public function actionSearch()
    {
        return [
            'error_code'    => 20,
            'res_msg'       => 'ok',
        ];
    }
    
    // 普通注册
    // 验证码注册
    
    // 普通登录
    // 验证码登录
    
    // 找回密码
    // 修改密码
    
    // 退出登录
    
    

}
