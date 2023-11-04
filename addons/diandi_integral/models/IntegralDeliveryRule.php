<?php
/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-02 08:20:48
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-29 16:33:50
 */
 

namespace addons\diandi_integral\models;

use Yii;

/**
 * This is the model class for table "dd_delivery_rule".
 *
 * @public int $rule_id
 * @public int $delivery_id
 * @public string $region
 * @public float $first
 * @public float $first_fee
 * @public float $additional
 * @public float $additional_fee
 * @public int $wxapp_id
 * @public int $create_time
 */
class IntegralDeliveryRule extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%diandi_integral_delivery_rule}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['delivery_id','bloc_id','store_id', 'create_time'], 'integer'],
            //[['region', 'create_time'], 'required'],
            [['region'], 'string'],
            [['first', 'first_fee', 'additional', 'additional_fee'], 'number'],
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
                // 'updatedAttribute' => 'update_time',
                'createdAttribute' => 'create_time',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'rule_id' => 'Rule ID',
            'bloc_id' => '公司ID',
            'store_id' => '商户ID',
            'delivery_id' => 'Delivery ID',
            'region' => '地区',
            'first' => '起重',
            'first_fee' => '首重费用',
            'additional' => 'Additional',
            'additional_fee' => 'Additional Fee',
            'create_time' => 'Create Time',
        ];
    }

    public function getDelivery(): \yii\db\ActiveQuery
    {
        return $this->hasOne(IntegralDelivery::class,['delivery_id' => 'delivery_id'])->select('name')->asArray();
    }
}
