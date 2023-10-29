<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-20 13:42:52
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-10 14:23:59
 */


namespace common\plugins\diandi_hub\models\order;

use common\plugins\diandi_hub\models\goods\HubGoodsBaseGoods;
use common\plugins\diandi_hub\models\goods\HubGoodsBaseSpec;
use common\plugins\diandi_hub\models\goods\HubGoodsSpec;
use diandi\addons\models\BlocStore;
use Yii;

/**
 * This is the model class for table "dd_diandi_hub_cart".
 *
 * @public int $id
 * @public int|null $user_id 用户id
 * @public int|null $goods_id 商品id
 * @public int|null $spec_id 规格组合id
 * @public int|null $number 数量
 * @public int|null $create_time 创建时间
 */
class HubDiandiShopCart extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_cart}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['user_id','bloc_id','store_id', 'goods_id', 'number', 'create_time'], 'integer'],
            [['spec_id', 'spec_val'], 'string'],
            [['total_price','goods_price','line_price'], 'number'],
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
            ],
        ];
    }

    /* 获取分类 */
    public function getGoods()
    {
        return $this->hasOne(HubGoodsBaseGoods::class, ['goods_id' => 'goods_id'])->select(['goods_id','spec_type', 'goods_sort', 'goods_status', 'bloc_id', 'store_id', 'express_type','goods_type','express_template_id','images', 'thumb', 'line_price', 'stock',
        'sales_initial','goods_name', 'label','deduct_stock_type','goods_price', 'browse','goods_costprice' ,'goods_weight', 'delivery_id','volume',
       'exemption', 'exemption_type','category_pid']);
    }

    /* 获取分类 */
    public function getGoodsSpec()
    {
        return $this->hasOne(HubGoodsBaseSpec::class, ['spec_sku_id' => 'spec_id']);
    }

    public function getStore()
    {
        return $this->hasOne(BlocStore::class, ['store_id' => 'store_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户id',
            'goods_id' => '商品id',
            'spec_id' => '规格组合id',
            'spec_val' => '规格组合',
            'number' => '数量',
            'create_time' => '创建时间',
        ];
    }
}
