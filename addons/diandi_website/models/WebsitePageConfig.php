<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-04-20 19:03:02
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-21 09:43:13
 */

namespace addons\diandi_website\models;

/**
 * This is the model class for table "{{%diandi_website_page_config}}".
 *
 * @property int         $id
 * @property int|null    $bloc_id
 * @property int|null    $store_id
 * @property string      $title
 * @property string|null $template
 * @property string      $type
 * @property int|null    $create_time
 * @property int|null    $update_time
 */
class WebsitePageConfig extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_website_page_config}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
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
