<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-17 09:14:10
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-30 16:37:38
 */

namespace addons\diandi_tea\models\order;

use addons\diandi_tea\models\config\TeaHourse;
use addons\diandi_tea\models\marketing\TeaCoupon;
use api\models\DdMember;

/**
 * This is the model class for table "{{%diandi_tea_meituan}}".
 *
 * @public int         $id          包间订单id
 * @public int         $bloc_id     人脸库组id
 * @public int         $store_id
 * @public string|null $create_time
 * @public string|null $update_time
 * @public int|null    $order_id    订单ID
 * @public int|null    $member_id   会员id
 * @public int|null    $coupon_id   使用卡券id
 * @public int|null    $status      是否使用，生成订单为使用。1使用，0未使用
 * @public int|null    $hourse_id   包间id
 */
class TeaMeituan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%diandi_tea_meituan}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['bloc_id', 'store_id', 'order_id', 'member_id', 'coupon_id', 'status', 'hourse_id'], 'integer'],
            [['create_time', 'update_time', 'meituan_code'], 'safe'],
            [['meituan_code'], 'unique'],
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

    public function getCoupon(): \yii\db\ActiveQuery
    {
        return $this->hasOne(TeaCoupon::class, ['id' => 'coupon_id']);
    }

    public function getMember(): \yii\db\ActiveQuery
    {
        return $this->hasOne(DdMember::class, ['member_id' => 'member_id']);
    }

    public function getOrder(): \yii\db\ActiveQuery
    {
        return $this->hasOne(TeaOrderList::class, ['id' => 'order_id']);
    }

    public function getHourse(): \yii\db\ActiveQuery
    {
        return $this->hasOne(TeaHourse::class, ['id' => 'hourse_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => '包间订单id',
            'bloc_id' => '公司ID',
            'store_id' => 'Store ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'order_id' => '订单ID',
            'member_id' => '会员id',
            'coupon_id' => '使用卡券id',
            'status' => '是否使用，生成订单为使用。1使用，0未使用',
            'hourse_id' => '包间id',
        ];
    }
}
