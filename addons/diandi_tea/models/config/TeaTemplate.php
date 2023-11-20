<?php

namespace addons\diandi_tea\models\config;

use common\traits\ActiveQuery\StoreTrait;

/**
 * This is the model class for table "{{%diandi_tea_msg_template}}".
 *
 * @property int $id
 * @property string|null $create_time
 * @property string|null $update_time
 * @property int|null $bloc_id
 * @property int|null $store_id
 * @property string|null $template_code 消息模板
 * @property string|null $keywords 关键词
 * @property int|null $msg_type 消息用途
 */
class TeaTemplate extends \yii\db\ActiveRecord
{
    use StoreTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%diandi_tea_msg_template}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['create_time', 'update_time'], 'safe'],
            [['bloc_id', 'store_id', 'msg_type'], 'integer'],
            [['template_code'], 'string', 'max' => 100],
            [['keywords'], 'string', 'max' => 255],
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
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'bloc_id' => 'Bloc ID',
            'store_id' => 'Store ID',
            'template_code' => '消息模板',
            'keywords' => '关键词',
            'msg_type' => '消息用途',
        ];
    }
}