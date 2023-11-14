<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-07 09:29:52
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-07 12:03:30
 */

namespace common\plugins\diandi_website\models;

use common\traits\ActiveQuery\StoreTrait;

/**
 * This is the model class for table "{{%diandi_website_pro_selling}}".
 *
 * @public int         $id
 * @public int|null    $store_id
 * @public int|null    $bloc_id
 * @public string|null $create_time
 * @public string|null $update_time
 * @public string|null $image       静止图片
 * @public string|null $title       标题
 * @public string|null $content     内容
 */
class WebsiteProSelling extends \yii\db\ActiveRecord
{
    use StoreTrait;

    /**
     * {@inheritdoc}
     */
    public static function  tableName(): string
    {
        return '{{%diandi_website_pro_selling}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['store_id', 'bloc_id'], 'integer'],
            [['create_time', 'update_time'], 'string', 'max' => 30],
            [['image', 'content'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 100],
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
            'store_id' => 'Store ID',
            'bloc_id' => 'Bloc ID',
            'create_time' => 'create_time',
            'update_time' => 'update_time',
            'image' => '静止图片',
            'title' => '标题',
            'content' => '内容',
        ];
    }
}
