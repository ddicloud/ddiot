<?php

/**
 * @Author: Radish minradish@163.com
 * @Date:   2022-07-11 10:35:26
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-07-11 11:46:24
 */

namespace common\plugins\diandi_cloud\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class AuthDomainStatus extends BaseEnum
{
    const STATUS_NORMAL = 1;
    const STATUS_BAN = 2;
    const STATUS_ARREARS = 3;

    /**
     * @var array
     */
    public static $list = [
        self::STATUS_NORMAL => "正常",
        self::STATUS_BAN => "禁用",
        self::STATUS_ARREARS => "欠费",
    ];
}
