<?php

/**
 * @Author: Radish <minradish@163.com>
 * @Date:   2022-10-09 15:34:46
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-11-05 19:57:59
 */

namespace admin\models\message;

use Yii;

/**
 * This is the model class for table "dd_diandi_hub_messages_read".
 *
 * @property int $id ID
 * @property int $admin_id 管理员ID
 * @property int $message_id 消息ID
 * @property string $created_at 阅读时间
 */
class HubMessagesRead extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%dd_messages_read}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
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
                'class' => \common\behaviors\SaveBehavior::className(),
                'updatedAttribute' => '',
                'createdAttribute' => 'created_at',
                'adminAttribute' => '',
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
            'admin_id' => '管理员ID',
            'message_id' => '消息ID',
            'created_at' => '阅读时间',
        ];
    }
}
