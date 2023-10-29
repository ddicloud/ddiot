<?php

/**
 * @Author: Radish minradish@163.com
 * @Date:   2022-09-16 Friday
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-09-19 11:07:14
 */

namespace common\plugins\diandi_cloud\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class MemberCertType extends BaseEnum
{
    const NOT = 1;
    const PERSONAL = 2;
    const ENTERPRISE = 3;

    /**
     * @var array
     */
    public static $list = [
        self::NOT => '未认证',
        self::PERSONAL => '个人',
        self::ENTERPRISE => '企业',
    ];
}
