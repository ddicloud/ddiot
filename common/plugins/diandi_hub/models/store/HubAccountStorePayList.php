<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-14 13:13:34
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-14 13:19:33
 */
 

namespace common\plugins\diandi_hub\models\store;

use Yii;

/**
 * This is the model class for table "{{%diandi_hub_account_store_pay_list}}".
 *
 * @public int $id
 * @public string $order_id 订单ID
 * @public string|null $name 收费项
 * @public int $goods_id 商品id
 * @public float|null $goods_price 商品价格
 * @public int $goods_num 商品数量
 * @public int|null $update_time 创建时间
 * @public int|null $create_time 更新时间
 */
class HubAccountStorePayList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_account_store_pay_list}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['order_id', 'goods_id', 'goods_num'], 'required'],
            [['goods_id', 'goods_num', 'update_time', 'create_time','store_id','bloc_id','member_store_id'], 'integer'],
            [['goods_price'], 'number'],
            [['order_id'], 'string', 'max' => 30],
            [['name'], 'string', 'max' => 11],
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
            'order_id' => '订单ID',
            'name' => '收费项',
            'goods_id' => '商品id',
            'goods_price' => '商品价格',
            'goods_num' => '商品数量',
            'update_time' => '创建时间',
            'create_time' => '更新时间',
        ];
    }
}
