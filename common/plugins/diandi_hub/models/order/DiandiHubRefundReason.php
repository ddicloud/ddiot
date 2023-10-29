<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-10 19:20:16
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-10 19:20:17
 */
 

namespace common\plugins\diandi_hub\models\order;

use Yii;

/**
 * This is the model class for table "{{%diandi_hub_refund_reason}}".
 *
 * @public int $id
 * @public string|null $reason
 * @public int|null $create_time
 * @public int|null $update_time
 */
class DiandiHubRefundReason extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_refund_reason}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['create_time', 'update_time'], 'integer'],
            [['reason'], 'string', 'max' => 50],
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

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'reason' => '原由',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
