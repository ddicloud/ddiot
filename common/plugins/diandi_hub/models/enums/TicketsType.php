<?php

/**
 * @Author: Radish (minradish@163.com)
 * @Date:   2022-09-21 Wednesday
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-09-21 14:10:19
 */

namespace common\plugins\diandi_hub\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class TicketsType extends BaseEnum
{
    const BUG_FIXES = 1;
    const SALES_INQUIRE = 2;
    const OPERATE_INQUIRE = 3;

    /**
     * @var array
     */
    public static $list = [
        self::BUG_FIXES => 'BUG修复',
        self::SALES_INQUIRE => '售前咨询',
        self::OPERATE_INQUIRE => '操作咨询',
    ];
}
