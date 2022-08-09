<?php

namespace addons\diandi_website\models;

use Yii;
use common\traits\ActiveQuery\StoreTrait;

/**
 * This is the model class for table "{{%diandi_website_pro_price_son}}".
 *
 * @property int $id
 * @property int|null $store_id
 * @property int|null $bloc_id
 * @property string|null $create_time
 * @property string|null $update_time
 * @property string|null $title 标题
 * @property int|null $is_have 是否包含该功能1.有2.无
 * @property int|null $sort 排序
 * @property int|null $price_id 关联价格体系id
 */
class WebsitePriceSon extends \yii\db\ActiveRecord
{
    use StoreTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_website_pro_price_son}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
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
    public function behaviors()
    {
        /*自动添加创建和修改时间*/
        return [
            [
                'class' => \common\behaviors\SaveBehavior::className(),
                'updatedAttribute' => 'update_time',
                'createdAttribute' => 'create_time',
                'time_type' => 'datetime',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
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
