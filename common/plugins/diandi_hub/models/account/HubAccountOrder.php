<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-01 20:57:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-01 19:08:32
 */
 

namespace common\plugins\diandi_hub\models\account;

use common\plugins\diandi_hub\models\goods\HubGoodsBaseGoods;
use common\plugins\diandi_hub\models\goods\HubGoodsBaseSpec;
use common\plugins\diandi_hub\models\goods\HubGoodsBaseSpecRel;
use common\plugins\diandi_hub\models\goods\HubGoodsBaseLabel;
use common\plugins\diandi_hub\models\goods\HubGoodsSubsidy;
use common\plugins\diandi_hub\models\level\HubLevel;
use common\plugins\diandi_hub\models\member\HubMemberLevel;
use common\plugins\diandi_hub\models\order\HubBaseOrderGoods;
use common\plugins\diandi_hub\models\order\HubOrder;
use common\models\DdMember;
use common\models\DdUser;
use Yii;

/**
 * This is the model class for table "{{%diandi_hub_account_order}}".
 *
 * @public int $id
 * @public int|null $member_id 会员id
 * @public int|null $type 分佣类型0分销佣金1等级佣金2团队佣金3区域经理佣金
 * @public int|null $order_type 订单类型
 * @public int|null $goods_type 商品类型
 * @public int|null $order_id 订单id
 * @public float|null $order_price 订单价格
 * @public int|null $goods_id 商品id
 * @public float|null $goods_price 商品价格
 * @public int|null $update_time 创建时间
 * @public int|null $create_time 更新时间
 */
class HubAccountOrder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_account_order}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [[
                'member_id','member_level', 'type', 'order_type', 'goods_type', 'goods_id', 'update_time', 'create_time','order_goods_id','status',
                'memberc_id','memberc_level',
                'order_id','store_order_id',
            'is_count','is_refund','account_log_id'], 'integer'],
            [['order_price', 'goods_price','money','performance'], 'number'],
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
    


      /**
     *  订单关联的商品
     * @return void
     */
    public function getGoods()
    {
        return $this->hasOne(HubGoodsBaseGoods::class, ['goods_id' => 'goods_id']);
    }

    
    /**
     *  订单关联的商品
     * @return void
     */
    public function getOrder()
    {
        return $this->hasOne(HubOrder::class, ['order_id' => 'order_id']);
    }

    /**
     *  订单关联的到店订单
     * @return void
     */
    public function getStoreOrder()
    {
        return $this->hasOne(HubAccountStorePay::class, ['id' => 'store_order_id']);
    }

    /**
     *  订单关联的商品
     * @return void
     */
    public function getGoodsSpec()
    {
        return $this->hasMany(HubGoodsBaseSpec::class, ['goods_id' => 'goods_id']);
    }
    

    
    /**
     *  订单关联的商品属性值
     * @return void
     */
    public function getGoodsSpecRel()
    {
        return $this->hasMany(HubGoodsBaseSpecRel::class, ['goods_id' => 'goods_id']);
    }


     /**
     *  订单关联的商品分享信息
     * @return void
     */
    public function getGoodsShare()
    {
        return $this->hasOne(HubGoodsSubsidy::class, ['goods_id' => 'goods_id']);
    }
    
     /**
     *  订单关联的商品与订单关联表
     * @return void
     */
    public function getOrderGoods()
    {
        return $this->hasOne(HubBaseOrderGoods::class, ['order_goods_id' => 'order_goods_id'])->select(["order_goods_id","bloc_id","store_id","goods_type","goods_id","goods_name","thumb","stock_up","deduct_stock_type","spec_type","spec_sku_id","goods_spec_id","goods_attr","goods_no","performance","goods_price","line_price","goods_weight","total_num","total_price","order_id","user_id","wxapp_id","remark","goods_costprice","is_rebate"]);
    }


    public function getMemberc()
    {
        return $this->hasOne(DdUser::class, ['id' => 'memberc_id']);
    }

    
    public function getMember()
    {
        return $this->hasOne(DdUser::class, ['id' => 'member_id']);
    }
    
    public function getMembercLevel()
    {
        return $this->hasOne(HubMemberLevel::class, ['level_num' => 'memberc_level']);
    }

    
    public function getMemberLevel()
    {
        return $this->hasOne(HubMemberLevel::class, ['level_num' => 'member_level']);
    }
    

    public function getLevelc()
    {
        return $this->hasOne(HubLevel::class, ['levelnum' => 'memberc_level']);
    }

    
    public function getLevel()
    {
        return $this->hasOne(HubLevel::class, ['levelnum' => 'member_level']);
    }
    
    

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'money'=>'收益金额',
            'account_log_id'=>'资金日志记录ID',
            'member_id' => '下单人id',
            'store_order_id'=> '到店订单ID',
            'memberc_id' => '受益人id',
            'memberc_level' => '受益人等级',
            'member_level' => '我的等级',
            'performance'=> '礼包业绩',
            'type' => '分佣类型0分销佣金1等级佣金2团队佣金3区域经理佣金',
            'order_type' => '订单类型',
            'goods_type' => '商品类型',
            'order_id' => '订单id',
            'order_price' => '订单价格',
            'goods_id' => '商品id',
            'goods_price' => '商品价格',
            'is_refund' => '是否退款',
            'update_time' => '创建时间',
            'create_time' => '更新时间',
        ];
    }
}
