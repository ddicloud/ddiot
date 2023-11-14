<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-04-20 19:03:02
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-21 09:43:13
 */

namespace common\plugins\diandi_website\models;

/**
 * This is the model class for table "{{%diandi_website_page_config}}".
 *
 * @public int         $id
 * @public int|null    $bloc_id
 * @public int|null    $store_id
 * @public string      $title
 * @public string|null $template
 * @public string      $type
 * @public int|null    $create_time
 * @public int|null    $update_time
 */
class WebsitePageConfig extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function  tableName(): string
    {
        return '{{%diandi_website_page_config}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['bloc_id', 'store_id', 'create_time', 'update_time'], 'integer'],
            [['title', 'type'], 'required'],
            [['title'], 'string', 'max' => 30],
            [['template'], 'string', 'max' => 50],
            [['type'], 'string', 'max' => 15],
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
                'class' => \common\behaviors\SaveBehavior::class,
                'updatedAttribute' => 'update_time',
                'createdAttribute' => 'create_time',
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
            'bloc_id' => 'Bloc ID',
            'store_id' => 'Store ID',
            'title' => 'Title',
            'template' => 'Template',
            'type' => 'Type',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
