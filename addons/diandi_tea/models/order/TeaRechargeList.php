<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-18 14:07:03
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-26 16:53:53
 */

namespace addons\diandi_tea\models\order;

use addons\diandi_tea\models\marketing\TeaRecharge;
use common\models\DdMember;

/**
 * This is the model class for table "{{%diandi_tea_recharge_list}}".
 *
 * @public int         $id          余额充值id
 * @public int         $bloc_id     人脸库组id
 * @public int         $store_id
 * @public string|null $create_time
 * @public string|null $update_time
 * @public int|null    $member_id   充值用户id
 * @public int|null    $recharge_id 充值套餐列表id
 * @public float|null  $price       花费金额
 * @public float|null  $balance     余额
 */
class TeaRechargeList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%diandi_tea_recharge_list}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['bloc_id', 'store_id', 'member_id', 'recharge_id','status'], 'integer'],
            [['create_time', 'update_time', 'pay_time'], 'safe'],
            [['price', 'balance'], 'number'],
            [['transaction_id', 'order_number'], 'string', 'max' => 100],
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
            'id' => '余额充值id',
            'bloc_id' => '人脸库组id',
            'store_id' => 'Store ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'member_id' => '充值用户id',
            'recharge_id' => '充值套餐列表id',
            'price' => '花费金额',
            'balance' => '余额',
            'transaction_id' => '微信订单编号',
            'order_number' => '订单编号',
            'pay_time' => '购买时间',
            'status' => '订单状态：1.待付款 2.已完成',
        ];
    }

    /**
     * 关联用户模型.
     */
    public function getMember(): \yii\db\ActiveQuery
    {
        return $this->hasOne(DdMember::class, ['member_id' => 'member_id'])->select('nickName')->asArray();
    }

    public function getRecharge(): \yii\db\ActiveQuery
    {
        return $this->hasOne(TeaRecharge::class, ['id' => 'recharge_id'])->select(['give_money','id'])->asArray();
    }
}
