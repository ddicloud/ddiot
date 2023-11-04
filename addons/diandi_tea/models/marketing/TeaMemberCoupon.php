<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-18 10:21:06
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-08 17:01:39
 */

namespace addons\diandi_tea\models\marketing;

use common\models\DdMember;

/**
 * This is the model class for table "{{%diandi_tea_member_coupon}}".
 *
 * @public int         $id           会员卡券id
 * @public int         $bloc_id      人脸库组id
 * @public int         $store_id
 * @public string|null $create_time
 * @public string|null $update_time
 * @public int|null    $member_id    会员id
 * @public string      $coupon_name  卡券名称
 * @public int|null    $coupon_type  卡券类型  1：代金券 2：时常卡  3：次卡 4：折扣券 5：体验券
 * @public int|null    $coupon_id    卡券id
 * @public string|null $buy_time     购买时间
 * @public string|null $end_time     到期时间
 * @public string|null $use_time     使用时间
 * @public int|null    $use_num      使用次数
 * @public int|null    $surplus_num  剩余次数
 * @public int|null    $receive_type 领取方式：1.   2.
 */
class TeaMemberCoupon extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%diandi_tea_member_coupon}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['coupon_name'], 'required'],
            [['bloc_id', 'store_id', 'member_id', 'coupon_type', 'coupon_id', 'use_num', 'surplus_num', 'receive_type'], 'integer'],
            [['create_time', 'update_time', 'buy_time', 'end_time', 'use_time'], 'safe'],
            [['coupon_name'], 'string', 'max' => 100],
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
                'time_type' => 'datetime',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => '会员卡券id',
            'bloc_id' => '人脸库组id',
            'store_id' => 'Store ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'member_id' => '会员id',
            'coupon_name' => '卡券名称',
            'coupon_type' => '卡券类型  1：代金券 2：时常卡  3：次卡 4：折扣券 5：体验券',
            'coupon_id' => '卡券id',
            'buy_time' => '购买时间',
            'end_time' => '到期时间',
            'use_time' => '使用时间',
            'use_num' => '使用次数',
            'surplus_num' => '剩余次数',
            'receive_type' => '领取方式：1.领取 2.购买 3.充值赠送',
        ];
    }

    public function getMember(): \yii\db\ActiveQuery
    {
        return $this->hasOne(DdMember::class, ['member_id' => 'member_id'])->select(['username', 'member_id'])->asArray();
    }

    public function getCoupon(): \yii\db\ActiveQuery
    {
        return $this->hasOne(TeaCoupon::class, ['id' => 'coupon_id'])->select(['id', 'price', 'enable_end', 'enable_start', 'max_time', 'cash', 'discount', 'use_start', 'use_end'])->asArray();
    }
}
