<?php

/**
 * @Author: Radish minradish@163.com
 * @Date:   2022-09-19 11:18:22
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-09-19 11:18:34
 */

namespace common\plugins\diandi_cloud\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class MemberAudit extends BaseEnum
{
    const WAIT = 1;
    const PASS = 2;
    const OVERRULE = 3;

    /**
     * @var array
     */
    public static $list = [
        self::WAIT => '待审核',
        self::PASS => '通过',
        self::OVERRULE => '驳回',
    ];
}
