<?php
/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-02 08:20:48
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-11-04 23:14:08
 */
 

namespace common\plugins\diandi_hub\models\order;

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
class HubDeliveryRule extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_delivery_rule}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['delivery_id','bloc_id','store_id', 'wxapp_id', 'create_time'], 'integer'],
            [['region', 'create_time'], 'required'],
            [['region'], 'string'],
            [['first', 'first_fee', 'additional', 'additional_fee'], 'number'],
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
                // 'updatedAttribute' => 'update_time',
                'createdAttribute' => 'create_time',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'rule_id' => 'Rule ID',
            'delivery_id' => 'Delivery ID',
            'region' => '地区',
            'first' => '起重',
            'first_fee' => '首重费用',
            'additional' => 'Additional',
            'additional_fee' => 'Additional Fee',
            'wxapp_id' => 'Wxapp ID',
            'create_time' => 'Create Time',
        ];
    }
}
