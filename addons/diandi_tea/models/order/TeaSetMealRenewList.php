<?php

namespace addons\diandi_tea\models\order;

use Yii;
use common\traits\ActiveQuery\StoreTrait;

/**
 * This is the model class for table "{{%diandi_tea_set_meal_renew_list}}".
 *
 * @public int $id 套餐续费记录id
 * @public int $bloc_id 人脸库组id
 * @public int $store_id
 * @public string|null $create_time
 * @public string|null $update_time
 * @public int|null $order_id 订单id
 * @public int|null $set_meal_id 套餐id
 * @public float|null $price 半小时单价
 * @public float|null $renew_price 续费总价
 * @public int|null $renew_num 续费单位（几个半小时）
 * @public int|null $member_id 续费会员id
 */
class TeaSetMealRenewList extends \yii\db\ActiveRecord
{
    use StoreTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%diandi_tea_set_meal_renew_list}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['bloc_id', 'store_id'], 'required'],
            [['bloc_id', 'store_id', 'order_id', 'set_meal_id', 'renew_num', 'member_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['price', 'renew_price'], 'number'],
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
            'id' => '套餐续费记录id',
            'bloc_id' => '人脸库组id',
            'store_id' => 'Store ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'order_id' => '订单id',
            'set_meal_id' => '套餐id',
            'price' => '半小时单价',
            'renew_price' => '续费总价',
            'renew_num' => '续费单位（几个半小时）',
            'member_id' => '续费会员id',
        ];
    }
}
