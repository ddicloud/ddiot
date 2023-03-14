<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-16 23:02:12
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-03-14 17:25:50
 */

namespace admin\models;

use common\traits\ActiveQuery\StoreTrait;
use diandi\addons\models\StoreCategory as ModelsStoreCategory;
use Yii;

/**
 * This is the model class for table "{{%diandi_store_category}}".
 *
 * @property int $category_id 分类id
 * @property string $name 分类名称
 * @property int $parent_id 父级id
 * @property string $thumb 分类图片
 * @property int $sort 分类排序
 * @property int $create_time
 * @property int $update_time
 */
class StoreCategory extends ModelsStoreCategory
{
    use StoreTrait;
}
