<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-01 20:57:16
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-12 13:08:29
 */
 

namespace common\plugins\diandi_hub\models\account;

use common\plugins\diandi_hub\models\goods\HubGoodsBaseGoods;
use common\plugins\diandi_hub\models\order\HubBaseOrderGoods;
use common\plugins\diandi_hub\models\order\HubOrder;
use common\plugins\diandi_hub\models\order\HubOrderGoods;
use common\models\DdMember;
use common\models\DdUser;
use Yii;

/**
 * This is the model class for table "{{%diandi_hub_account_log}}".
 *
 * @public int $id
 * @public int|null $member_id 会员id
 * @public int|null $type 资金变化类型
 * @public int|null $order_type 订单类型
 * @public int|null $goods_type 商品类型
 * @public int|null $order_id 订单id
 * @public float|null $order_price 订单价格
 * @public int|null $goods_id 商品id
 * @public float|null $goods_price 商品价格
 * @public int|null $update_time 创建时间
 * @public int|null $create_time 更新时间
 */
class HubAccountLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_account_log}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['member_id', 'change_type', 'order_type', 'goods_type', 'store_order_id', 'order_id', 'goods_id', 'update_time', 'create_time',
            'account_type',
            'order_goods_id','is_add'], 'integer'],
            [['remark'], 'string', 'max' => 50],
            [['order_price','performance','money', 'goods_price'], 'number'],
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

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (empty($this->is_refund)) {
                //字段
                $this->is_refund = 0;
            }
            return true;
        } else {
            return false;
        }
    }
    
    

    


    public function getGoods()
    {
        return $this->hasOne(HubGoodsBaseGoods::class,['goods_id'=>'goods_id']);
    }

    
    public function getOrdergoods()
    {
        return $this->hasOne(HubBaseOrderGoods::class,['order_goods_id'=>'order_goods_id']);
    }


    public function getOrder()
    {
        return $this->hasOne(HubOrder::class,['order_id'=>'order_id']);
    }

    public function getStoreOrder()
    {
        return $this->hasOne(HubAccountStorePay::class,['id'=>'store_order_id']);
    }

    public function getMember()
    {
        // return $this->hasOne(DdMember::class,['member_id'=>'member_id']);
        return $this->hasOne(DdUser::class,['id'=>'member_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => '会员id',
            'change_type' => '资金变化类型',
            'order_type' => '订单类型',
            'money'=>'金额',
            'goods_type' => '商品类型',
            'order_id' => '订单id',
            'performance'=> '礼包业绩',//礼包专用
            'account_type'=> '资金类型',
            'type'=> '资金变化类型',
            'order_price' => '订单价格',
            'store_order_id'=>'到店订单id',
            'goods_id' => '商品id',
            'goods_price' => '商品价格',
            'is_refund'   =>'是否退款',
            'update_time' => '创建时间',
            'create_time' => '更新时间',
        ];
    }
}
