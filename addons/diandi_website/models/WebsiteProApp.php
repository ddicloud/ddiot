<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-06 14:49:12
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-07 12:03:56
 */

namespace addons\diandi_website\models;

use common\traits\ActiveQuery\StoreTrait;

/**
 * This is the model class for table "{{%diandi_website_pro_app}}".
 *
 * @public int         $id
 * @public int|null    $store_id
 * @public int|null    $bloc_id
 * @public string|null $create_time
 * @public string|null $update_time
 * @public string|null $link        立即使用链接地址
 * @public string|null $logo        图标
 * @public string|null $content     内容
 * @public string|null $title       标题
 * @public string|null $tip1        小提示1
 * @public string|null $tip2        小提示2
 */
class WebsiteProApp extends \yii\db\ActiveRecord
{
    use StoreTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_website_pro_app}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['store_id', 'bloc_id'], 'integer'],
            [['content'], 'string'],
            [['create_time', 'update_time'], 'string', 'max' => 30],
            [['link', 'logo', 'tip1', 'tip2'], 'string', 'max' => 255],
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
                'class' => \common\behaviors\SaveBehavior::class,
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
            'create_time' => 'create_time',
            'update_time' => 'update_time',
            'link' => '立即使用链接地址',
            'logo' => '图标',
            'content' => '内容',
            'title' => '标题',
            'tip1' => '小提示1',
            'tip2' => '小提示2',
        ];
    }
}
