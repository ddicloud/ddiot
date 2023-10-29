<?php

/**
 * @Author: Radish (minradish@163.com)
 * @Date:   2022-09-21 Wednesday
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-09-21 14:10:19
 */

namespace common\plugins\diandi_hub\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class TicketsRecordType extends BaseEnum
{
    const USER_SENDS = 1;
    const DEV_SENDS = 2;

    /**
     * @var array
     */
    public static $list = [
        self::USER_SENDS => '用户发送',
        self::DEV_SENDS => '开发者发送',
    ];
}
