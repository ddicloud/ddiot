<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-04 01:06:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-28 17:04:49
 */

namespace common\plugins\diandi_hub\admin\api;

use admin\controllers\AController;

/**
 * Class AddressController.
 */
class HubController extends AController
{
    public $modelClass = '\common\models\Member';

    public int $searchLevel = 0;


    // 我的资金状况：我的收益/累计提现/当前余额
    // 我的二维码
    // 我的分销统计
    // 我的佣金明细
    // 团队分销排行

    // 我的下级
    // 我的上级
    // 等级更新
    // 等级注册

    // 我的提现记录
}
