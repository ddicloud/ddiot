<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-16 15:03:44
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-07-01 19:03:28
 */

namespace addons\diandi_tea\models\config;

use common\traits\ActiveQuery\StoreTrait;

/**
 * This is the model class for table "{{%diandi_tea_global_config}}".
 *
 * @public int         $id              人脸招聘
 * @public int         $bloc_id         人脸库组id
 * @public int         $store_id
 * @public string|null $create_time
 * @public string|null $update_time
 * @public string|null $mumber_scale    会员积分比例
 * @public string|null $vip_scale       vip积分比例
 * @public string|null $store_introduce 商户简介
 */
class TeaGlobalConfig extends \yii\db\ActiveRecord
{
    use StoreTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%diandi_tea_global_config}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['bloc_id', 'store_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['store_introduce', 'admin_ids'], 'string'],
            [['sms_order_template', 'sms_order_sign', 'order_create_template', 'order_end_template', 'recharge_template', 'renew_template'], 'string', 'max' => 100],
            [['mumber_scale', 'vip_scale', 'sms_mobiles'], 'string', 'max' => 255],
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
            'id' => '人脸招聘',
            'bloc_id' => '人脸库组id',
            'store_id' => 'Store ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'mumber_scale' => '会员积分比例',
            'vip_scale' => 'vip积分比例',
            'store_introduce' => '商户简介',
        ];
    }
}
