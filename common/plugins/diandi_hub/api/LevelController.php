<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-04 01:06:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-01 10:50:31
 */

namespace common\plugins\diandi_hub\api;

use Yii;
use api\controllers\AController;
use common\plugins\diandi_hub\services\levelService;
use common\plugins\diandi_hub\models\DdShopAreas;
use common\models\DdMember;
use common\plugins\diandi_hub\services\AddressService;
use common\helpers\ResultHelper;
use common\models\DdUserAddress;

/**
 * Class AddressController
 */
class LevelController extends AController
{
    public $modelClass = '\common\models\Member';

    public function actionLink()
    {
        global $_GPC;
        $member_id = $_GPC['member_id'];
        $Res = levelService::siupChild($member_id);    
        // if($Res){
        //     $is_up = levelService::checkLevelUpdate($member_id);
        //     if($is_up){
        //         $info = levelService::getLevelByUid($member_id);
        //         levelService::upgradeLevelByUid($member_id,$info['level_num']+1);
        //      }
        // }
        return $Res;
    }

}