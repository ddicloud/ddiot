<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-07-29 18:17:57
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-07-29 18:38:06
 */

namespace common\models;

/**
 * This is the model class for table "{{%user_action_log}}".
 *
 * @property int         $id
 * @property string|null $user      用户
 * @property string|null $operation 操作
 * @property string|null $logtime   操作时间
 * @property string|null $logip     操作ip
 */
class ActionLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_action_log}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['create_time', 'update_time', 'logtime'], 'safe'],
            [['user_id'], 'integer'],
            [['operation'], 'string', 'max' => 100],
            [['logip'], 'string', 'max' => 20],
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
                'updatedAttribute' => 'update_time',
                'createdAttribute' => 'create_time',
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
            'user' => '用户',
            'operation' => '操作',
            'logtime' => '操作时间',
            'logip' => '操作ip',
        ];
    }
}
