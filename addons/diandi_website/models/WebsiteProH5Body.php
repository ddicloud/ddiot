<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-06 18:38:44
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-07 12:03:42
 */

namespace addons\diandi_website\models;

use common\traits\ActiveQuery\StoreTrait;

/**
 * This is the model class for table "{{%diandi_website_pro_h5_body}}".
 *
 * @property int         $id
 * @property int|null    $store_id
 * @property int|null    $bloc_id
 * @property string|null $create_time
 * @property string|null $update_time
 * @property string|null $title       标题
 * @property string|null $content     内容
 * @property string|null $image_a     a图
 * @property string|null $image_b     b图
 */
class WebsiteProH5Body extends \yii\db\ActiveRecord
{
    use StoreTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_website_pro_h5_body}}';
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
            [['title'], 'string', 'max' => 100],
            [['image_a', 'image_b'], 'string', 'max' => 255],
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
            'create_time' => 'create_time',
            'update_time' => 'update_time',
            'title' => '标题',
            'content' => '内容',
            'image_a' => 'a图',
            'image_b' => 'b图',
        ];
    }
}