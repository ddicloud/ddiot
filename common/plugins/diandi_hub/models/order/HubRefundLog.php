<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-11 05:03:39
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-19 12:10:42
 */
 

namespace common\plugins\diandi_hub\models\order;

use Yii;

/**
 * This is the model class for table "{{%diandi_hub_refund_log}}".
 *
 * @public int $id
 * @public int|null $order_id 订单
 * @public int $refund_id 售后订单
 * @public float $money 退款金额
 * @public int|null $old_refund_status 之前的退款状态
 * @public int|null $old_status 之前的售后状态
 * @public int $type 售后类型
 * @public int $refund_status 退款状态:0申请退款1退款驳回,2退款中3已退款
 * @public int|null $status 售后状态:0申请1拒绝售后2处理中3已处理4已完结
 * @public string $remark 处理意见
 * @public int $member_id 申请人
 * @public string|null $refund_username 处理人
 * @public string|null $user_remark 用户对处理的反馈
 * @public int|null $create_time
 * @public int|null $update_time
 */
class HubRefundLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_refund_log}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['bloc_id','store_id','order_id', 'refund_id', 'old_refund_status', 'old_status', 'type', 'refund_status', 'status', 'member_id', 'create_time', 'update_time'], 'integer'],
            [['refund_id', 'money', 'type', 'refund_status', 'remark', 'member_id'], 'required'],
            [['money'], 'number'],
            [['remark', 'user_remark'], 'string', 'max' => 100],
            [['refund_username'], 'string', 'max' => 30],
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
                'class' => \common\behaviors\SaveBehavior::class,
                'updatedAttribute' => 'update_time',
                'createdAttribute' => 'create_time',
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
            'order_id' => '订单',
            'refund_id' => '售后订单',
            'money' => '退款金额',
            'old_refund_status' => '之前的退款状态',
            'old_status' => '之前的售后状态',
            'type' => '售后类型',
            'refund_status' => '退款状态:0申请退款1退款驳回,2退款中3已退款',
            'status' => '售后状态:0申请1拒绝售后2处理中3已处理4已完结',
            'remark' => '处理意见',
            'member_id' => '申请人',
            'refund_username' => '处理人',
            'user_remark' => '用户对处理的反馈',
            'create_time' => '处理时间',
            'update_time' => '最后处理时间',
        ];
    }
}
