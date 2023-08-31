<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-07 09:39:50
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-01 14:14:54
 */

namespace addons\diandi_website\models;

use common\traits\ActiveQuery\StoreTrait;

/**
 * This is the model class for table "{{%diandi_website_pro_slide}}".
 *
 * @public int         $id
 * @public int|null    $store_id
 * @public int|null    $bloc_id
 * @public string|null $create_time
 * @public string|null $update_time
 * @public string|null $link        链接地址
 * @public string|null $image       显示图片
 */
class WebsiteProSlide extends \yii\db\ActiveRecord
{
    use StoreTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_website_pro_slide}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['store_id', 'bloc_id', 'displayorder'], 'integer'],
            [['create_time', 'update_time'], 'string', 'max' => 30],
            [['link', 'image'], 'string', 'max' => 255],
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
            'link' => '链接地址',
            'image' => '显示图片',
        ];
    }
}
