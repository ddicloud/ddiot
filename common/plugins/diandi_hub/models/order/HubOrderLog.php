<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-30 00:23:08
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-11-12 00:37:43
 */

namespace common\plugins\diandi_hub\models\order;

use common\plugins\diandi_hub\models\money\HubPriceConf;

/**
 * This is the model class for table "dd_diandi_hub_order_log".
 *
 * @public int         $id
 * @public int|null    $bloc_id                 公司id
 * @public int|null    $store_id                商户id
 * @public int|null    $member_id               会员id
 * @public int|null    $member_pid1_level       一级会员等级
 * @public int|null    $member_pid2_level       二级会员等级
 * @public int|null    $member_pid3_level       三级会员等级
 * @public int|null    $member_pid3             三级会员id
 * @public int|null    $member_pid2             二级会员id
 * @public int|null    $member_pid1             一级会员id
 * @public int|null    $group_member_pid1_level 一级分销商等级
 * @public int|null    $group_member_pid2_level 二级分销商等级
 * @public int|null    $group_member_pid3_level 三级分销商等级
 * @public int|null    $group_member_pid3       三级分销商id
 * @public int|null    $group_member_pid2       二级分销商id
 * @public int|null    $group_member_pid1       一级分销商id
 * @public int|null    $order_id                价格字段
 * @public int|null    $goods_id                字段名称
 * @public int|null    $goods_spec_id           等级id
 * @public float|null  $memberprice             分销商id
 * @public int|null    $group_id                分销商等级
 * @public int|null    $level_id                会员等级
 * @public string|null $type                    分销方式
 * @public float|null  $money                   分销参数
 * @public string|null $status                  资金状态
 * @public int|null    $refundstatus            退款状态
 * @public int|null    $update_time             更新时间
 */
class HubOrderLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dd_diandi_hub_order_log';
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
    public function rules(): array
    {
        return [
            [['bloc_id', 'store_id', 'member_id', 'member_pid1_level', 'member_pid2_level', 'member_pid3_level', 'member_pid3', 'member_pid2', 'member_pid1', 'group_member_pid1_level', 'group_member_pid2_level', 'group_member_pid3_level', 'group_member_pid3', 'group_member_pid2', 'group_member_pid1', 'order_id', 'goods_id', 'goods_spec_id', 'refundstatus', 'update_time', 'create_time', 'money_status', 'type','order_status'], 'integer'],
            [['memberprice', 'refund_money','goods_price','tota_price'], 'number'],
        ];
    }
    

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        $HubPriceConf = new HubPriceConf();
        $prices = $HubPriceConf->find()->indexBy('pricefield')->asArray()->all();

        return [
            'id' => 'ID',
            'bloc_id' => '公司id',
            'store_id' => '商户id',
            'member_id' => '会员id',
            'member_pid1_level' => '一级会员等级',
            'member_pid2_level' => '二级会员等级',
            'member_pid3_level' => '三级会员等级',
            'member_pid3' => '三级会员id',
            'member_pid2' => '二级会员id',
            'member_pid1' => '一级会员id',
            'group_member_pid1_level' => '一级分销商等级',
            'group_member_pid2_level' => '二级分销商等级',
            'group_member_pid3_level' => '三级分销商等级',
            'group_member_pid3' => '三级分销商id',
            'group_member_pid2' => '二级分销商id',
            'group_member_pid1' => '一级分销商id',
            'order_id' => '价格字段',
            'goods_id' => '字段名称',
            'goods_spec_id' => '等级id',
            'memberprice' => '分销商id',
            'type' => '分销方式',
            'money_status' => '资金状态',
            'order_status' => '订单状态',
            'refundstatus' => '退款状态',
            'refund_money' => '退款金额',
            'goods_price' => '商品价格',
            'tota_price' => '商品总价',
            'price1' => $prices['price1']['name'],
            'price2' => $prices['price2']['name'],
            'price3' => $prices['price3']['name'],
            'price4' => $prices['price4']['name'],
            'price5' => $prices['price5']['name'],
            'price6' => $prices['price6']['name'],
            'update_time' => '更新时间',
            'create_time' => '创建时间',
        ];
    }
}
