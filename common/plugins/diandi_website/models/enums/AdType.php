<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-22 17:01:43
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-22 17:09:18
 */

namespace common\plugins\diandi_website\models\enums;

use yii2mod\enum\helpers\BaseEnum;

class AdType extends BaseEnum
{

    const          IMAGE = 101;
    const          LINK = 102;

    /**
     * @var string message category
     * You can set your own message category for translate the values in the $list property
     * Values in the $list property will be automatically translated in the function `listData()`
     */
    public static $messageCategory = 'App';

    /**
     * @var array
     */
    public static $list = [
        self::IMAGE => "图片广告",
        self::LINK => "友情链接",
    ];
}
