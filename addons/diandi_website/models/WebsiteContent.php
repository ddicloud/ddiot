<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-09-16 11:52:57
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-09-16 11:58:01
 */


namespace addons\diandi_website\models;

use Yii;

/**
 * This is the model class for table "{{%diandi_website_content}}".
 *
 * @property int $id
 * @property string $language
 * @property string $title
 * @property int $type 类型1news,2product3photo
 * @property int $category_id
 * @property string $image 缩略图
 * @property string $description
 * @property string $keywords
 * @property int $status 0不显示1显示
 * @property int $admin_user_id
 * @property int $hits 浏览数点击数
 * @property int $created_at
 * @property int $updated_at
 */
class WebsiteContent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_website_content}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['language', 'category_id'], 'required'],
            [['type', 'category_id', 'status', 'admin_user_id', 'hits', 'created_at', 'updated_at'], 'integer'],
            [['language'], 'string', 'max' => 20],
            [['title', 'image', 'description', 'keywords'], 'string', 'max' => 255],
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
            'language' => 'Language',
            'title' => 'Title',
            'type' => '类型1news,2product3photo',
            'category_id' => 'Category ID',
            'image' => '缩略图',
            'description' => 'Description',
            'keywords' => 'Keywords',
            'status' => '0不显示1显示',
            'admin_user_id' => 'Admin User ID',
            'hits' => '浏览数点击数',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
