<?php

namespace addons\diandi_tea\models\config;

use common\traits\ActiveQuery\StoreTrait;

/**
 * This is the model class for table "{{%diandi_tea_hourse_meal}}".
 *
 * @property int $id 包间id
 * @property int|null $bloc_id 人脸库组id
 * @property int|null $store_id 店铺id
 * @property string|null $set_meal_ids 包间套餐列表
 * @property int|null $place_roome_id 房间ID
 * @property string|null $create_time
 * @property string|null $update_time
 */
class TeaHourseMeal extends \yii\db\ActiveRecord
{
    use StoreTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%diandi_tea_hourse_meal}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['bloc_id', 'store_id', 'place_roome_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['set_meal_ids'], 'string', 'max' => 100],
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
    public function attributeLabels(): array
    {
        return [
            'id' => '包间id',
            'bloc_id' => '人脸库组id',
            'store_id' => '店铺id',
            'set_meal_ids' => '包间套餐列表',
            'place_roome_id' => '房间ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}