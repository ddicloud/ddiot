<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-18 14:34:57
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-27 10:35:01
 */

namespace addons\diandi_tea\models\order;

use addons\diandi_tea\models\config\TeaHourse;
use addons\diandi_tea\models\marketing\TeaCoupon;
use common\models\DdMember;

/**
 * This is the model class for table "{{%diandi_tea_order_list}}".
 *
 * @public int         $id             包间订单id
 * @public int         $bloc_id        人脸库组id
 * @public int         $store_id
 * @public string|null $create_time
 * @public string|null $update_time
 * @public string|null $start_time     开始时间
 * @public string|null $end_time       结束时间
 * @public int|null    $member_id      会员id
 * @public int|null    $coupon_id      使用卡券id
 * @public float|null  $balance        余额
 * @public float|null  $amount_payable 应付金额
 * @public float|null  $discount       优惠金额
 * @public float|null  $real_pay       实付金额
 * @public string|null $order_number   订单编号
 * @public int|null    $pay_type       支付方式：1.现金支付 2.余额支付
 * @public int|null    $status         订单状态：1.待付款 2.支付成功 3.已完成 4.已取消
 * @public int|null    $hourse_id      包间id
 * @public int|null    $is_use         是否正在使用 ：1.未使用  2.使用中  3.已使用
 * @public int|null    $order_type     订单类型 1.包间订单  2.续费订单
 * @public int|null    $set_meal_id    使用套餐id
 * @public string|null $set_meal_name  使用套餐名
 * @public int|null    $renew_order_id 续费订单id
 * @public string|null $transaction_id 微信订单id
 * @public string|null $pay_time       支付时间
 * @public float|null  $renew_price    半小时续费单价
 * @public int|null    $renew_num      续费单位个数
 * @public int|null    $pwd            开锁密码
 */
class TeaOrderList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%diandi_tea_order_list}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['bloc_id', 'store_id', 'member_id', 'coupon_id', 'pay_type', 'status', 'hourse_id', 'is_use', 'order_type', 'set_meal_id', 'renew_order_id', 'renew_num', 'pwd'], 'integer'],
            [['create_time', 'update_time', 'start_time', 'end_time', 'pay_time'], 'safe'],
            [['balance', 'amount_payable', 'discount', 'real_pay', 'renew_price'], 'number'],
            [['order_number', 'transaction_id'], 'string', 'max' => 100],
            [['set_meal_name'], 'string', 'max' => 255],
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
            'id' => '包间订单id',
            'bloc_id' => '人脸库组id',
            'store_id' => 'Store ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'start_time' => '开始时间',
            'end_time' => '结束时间',
            'member_id' => '会员id',
            'coupon_id' => '使用卡券id',
            'balance' => '余额',
            'amount_payable' => '应付金额',
            'discount' => '优惠金额',
            'real_pay' => '实付金额',
            'order_number' => '订单编号',
            'pay_type' => '支付方式：1.现金支付 2.余额支付',
            'status' => '订单状态：1.待付款 2.支付成功 3.已完成 4.已取消',
            'hourse_id' => '包间id',
            'is_use' => '是否正在使用 ：1.未使用  2.使用中  3.已使用',
            'order_type' => '订单类型 1.包间订单  2.续费订单',
            'set_meal_id' => '使用套餐id',
            'set_meal_name' => '使用套餐名',
            'renew_order_id' => '续费订单id',
            'transaction_id' => '微信订单id',
            'pay_time' => '支付时间',
            'renew_price' => '半小时续费单价',
            'renew_num' => '续费单位个数',
            'pwd' => '开锁密码',
        ];
    }

    /**
     * 关联用户模型.
     */
    public function getMember(): \yii\db\ActiveQuery
    {
        return $this->hasOne(DdMember::class, ['member_id' => 'member_id'])->select(['nickName', 'member_id'])->asArray();
    }

    public function getHourse(): \yii\db\ActiveQuery
    {
        return $this->hasOne(TeaHourse::class, ['id' => 'hourse_id'])->select(['title AS hourse_name'])->asArray();
    }

    public function getCoupon(): \yii\db\ActiveQuery
    {
        return $this->hasOne(TeaCoupon::class, ['id' => 'coupon_id'])->select(['name AS coupon_name'])->asArray();
    }
}
