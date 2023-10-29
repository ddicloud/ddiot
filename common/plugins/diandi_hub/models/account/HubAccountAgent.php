<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-01 20:56:47
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-11 20:47:09
 */
 

namespace common\plugins\diandi_hub\models\account;

use Yii;

/**
 * This is the model class for table "{{%diandi_hub_account_agent}}".
 *
 * @public int $id
 * @public int|null $order_id 订单id
 * @public int|null $member_id 会员id
 * @public int|null $bloc_id 公司id
 * @public int|null $city_mid 城市代理
 * @public int|null $area_mid 区县代理
 * @public int|null $provice_mid 省份代理
 * @public int|null $city_radio 城市比例
 * @public int|null $area_radio 区县比例
 * @public int|null $provice_radio 省份比例
 * @public int|null $goods_id 商品id
 * @public float|null $order_price 订单价格
 * @public int|null $spec_id 商品规格
 * @public float|null $spec_price 规格价格
 * @public float|null $goods_price 商品价格
 * @public int|null $update_time 创建时间
 * @public int|null $create_time 更新时间
 */
class HubAccountAgent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_account_agent}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['order_id', 'member_id', 'bloc_id', 'city_mid', 'area_mid', 'provice_mid', 'city_radio', 'area_radio', 'provice_radio', 'goods_id', 'spec_id', 'update_time', 'create_time','order_goods_id'], 'integer'],
            [['order_price', 'spec_price', 'goods_price'], 'number'],
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
            'order_id' => '订单id',
            'member_id' => '会员id',
            'bloc_id' => '公司id',
            'performance'=> '礼包业绩',
            'city_mid' => '城市代理',
            'area_mid' => '区县代理',
            'provice_mid' => '省份代理',
            'city_radio' => '城市比例',
            'area_radio' => '区县比例',
            'provice_radio' => '省份比例',
            'goods_id' => '商品id',
            'order_price' => '订单价格',
            'spec_id' => '商品规格',
            'spec_price' => '规格价格',
            'goods_price' => '商品价格',
            'update_time' => '创建时间',
            'create_time' => '更新时间',
        ];
    }
}
