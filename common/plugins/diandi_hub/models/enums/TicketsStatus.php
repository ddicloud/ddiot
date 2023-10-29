<?php

/**
 * @Author: Radish (minradish@163.com)
 * @Date:   2022-09-21 Wednesday
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-09-21 Wednesday
 */

namespace common\plugins\diandi_hub\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class TicketsStatus extends BaseEnum
{
    const PENDING = 1;
    const PROCESSING = 2;
    const COMPLETED = 3;
    const CANCELED = 4;

    /**
     * @var array
     */
    public static $list = [
        self::PENDING => '待处理',
        self::PROCESSING => '处理中',
        self::COMPLETED => '已完成',
        self::CANCELED => '已取消',
    ];
}
