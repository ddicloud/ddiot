<?php

namespace addons\diandi_website\models;

use Yii;
use common\traits\ActiveQuery\StoreTrait;

/**
 * This is the model class for table "{{%diandi_website_pro_corefun}}".
 *
 * @property int $id
 * @property int|null $store_id
 * @property int|null $bloc_id
 * @property string|null $create_time
 * @property string|null $update_time
 * @property string|null $logo logo
 * @property string|null $title 标题
 * @property string|null $describe 描述
 * @property int|null $sort 排序
 */
class WebsiteCorefun extends \yii\db\ActiveRecord
{
    use StoreTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_website_pro_corefun}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['store_id', 'bloc_id', 'sort'], 'integer'],
            [['create_time', 'update_time'], 'string', 'max' => 30],
            [['logo', 'describe'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 100],
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
            'store_id' => 'Store ID',
            'bloc_id' => 'Bloc ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'logo' => 'logo',
            'title' => '标题',
            'describe' => '描述',
            'sort' => '排序',
        ];
    }
}
