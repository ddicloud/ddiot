<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-22 10:39:07
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-26 11:47:21
 */


namespace addons\diandi_tea\models\marketing;

use common\traits\ActiveQuery\StoreTrait;
use Yii;

/**
 * This is the model class for table "{{%diandi_tea_recharge}}".
 *
 * @public int $id 充值活动列表id
 * @public int $bloc_id 人脸库组id
 * @public int $store_id
 * @public string|null $create_time
 * @public string|null $update_time
 * @public float|null $price 价格
 * @public float|null $give_money 赠送金额
 * @public string|null $give_coupon_ids 赠送卡券id集合
 * @public int|null $type 是否为活动套餐：1.是 2否
 */
class TeaRechargeCoupon extends \yii\db\ActiveRecord
{
    use StoreTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%diandi_tea_recharge}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
     
            [['bloc_id', 'store_id', 'type'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['price', 'give_money'], 'number'],
            [['give_coupon_ids'], 'string', 'max' => 100],
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
            'id' => '充值活动列表id',
            'bloc_id' => '人脸库组id',
            'store_id' => 'Store ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'price' => '价格',
            'give_money' => '赠送金额',
            'give_coupon_ids' => '赠送卡券id集合',
            'type' => '是否为活动套餐：1.是 2否',
        ];
    }
}
