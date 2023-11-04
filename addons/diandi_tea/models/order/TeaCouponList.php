<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-18 17:41:51
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-26 11:47:46
 */

namespace addons\diandi_tea\models\order;

use common\models\DdMember;

/**
 * This is the model class for table "{{%diandi_tea_coupon_list}}".
 *
 * @public int         $id          卡券消费记录id
 * @public int         $bloc_id     人脸库组id
 * @public int         $store_id
 * @public string|null $create_time
 * @public string|null $update_time
 * @public int|null    $member_id   会员id
 * @public string      $coupon_name 卡券名称
 * @public int|null    $coupon_type 卡券类型  1：代金券 2：时常卡  3：次卡 4：折扣券 5：体验券
 * @public int|null    $coupon_id   卡券id
 * @public int|null    $order_id    订单id
 * @public float|null  $price       卡券价格
 */
class TeaCouponList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%diandi_tea_coupon_list}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['coupon_name'], 'required'],
            [['bloc_id', 'store_id', 'member_id', 'coupon_type', 'coupon_id', 'order_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['price'], 'number'],
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
                'time_type'=>'datetime'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => '卡券消费记录id',
            'bloc_id' => '人脸库组id',
            'store_id' => 'Store ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'member_id' => '会员id',
            'coupon_name' => '卡券名称',
            'coupon_type' => '卡券类型  1：代金券 2：时常卡  3：次卡 4：折扣券 5：体验券',
            'coupon_id' => '卡券id',
            'order_id' => '订单id',
            'price' => '卡券价格',
        ];
    }

    /**
     * 关联用户模型.
     */
    public function getMember(): \yii\db\ActiveQuery
    {
        return $this->hasOne(DdMember::class, ['member_id' => 'member_id'])->select('nickName')->asArray();
    }
}
