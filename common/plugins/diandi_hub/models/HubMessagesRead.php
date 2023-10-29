<?php

/**
 * @Author: Radish <minradish@163.com>
 * @Date:   2022-10-09 15:34:46
 * @Last Modified by:   Radish <minradish@163.com>
 * @Last Modified time: 2022-10-11 10:35:17
 */

namespace common\plugins\diandi_hub\models;

use Yii;

/**
 * This is the model class for table "dd_diandi_hub_messages_read".
 *
 * @public int $id ID
 * @public int $admin_id 管理员ID
 * @public int $message_id 消息ID
 * @public string $created_at 阅读时间
 */
class HubMessagesRead extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_messages_read}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['admin_id', 'message_id', 'created_at'], 'required'],
            [['admin_id', 'message_id'], 'integer'],
            [['created_at'], 'safe'],
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
                'updatedAttribute' => '',
                'createdAttribute' => 'created_at',
                'adminAttribute' => '',
                'time_type' => 'datetime'
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
            'admin_id' => '管理员ID',
            'message_id' => '消息ID',
            'created_at' => '阅读时间',
        ];
    }
}
