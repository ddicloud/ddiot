<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-06 18:12:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-27 16:28:56
 */

namespace addons\diandi_website\models;

use common\traits\ActiveQuery\StoreTrait;

/**
 * This is the model class for table "{{%diandi_website_pro_core}}".
 *
 * @property int         $id
 * @property int|null    $store_id
 * @property int|null    $bloc_id
 * @property string|null $create_time
 * @property string|null $update_time
 * @property string|null $link        链接地址
 * @property string|null $logo        logo
 * @property string|null $title       标题
 * @property string|null $describe    描述
 * @property string|null $content     内容
 */
class WebsiteProCore extends \yii\db\ActiveRecord
{
    use StoreTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_website_pro_core}}';
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
            [['link', 'logo', 'describe'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 100],
            ['solution_id', 'exist', 'targetClass' => 'addons\diandi_website\models\Solution', 'targetAttribute' => 'id', 'message' => '指定解决方案不存在', 'when' => function ($model) {
                return $model->solution_id != 0;
            }],
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
            'link' => '链接地址',
            'logo' => 'logo',
            'title' => '标题',
            'describe' => '描述',
            'content' => '内容',
            'solution_id' => '解决方案ID',
        ];
    }
}
