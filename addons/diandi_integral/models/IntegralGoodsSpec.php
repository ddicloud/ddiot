<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-03 19:48:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-14 18:21:10
 */


namespace addons\diandi_integral\models;

use Yii;
use addons\diandi_integral\models\IntegralGoodsSpecRel;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "dd_goods_spec".
 *
 * @public int $goods_spec_id
 * @public int $goods_id
 * @public string $goods_no
 * @public float $goods_price
 * @public float $line_price
 * @public int $stock_num
 * @public int $goods_sales
 * @public float $goods_weight
 * @public int $wxapp_id
 * @public string $spec_sku_id
 * @public int $create_time
 * @public int $update_time
 */
class IntegralGoodsSpec extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%diandi_integral_goods_spec}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['goods_id','bloc_id','store_id', 'stock_num', 'goods_sales', 'create_time', 'update_time'], 'integer'],
            [['goods_price', 'line_price', 'goods_weight', 'goods_costprice'], 'number'],
            [['goods_no', 'spec_item_thumb'], 'string', 'max' => 100],
            [['spec_sku_id'], 'string', 'max' => 255],
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
            ],
        ];
    }


    public function getGoodsSpecRel(): \yii\db\ActiveQuery
    {
        return $this->hasOne(IntegralGoodsSpecRel::class, ['id' => 'spec_sku_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'goods_spec_id' => 'Goods Spec ID',
            'goods_id' => 'Goods ID',
            'goods_no' => 'Goods No',
            'goods_price' => 'Goods Price',
            'line_price' => 'Line Price',
            'stock_num' => 'Stock Num',
            'goods_sales' => 'Goods Sales',
            'goods_weight' => 'Goods Weight',
            'wxapp_id' => 'Wxapp ID',
            'spec_sku_id' => 'Spec Sku ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'goods_costprice' => '成本价格'
        ];
    }
}
