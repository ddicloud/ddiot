<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-27 17:34:54
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-27 17:48:11
 */


namespace addons\diandi_website\models;

use Yii;

/**
 * This is the model class for table "{{%diandi_website_backend_exhibit}}".
 *
 * @property int $id ID
 * @property int $bloc_id
 * @property int $store_id
 * @property int $solution_id 解决案例ID
 * @property string $title 标题
 * @property string $subtitle 副标题
 * @property string $icon ICON
 * @property string $image 图片
 * @property string $link 链接
 * @property string $content 内容
 * @property string $created_at 创建时间
 * @property string $updated_at
 */
class BackendExhibit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_website_backend_exhibit}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'solution_id', 'subtitle', 'icon', 'image', 'link', 'content'], 'required'],
            [['bloc_id', 'store_id', 'solution_id'], 'integer'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 45],
            [['subtitle', 'icon', 'image', 'link'], 'string', 'max' => 180],
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
                'updatedAttribute' => 'updated_at',
                'createdAttribute' => 'created_at',
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
            'bloc_id' => 'Bloc ID',
            'store_id' => 'Store ID',
            'solution_id' => '解决案例ID',
            'title' => '标题',
            'subtitle' => '副标题',
            'icon' => 'ICON',
            'image' => '图片',
            'link' => '链接',
            'content' => '内容',
            'created_at' => '创建时间',
            'updated_at' => 'Updated At',
        ];
    }
}