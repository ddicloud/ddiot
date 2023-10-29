<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-11 00:57:28
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-07-26 18:52:02
 */


namespace common\plugins\diandi_hub\models\order;

use Yii;

/**
 * This is the model class for table "{{%diandi_hub_refund_order}}".
 *
 * @public int $id
 * @public int|null $order_id 订单
 * @public int $reason_id 售后理由
 * @public int|null $transaction_id 微信支付单号
 * @public string|null $refund_code 退款单号
 * @public float $money 退款金额
 * @public int $type 售后类型
 * @public int $refund_status 退款状态:0申请退款1退款驳回,2退款中3已退款
 * @public int|null $status 售后状态:0申请1拒绝售后2处理中3已处理4已完结
 * @public string $remark 退款理由
 * @public int $member_id 申请人
 * @public string|null $thumbs 图片说明
 * @public string $linkman 联系人
 * @public string $mobile 联系电话
 * @public int|null $goods_id 商品id
 * @public int|null $create_time
 * @public int|null $update_time
 */
class HubRefundOrder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_refund_order}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['bloc_id', 'store_id', 'order_id', 'reason_id', 'transaction_id', 'type', 'refund_status', 'status', 'member_id', 'create_time', 'update_time', 'order_status'], 'integer'],
            [['reason_id', 'goods_id', 'money', 'type', 'refund_status', 'remark', 'member_id', 'linkman', 'mobile'], 'required'],
            [['money'], 'number'],
            [['thumbs'], 'string'],
            [['refund_code', 'linkman', 'mobile'], 'string', 'max' => 30],
            [['remark'], 'string', 'max' => 100],
        ];
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            if (is_array($this->thumbs)) {
                $this->thumbs = implode(',', $this->thumbs);
            }

            return true;
        } else {
            return false;
        }
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (is_array($this->thumbs)) {
                //字段
                $this->thumbs = implode(',', $this->thumbs);
            }
            return true;
        } else {
            return false;
        }
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

    public function getOrder()
    {
        return $this->hasOne(HubOrder::class, ['order_id' => 'order_id']);
    }

    public function getOrderGoods()
    {
        return $this->hasMany(HubOrderGoods::class, ['order_id' => 'order_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => '订单',
            'reason_id' => '售后理由',
            'transaction_id' => '微信支付单号',
            'refund_code' => '退款单号',
            'money' => '退款金额',
            'type' => '售后类型',
            'refund_status' => '退款状态:0申请退款1退款驳回,2退款中3已退款',
            'status' => '售后状态:0申请1拒绝售后2处理中3已处理4已完结',
            'remark' => '退款理由',
            'member_id' => '申请人',
            'thumbs' => '图片说明',
            'linkman' => '联系人',
            'mobile' => '联系电话',
            'goods_id' => '商品id',
            'create_time' => '申请时间',
            'update_time' => '最后处理时间',
            'order_status' => '订单状态',
        ];
    }
}
