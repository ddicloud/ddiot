<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-04 01:50:44
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-25 19:26:47
 */

namespace common\plugins\diandi_hub\api;

use common\plugins\diandi_hub\models\account\HubAccountLog;
use common\plugins\diandi_hub\models\account\HubAccountOrder;
use common\plugins\diandi_hub\models\enums\EarningsStatus;
use Yii;
use api\controllers\AController;
use common\plugins\diandi_hub\models\goods\HubCategory;
use common\plugins\diandi_hub\services\MemberService;
use common\helpers\ArrayHelper;
use common\helpers\ImageHelper;
use common\helpers\loggingHelper;
use common\helpers\ResultHelper;

/**
 * Class CategoryController.
 */
class CeshiController extends AController
{
    public $modelClass = '\common\models\DdCategory';
    protected array $authOptional = ['list'];

    public function actionSearch()
    {
        return [
            'error_code' => 20,
            'res_msg' => 'ok',
        ];
    }

   

    
    public function actionSms()
    {
        global $_GPC;
        $mobile = Yii::$app->request->input('mobile');
        Yii::$app->cache->set($mobile.'_code','147852');
    }
    
}
