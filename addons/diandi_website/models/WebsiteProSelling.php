<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-07 09:29:52
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-07 12:03:30
 */

namespace addons\diandi_website\models;

use common\traits\ActiveQuery\StoreTrait;

/**
 * This is the model class for table "{{%diandi_website_pro_selling}}".
 *
 * @property int         $id
 * @property int|null    $store_id
 * @property int|null    $bloc_id
 * @property string|null $create_time
 * @property string|null $update_time
 * @property string|null $image       静止图片
 * @property string|null $title       标题
 * @property string|null $content     内容
 */
class WebsiteProSelling extends \yii\db\ActiveRecord
{
    use StoreTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_website_pro_selling}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
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
            'image' => '静止图片',
            'title' => '标题',
            'content' => '内容',
        ];
    }
}
