<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-01 20:57:04
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-01 20:57:04
 */
 

namespace common\plugins\diandi_hub\models\account;

use Yii;

/**
 * This is the model class for table "{{%diandi_hub_account_goods}}".
 *
 * @public int $id
 * @public int|null $order_id 订单id
 * @public int|null $member_id 下单人
 * @public int|null $self_level 我的等级
 * @public int|null $store_id 商户的
 * @public int|null $bloc_id 公司id
 * @public int $goods_id 商品id
 * @public string $goods_no 商品编码
 * @public float $goods_price 销售价格
 * @public float $line_price 市场价格
 * @public int|null $type 分佣类型
 * @public float|null $money
 * @public int|null $dislevel 佣金
 * @public string $spec_sku_str 商品规格
 * @public float|null $goods_costprice 成本价格
 * @public int|null $levelnum
 * @public float|null $price6
 * @public float|null $price5
 * @public float|null $price4
 * @public float|null $price3
 * @public float|null $price2
 * @public float|null $price1
 * @public string|null $row_col_levelnum
 * @public int $create_time
 * @public int $update_time
 */
class HubAccountGoods extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_account_goods}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['order_id', 'member_id', 'self_level', 'store_id', 'bloc_id', 'goods_id', 'type', 'dislevel', 'levelnum', 'create_time', 'update_time'], 'integer'],
            [['goods_price', 'line_price', 'money', 'goods_costprice', 'price6', 'price5', 'price4', 'price3', 'price2', 'price1','order_goods_id'], 'number'],
            [['goods_no'], 'string', 'max' => 100],
            [['spec_sku_str'], 'string', 'max' => 255],
            [['row_col_levelnum'], 'string', 'max' => 50],
            [['row_col_levelnum', 'goods_id'], 'unique', 'targetAttribute' => ['row_col_levelnum', 'goods_id']],
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
            'member_id' => '下单人',
            'self_level' => '我的等级',
            'store_id' => '商户的',
            'bloc_id' => '公司id',
            'goods_id' => '商品id',
            'goods_no' => '商品编码',
            'goods_price' => '销售价格',
            'line_price' => '市场价格',
            'type' => '分佣类型',
            'money' => 'Money',
            'dislevel' => '佣金',
            'spec_sku_str' => '商品规格',
            'goods_costprice' => '成本价格',
            'levelnum' => 'Levelnum',
            'price6' => 'Price6',
            'price5' => 'Price5',
            'price4' => 'Price4',
            'price3' => 'Price3',
            'price2' => 'Price2',
            'price1' => 'Price1',
            'row_col_levelnum' => 'Row Col Levelnum',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
