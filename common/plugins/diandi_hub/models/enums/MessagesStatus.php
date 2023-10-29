<?php

/**
 * @Author: Radish <minradish@163.com>
 * @Date:   2022-10-09 15:34:46
 * @Last Modified by:   Radish <minradish@163.com>
 * @Last Modified time: 2022-10-09 15:36:43
 */

namespace common\plugins\diandi_hub\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class MessagesStatus extends BaseEnum
{
    const VALID = 1;
    const INVALID = -1;

    /**
     * @var array
     */
    public static $list = [
        self::VALID => '有效',
        self::INVALID => '无效',
    ];
}
