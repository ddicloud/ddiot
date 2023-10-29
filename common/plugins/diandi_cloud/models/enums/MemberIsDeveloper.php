<?php

/**
 * @Author: Radish minradish@163.com
 * @Date:   2022-09-16 Friday
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-09-16 Friday
 */

namespace common\plugins\diandi_cloud\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class MemberIsDeveloper extends BaseEnum
{
    const VALID = 1;
    const INVALID = -1;

    /**
     * @var array
     */
    public static $list = [
        self::VALID => '是',
        self::INVALID => '否',
    ];
}
