<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-07-30 16:39:24
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-11-04 23:13:40
 */
 

namespace common\plugins\diandi_hub\models\money;

use Yii;

/**
 * This is the model class for table "dd_diandi_hub_money_log".
 *
 * @public int $id
 * @public int|null $order_id 订单ID
 * @public int|null $levelnum 会员等级
 * @public int|null $member_id 会员id
 * @public float|null $order_money 分销金额参数
 * @public float|null $money 分销金额
 * @public int|null $bloc_id
 * @public int|null $store_id
 * @public int|null $create_time
 * @public int|null $update_time
 */
class HubMoneyLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dd_diandi_hub_money_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['order_id','goods_id','goods_spec_id','levelnum', 'member_id', 'bloc_id', 'store_id', 'create_time', 'update_time'], 'integer'],
            [['order_money', 'money'], 'number'],
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

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => '订单ID',
            'goods_id'=>'商品id',
            'goods_spec_id'=>'商品属性id',
            'levelnum' => '会员等级',
            'member_id' => '会员id',
            'order_money' => '分销金额参数',
            'money' => '分销金额',
            'bloc_id' => 'Bloc ID',
            'store_id' => 'Store ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
