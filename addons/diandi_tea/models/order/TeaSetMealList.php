<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-22 19:44:00
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-26 11:48:05
 */

namespace addons\diandi_tea\models\order;

use common\models\DdMember;

/**
 * This is the model class for table "{{%diandi_tea_set_meal_list}}".
 *
 * @public int         $id          套餐消费记录id
 * @public int         $bloc_id     人脸库组id
 * @public int         $store_id
 * @public string|null $create_time
 * @public string|null $update_time
 * @public string|null $title       套餐名
 * @public int|null    $duration    套餐时长
 * @public float|null  $price       套餐价格
 * @public float|null  $renew_price 每半小时续费单价
 * @public int|null    $order_id    订单id
 * @public int|null    $set_meal_id 套餐id
 */
class TeaSetMealList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%diandi_tea_set_meal_list}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
           
            [['bloc_id', 'store_id', 'duration', 'order_id', 'set_meal_id', 'member_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['price', 'renew_price'], 'number'],
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
                'time_type'=>'datetime'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => '套餐消费记录id',
            'bloc_id' => '人脸库组id',
            'store_id' => 'Store ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'title' => '套餐名',
            'duration' => '套餐时长',
            'price' => '套餐价格',
            'renew_price' => '每半小时续费单价',
            'order_id' => '订单id',
            'set_meal_id' => '套餐id',
            'member_id' => '会员id'
        ];
    }

    /**
     * 关联用户模型.
     */
    public function getMember(): \yii\db\ActiveQuery
    {
        return $this->hasOne(DdMember::class, ['member_id' => 'member_id'])->select('nickName')->asArray();
    }
}
