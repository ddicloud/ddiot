<?php

namespace common\plugins\diandi_website\models;

use Yii;
use common\traits\ActiveQuery\StoreTrait;

/**
 * This is the model class for table "{{%diandi_website_pro_price_son}}".
 *
 * @public int $id
 * @public int|null $store_id
 * @public int|null $bloc_id
 * @public string|null $create_time
 * @public string|null $update_time
 * @public string|null $title 标题
 * @public int|null $is_have 是否包含该功能1.有2.无
 * @public int|null $sort 排序
 * @public int|null $price_id 关联价格体系id
 */
class WebsitePriceSon extends \yii\db\ActiveRecord
{
    use StoreTrait;

    /**
     * {@inheritdoc}
     */
    public static function  tableName(): string
    {
        return '{{%diandi_website_pro_price_son}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['store_id', 'bloc_id', 'is_have', 'sort', 'price_id'], 'integer'],
            [['create_time', 'update_time'], 'string', 'max' => 30],
            [['title'], 'string', 'max' => 100],
        ];
    }

    /**
     * 行为.
     */
    public function behaviors(): array
    {
        /*自动添加创建和修改时间*/
        return [
            [
                'class' => \common\behaviors\SaveBehavior::class,
                'updatedAttribute' => 'update_time',
                'createdAttribute' => 'create_time',
                'time_type' => 'datetime',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'store_id' => 'Store ID',
            'bloc_id' => 'Bloc ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'title' => '标题',
            'is_have' => '是否包含该功能1.有2.无',
            'sort' => '排序',
            'price_id' => '关联价格体系id',
        ];
    }
}
