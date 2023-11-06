<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-09-16 11:54:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-01 14:15:31
 */

namespace common\plugins\diandi_website\models;

/**
 * This is the model class for table "{{%diandi_website_slide}}".
 *
 * @public int         $id
 * @public string|null $images
 * @public string|null $title
 * @public string|null $description
 * @public string|null $menuname
 * @public string|null $menuurl
 * @public int|null    $createtime
 * @public int|null    $updatetime
 */
class WebsiteSlide extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_website_slide}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['create_time', 'update_time', 'bloc_id', 'store_id', 'page_id', 'displayorder'], 'integer'],
            [['images', 'title', 'description', 'menuname', 'menuurl'], 'string', 'max' => 255],
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
            'images' => 'Images',
            'title' => 'Title',
            'description' => 'Description',
            'menuname' => 'Menuname',
            'menuurl' => 'Menuurl',
            'create_time' => 'Createtime',
            'update_time' => 'Updatetime',
            'page_id' => '页面配置id',
        ];
    }
}
