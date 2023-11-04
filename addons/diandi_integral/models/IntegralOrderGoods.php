<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 05:43:35
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-15 16:50:38
 */


namespace addons\diandi_integral\models;

use Yii;

/**
 * This is the model class for table "dd_order_goods".
 *
 * @public int $order_goods_id
 * @public int $goods_id
 * @public string $goods_name
 * @public int $image_id
 * @public int $deduct_stock_type
 * @public int $spec_type
 * @public string $spec_sku_id
 * @public int $goods_spec_id
 * @public string $goods_attr
 * @public string $content
 * @public string $goods_no
 * @public float $goods_price
 * @public float $goods_weight
 * @public int $total_num
 * @public float $total_price
 * @public int $order_id
 * @public int $user_id
 * @public int $wxapp_id
 * @public int $create_time
 */
class IntegralOrderGoods extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%diandi_integral_order_goods}}';
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

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['goods_id','bloc_id','store_id', 'goods_integral', 'deduct_stock_type', 'spec_type', 'goods_spec_id', 'total_num', 'order_id', 'user_id', 'exchange_status', 'create_time'], 'integer'],
            [['content', 'thumb'], 'required'],
            [['goods_no', 'content', 'thumb'], 'string'],
            [['goods_price', 'stock_up', 'goods_weight', 'total_price'], 'number'],
            [['goods_name', 'spec_sku_id'], 'string', 'max' => 255],
            [['goods_attr'], 'string', 'max' => 500],
            // [['goods_no'], 'string', 'max' => 100],
        ];
    }

    
    public function getOrder(): \yii\db\ActiveQuery
    {
        return $this->hasOne(IntegralOrder::class, ['order_id' => 'order_id']);
    }

    public function getAddress(): \yii\db\ActiveQuery
    {
        return $this->hasOne(IntegralOrderAddress::class, ['order_id' => 'order_id']);
        
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'order_goods_id' => '订单商品ID',
            'goods_id' => '商品ID',
            'goods_name' => '商品名称',
            'thumb' => '商品图片',
            'deduct_stock_type' => 'Deduct Stock Type',
            'spec_type' => 'Spec Type',
            'spec_sku_id' => 'Spec Sku ID',
            'goods_spec_id' => 'Goods Spec ID',
            'goods_attr' => 'Goods Attr',
            'content' => '商品介绍',
            'goods_no' => '商品编码',
            'goods_price' => '销售价格',
            'goods_integral' => '兑换积分',
            'goods_weight' => '商品重量',
            'total_num' => '下单数量',
            'total_price' => '总价格',
            'order_id' => '订单ID',
            'user_id' => '用户id',
            'stock_up' => '库存处理状态',
            'exchange_status' => '积分扣除状态',
            'create_time' => 'Create Time',
        ];
    }
}
