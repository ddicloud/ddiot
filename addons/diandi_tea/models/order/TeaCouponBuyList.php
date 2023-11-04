<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-18 17:40:20
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-26 11:47:41
 */

namespace addons\diandi_tea\models\order;

use common\models\DdMember;

/**
 * This is the model class for table "{{%diandi_tea_coupon_buy_list}}".
 *
 * @public int         $id          人脸招聘
 * @public int         $bloc_id     人脸库组id
 * @public int         $store_id
 * @public string|null $create_time
 * @public string|null $update_time
 * @public int|null    $member_id   会员id
 * @public int|null    $coupon_id   卡券id
 * @public float|null  $price       价格
 */
class TeaCouponBuyList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%diandi_tea_coupon_buy_list}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['bloc_id', 'store_id', 'member_id', 'coupon_id', 'coupon_type', 'pay_type','status'], 'integer'],
            [['create_time', 'update_time', 'pay_time'], 'safe'],
            [['price','balance'], 'number'],
            [['coupon_name'], 'string', 'max' => 255],
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
            'id' => '人脸招聘',
            'bloc_id' => '人脸库组id',
            'store_id' => 'Store ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'member_id' => '会员id',
            'coupon_id' => '卡券id',
            'price' => '价格',
            'coupon_name' => '卡券名',
            'coupon_type' => '卡券类型  1：代金券 2：时常卡  3：次卡 4：折扣券 5：体验券',
            'transaction_id' => '微信订单编号',
            'order_number' => '订单编号',
            'pay_time' => '购买时间',
            'pay_type' => '支付方式：1.现金支付 2.余额支付',
            'status' => '订单状态：1.待付款 2.已完成 ',
            'balance' => '余额',
        ];
    }

    /**
     * 关联用户模型
     */
    public function getMember(): \yii\db\ActiveQuery
    {
        return $this->hasOne(DdMember::class,['member_id' => 'member_id'])->select('nickName')->asArray();
    }
}
