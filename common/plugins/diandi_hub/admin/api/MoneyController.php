<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-04 01:06:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 17:05:04
 */

namespace common\plugins\diandi_hub\admin\api;

use admin\controllers\AController;

/**
 * Class AddressController.
 */
class MoneyController extends AController
{
    public $modelClass = '\common\models\Member';

    public int $searchLevel = 0;
}
