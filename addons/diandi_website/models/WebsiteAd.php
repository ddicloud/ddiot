<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-09-16 14:45:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-09-22 19:13:08
 */


namespace addons\diandi_website\models;

use Yii;

/**
 * This is the model class for table "{{%diandi_website_ad}}".
 *
 * @public int $id
 * @public string $title
 * @public int|null $type 101 轮播图 102 友情链接
 * @public int|null $category_id
 * @public string $image
 * @public string $link
 * @public int $created_at
 * @public int $updated_at
 */
class WebsiteAd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_website_ad}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'category_id', 'created_at', 'updated_at', 'bloc_id', 'store_id'], 'integer'],
            [['title'], 'string', 'max' => 50],
            [['image', 'link'], 'string', 'max' => 255],
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
                'updatedAttribute' => 'updated_at',
                'createdAttribute' => 'created_at',
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
            'title' => 'Title',
            'type' => '101 轮播图 102 友情链接',
            'category_id' => 'Category ID',
            'image' => 'Image',
            'link' => 'Link',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
