<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-04 01:06:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-07-01 23:52:07
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
class MoneyController extends AController
{
    public $modelClass = '\common\models\Member';
}