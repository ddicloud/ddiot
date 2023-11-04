<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 03:34:18
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-06-19 10:18:06
 */


namespace addons\diandi_integral\models;

use diandi\addons\models\BlocStore;
use Yii;

/**
 * This is the model class for table "dd_order".
 *
 * @public int $order_id
 * @public string $order_no
 * @public float $total_price
 * @public float $pay_price
 * @public int $pay_status
 * @public int $pay_time
 * @public float $express_price
 * @public string $express_company
 * @public string $express_no
 * @public int $delivery_status
 * @public int $delivery_time
 * @public int $receipt_status
 * @public int $receipt_time
 * @public int $order_status
 * @public string $transaction_id
 * @public int $user_id
 * @public int $wxapp_id
 * @public int $create_time
 * @public int $update_time
 */
class IntegralOrder extends \yii\db\ActiveRecord
{
    public array $goodsinfo = [];
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%diandi_integral_order}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['total_price', 'pay_price', 'express_price','pay_integral'], 'number'],
            [['pay_status', 'pay_time', 'delivery_status', 'receipt_status', 'receipt_time', 'order_status','bloc_id','store_id', 'user_id', 'wxapp_id', 'create_time', 'update_time','order_type','is_money'], 'integer'],
            [['order_no'], 'string', 'max' => 20],
            [['express_company', 'express_no', 'delivery_time'], 'string', 'max' => 50],
            [['remark','order_body','print_id'], 'string', 'max' => 100],
            [['transaction_id'], 'string', 'max' => 30],
            [['order_no'], 'unique'],
        ];
    }

    /**
     * 行为
     */
    public function behaviors(): array
    {
        /*自动添加创建和修改时间*/
        return [
            [
                'class' => \common\behaviors\SaveBehavior::class,
                'updatedAttribute' => 'create_time',
                'createdAttribute' => 'update_time',
            ]
        ];
    }

    public function getGoods(): \yii\db\ActiveQuery
    {
        return $this->hasMany(IntegralOrderGoods::class, ['order_id' => 'order_id'])->asArray();
    }

    public function getAddress(): \yii\db\ActiveQuery
    {
        return $this->hasOne(IntegralOrderAddress::class, ['order_id' => 'order_id'])->asArray();
        
    }


    public function getStore(): \yii\db\ActiveQuery
    {
    
        return $this->hasOne(BlocStore::class, ['store_id' => 'store_id']);
        
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'order_id' => '订单id',
            'order_no' => '订单编号',
            'total_price' => '订单总价',
            'pay_price' => '支付金额',
            'pay_status' => '支付状态',
            'pay_time' => '支付时间',
            'express_price' => '快递费',
            'express_company' => '快递公司',
            'express_no' => '快递编号',
            'delivery_status' => '发货状态',
            'delivery_time' => '发货手机',
            'receipt_status' => '收货状态',
            'receipt_time' => '收货时间',
            'order_status' => '订单状态',
            'transaction_id' => '微信单号',
            'user_id' => '会员ID',
            'remark'=>'订单备注',
            'print_id'=>'打印订单号',
            'wxapp_id' => 'Wxapp ID',
            'create_time' => '下单时间',
            'update_time' => '更新时间',
            'order_type'=>'订单类型'
        ];
    }
}
