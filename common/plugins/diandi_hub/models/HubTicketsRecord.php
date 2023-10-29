<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-10-18 17:50:16
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-03-14 17:42:36
 */


namespace common\plugins\diandi_hub\models;

use Yii;

/**
 * This is the model class for table "{{%diandi_hub_tickets_record}}".
 *
 * @public int $id
 * @public int $tickets_id 工单ID
 * @public int $send_id 发送方ID
 * @public int $type 消息发送类型（用户发送|开发者发送）
 * @public string $content 内容
 * @public string $created_at 创建日期
 */
class HubTicketsRecord extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_tickets_record}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['tickets_id', 'send_id', 'type', 'content'], 'required'],
            [['tickets_id', 'send_id', 'type'], 'integer'],
            [['created_at'], 'safe'],
            [['content'], 'string', 'max' => 900],
            ['tickets_id', 'checkTicketsId']
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
                'createdAttribute' => 'created_at',
                'time_type' => 'datetime',
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
            'tickets_id' => '工单ID',
            'send_id' => '发送方ID',
            'type' => '消息发送类型（用户发送|开发者发送）',
            'content' => '内容',
            'created_at' => '创建日期',
        ];
    }

    public function checkTicketsId($field, $scenario, $validator, $value)
    {
        $exists = HubTickets::find()->where(['id' => $value])->exists();
        if (!$exists) {
            $this->addError('tickets_id', '无效的工单信息');
            return false;
        }
    }
}
