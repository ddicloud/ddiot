<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 05:43:35
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-28 15:31:25
 */


namespace common\plugins\diandi_hub\models\order;

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
 * @public float $line_price
 * @public float $goods_weight
 * @public int $total_num
 * @public float $total_price
 * @public int $order_id
 * @public int $user_id
 * @public int $wxapp_id
 * @public int $create_time
 */
class HubBaseOrderGoods extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_order_goods}}';
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

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['goods_id','bloc_id','store_id',  'deduct_stock_type', 'spec_type', 'goods_spec_id', 'total_num', 'order_id', 'user_id', 'wxapp_id', 'create_time','goods_type'], 'integer'],
            [['content', 'thumb'], 'required'],
            [['goods_no', 'content', 'thumb'], 'string'],
            [['goods_price', 'line_price', 'stock_up', 'goods_weight', 'total_price','goods_costprice'], 'number'],
            [['goods_name', 'spec_sku_id'], 'string', 'max' => 255],
            [['goods_attr'], 'string', 'max' => 500],
            // [['goods_no'], 'string', 'max' => 100],
        ];
    }

    
    
    public function getOrder()
    {
        return $this->hasOne(HubOrder::class, ['order_id' => 'order_id']);
    }

    public function getAddress(){
        return $this->hasOne(HubOrderAddress::class, ['order_id' => 'order_id']);
        
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
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
            'line_price' => '市场价格',
            'goods_weight' => '商品重量',
            'total_num' => '下单数量',
            'total_price' => '总价格',
            'goods_costprice'=> '成本价',
            'order_id' => '订单ID',
            'user_id' => '用户id',
            'stock_up' => '库存处理状态',
            'wxapp_id' => 'Wxapp ID',
            'create_time' => 'Create Time',
        ];
    }
}
