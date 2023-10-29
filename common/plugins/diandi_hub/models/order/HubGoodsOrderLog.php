<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-04 22:45:44
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-22 17:38:55
 */
 

namespace common\plugins\diandi_hub\models\order;

use Yii;

/**
 * This is the model class for table "dd_diandi_hub_goods_order_log".
 *
 * @public int $id
 * @public int|null $order_id 订单id
 * @public int|null $bloc_id 公司ID
 * @public int|null $store_id 商户ID
 * @public int|null $goods_id 商品ID
 * @public int|null $goods_spec_id 属性id
 * @public int|null $levelnum 分销商等级
 * @public int|null $dislevel 分销等级
 * @public float|null $member_price 会员价
 * @public int|null $user_id 用户id
 * @public float|null $money 分销参数
 * @public float|null $price1 价格1
 * @public float|null $price2 价格2
 * @public float|null $price3 价格3
 * @public float|null $price4 价格4
 * @public float|null $price5 价格5
 * @public float|null $price6 价格6
 * @public int|null $create_time 创建时间
 * @public int|null $update_time 更新时间
 */
class HubGoodsOrderLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dd_diandi_hub_goods_order_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['order_id', 'bloc_id', 'store_id', 'goods_id', 'goods_spec_id', 'levelnum', 'dislevel', 'user_id', 'create_time', 'update_time'], 'integer'],
            [['member_price', 'money', 'price1', 'price2', 'price3', 'price4', 'price5', 'price6'], 'number'],
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
            'bloc_id' => '公司ID',
            'store_id' => '商户ID',
            'goods_id' => '商品ID',
            'goods_spec_id' => '属性id',
            'levelnum' => '分销商等级',
            'dislevel' => '分销等级',
            'member_price' => '会员价',
            'user_id' => '用户id',
            'money' => '分销参数',
            'price1' => '价格1',
            'price2' => '价格2',
            'price3' => '价格3',
            'price4' => '价格4',
            'price5' => '价格5',
            'price6' => '价格6',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}
