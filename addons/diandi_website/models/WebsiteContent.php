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
 * @public int $id
 * @public string $language
 * @public string $title
 * @public int $type 类型1news,2product3photo
 * @public int $category_id
 * @public string $image 缩略图
 * @public string $description
 * @public string $keywords
 * @public int $status 0不显示1显示
 * @public int $admin_user_id
 * @public int $hits 浏览数点击数
 * @public int $created_at
 * @public int $updated_at
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
