<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-19 21:20:48
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-19 22:41:28
 */
 

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%pay_refund_log}}".
 *
 * @property int $id
 * @property string|null $return_code
 * @property string|null $out_refund_no 商户退款单号
 * @property string|null $out_trade_no 商户订单号 
 * @property string|null $refund_account 退款资金来源
 * @property float|null $refund_fee 申请退款金额 
 * @property string|null $refund_id 微信退款单号
 * @property float $refund_recv_accout 支付用户零钱
 * @property string $refund_request_source 退款发起来源
 * @property string|null $refund_status 退款状态
 * @property string|null $module 模块标识
 * @property string|null $settlement_refund_fee 退款金额 
 * @property float $settlement_total_fee 应结订单金额
 * @property string|null $success_time 退款成功时间
 * @property float $total_fee 订单金额 
 * @property string|null $transaction_id 微信订单号
 * @property int|null $member_id 用户id
 * @property int|null $create_time 创建时间
 * @property int|null $update_time 更新时间
 * @property int|null $bloc_id 公司ID
 * @property int|null $store_id 商户ID
 */
class PayRefundLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%pay_refund_log}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['refund_fee', 'refund_recv_accout', 'settlement_total_fee', 'total_fee'], 'number'],
            [['refund_recv_accout', 'settlement_total_fee', 'total_fee', 'module'], 'required'],
            [['member_id', 'create_time', 'update_time', 'bloc_id', 'store_id'], 'integer'],
            [['return_code', 'out_refund_no', 'out_trade_no', 'refund_account', 'refund_id', 'transaction_id'], 'string', 'max' => 50],
            [['refund_request_source', 'refund_status', 'settlement_refund_fee'], 'string', 'max' => 255],
            [['success_time'], 'string', 'max' => 100],
        ];
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            if (!is_numeric($this->refund_recv_accout)) {
                $this->refund_recv_accout = 0;
            }
            if (!is_numeric($this->settlement_total_fee)) {
                $this->settlement_total_fee = 0;
            }
            if (!is_numeric($this->total_fee)) {
                $this->total_fee = 0;
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
                'class' => \common\behaviors\SaveBehavior::className(),
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
            'return_code' => 'Return Code',
            'out_refund_no' => '商户退款单号',
            'out_trade_no' => '商户订单号 ',
            'refund_account' => '退款资金来源',
            'refund_fee' => '申请退款金额 ',
            'refund_id' => '微信退款单号',
            'refund_recv_accout' => '支付用户零钱',
            'refund_request_source' => '退款发起来源',
            'refund_status' => '退款状态',
            'module' => '模块标识',
            'settlement_refund_fee' => '退款金额 ',
            'settlement_total_fee' => '应结订单金额',
            'success_time' => '退款成功时间',
            'total_fee' => '订单金额 ',
            'transaction_id' => '微信订单号',
            'member_id' => '用户id',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
            'bloc_id' => '公司ID',
            'store_id' => '商户ID',
        ];
    }
}
