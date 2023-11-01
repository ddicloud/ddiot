<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-04 01:06:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 17:04:55
 */

namespace common\plugins\diandi_hub\admin\api;

use common\plugins\diandi_hub\services\levelService;
use admin\controllers\AController;

/**
 * Class AddressController.
 */
class LevelController extends AController
{
    public $modelClass = '\common\models\Member';

    public int $searchLevel = 0;

    public function actionLink()
    {
        global $_GPC;
        $member_id =\Yii::$app->request->input('member_id');
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
