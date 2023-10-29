<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 03:34:18
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-16 19:19:21
 */


namespace common\plugins\diandi_hub\models\order;

use common\plugins\diandi_hub\models\express\HubExpressCompany;
use common\helpers\HashidsHelper;
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
class HubOrder extends \yii\db\ActiveRecord
{
    public $goodsinfo;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_order}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['total_price', 'pay_price', 'express_price'], 'number'],
            [['pay_status', 'pay_time', 'delivery_status', 'receipt_status', 'receipt_time', 'order_status','bloc_id','store_id', 'user_id', 'wxapp_id', 'create_time', 'update_time','order_type','is_money','is_rebate','pay_type','express_type','is_split'], 'integer'],
            [['order_no'], 'string', 'max' => 20],
            [['express_company', 'express_no', 'delivery_time','parent_order_no'], 'string', 'max' => 50],
            [['remark','order_body','print_id','store_codenum'], 'string', 'max' => 100],
            [['transaction_id'], 'string', 'max' => 30],
            [['order_no'], 'unique'],
        ];
    }

     /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            empty($this->promo_code) && HubOrder::updateAll(['store_codenum' => HashidsHelper::encode($this->order_id)], ['order_id' => $this->order_id]);
        }
        parent::afterSave($insert, $changedAttributes);
    }


    /**
     * 行为
     */
    public function behaviors()
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

    public function getGoods()
    {
        return $this->hasMany(HubBaseOrderGoods::class, ['order_id' => 'order_id'])->select(["order_goods_id","bloc_id","store_id","goods_type","goods_id","goods_name","thumb","stock_up","deduct_stock_type","spec_type","spec_sku_id","goods_spec_id","goods_attr","goods_no","performance","goods_price","line_price","goods_weight","total_num","total_price","order_id","user_id","wxapp_id","remark","goods_costprice","is_rebate"]);
    }

    public function getAddress(){
        return $this->hasOne(HubOrderAddress::class, ['order_id' => 'order_id']);
        
    }

    public function getStore(){
        return $this->hasOne(BlocStore::class, ['store_id' => 'store_id']);
        
    }

    
    public function getExpress(){
        return $this->hasOne(HubExpressCompany::class, ['code' => 'express_company']);
        
    }

    public function getRefund(){
        return $this->hasOne(HubRefundOrder::class, ['order_id' => 'order_id']);
    }

    
    public function getRefundLog(){
        return $this->hasMany(HubRefundLog::class, ['order_id' => 'order_id']);
    }

    

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'order_id' => '订单id',
            'order_no' => '订单编号',
            'total_price' => '订单总价',
            'pay_price' => '支付金额',
            'pay_status' => '支付状态',
            'pay_time' => '支付时间',
            'is_split' => '是否是分订单',
            'express_type'=>'配送方式',
            'express_price' => '快递费',
            'express_company' => '快递公司',
            'express_no' => '快递编号',
            'delivery_status' => '发货状态',
            'delivery_time' => '发货时间',
            'receipt_status' => '收货状态',
            'receipt_time' => '收货时间',
            'order_status' => '订单状态',
            'transaction_id' => '微信单号',
            'user_id' => '会员ID',
            'pay_type'=>'支付方式',
            'store_codenum'=>'提货码',
            'remark'=>'订单备注',
            'print_id'=>'打印订单号',
            'wxapp_id' => 'Wxapp ID',
            'is_money'=>'是否解冻',
            'is_rebate'=>'是否返利',
            'create_time' => '下单时间',
            'update_time' => '更新时间',
            'order_type'=>'订单类型'
        ];
    }
}
