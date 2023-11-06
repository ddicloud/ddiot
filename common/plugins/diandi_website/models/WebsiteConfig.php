<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-09-16 11:51:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-09-16 11:57:10
 */


namespace common\plugins\diandi_website\models;

use Yii;

/**
 * This is the model class for table "{{%diandi_website_config}}".
 *
 * @public int $id
 * @public string $name 字段名英文
 * @public string $label 字段标注
 * @public string $value 字段值
 * @public int $created_at
 * @public int $updated_at
 * @public string $language
 */
class WebsiteConfig extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_website_config}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['label', 'created_at', 'updated_at', 'language'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['name', 'language'], 'string', 'max' => 20],
            [['label'], 'string', 'max' => 50],
            [['value'], 'string', 'max' => 3000],
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
            'name' => '字段名英文',
            'label' => '字段标注',
            'value' => '字段值',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'language' => 'Language',
        ];
    }
}
