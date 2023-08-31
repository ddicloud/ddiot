<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-27 16:55:20
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-27 16:58:24
 */


namespace addons\diandi_website\models;

use Yii;

/**
 * This is the model class for table "{{%diandi_website_sys_worth}}".
 *
 * @public int $id ID
 * @public int $bloc_id
 * @public int $store_id
 * @public int $solution_id 解决案例ID
 * @public int $is_website 是否是官网
 * @public string $title 标题
 * @public string $icon
 * @public string $des 描述
 * @public string $created_at 创建时间
 * @public string $updated_at
 */
class SysWorth extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_website_sys_worth}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'icon', 'des'], 'required'],
            [['bloc_id', 'store_id', 'solution_id', 'is_website'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 45],
            [['icon'], 'string', 'max' => 180],
            [['des'], 'string', 'max' => 450],
            ['solution_id', 'exist', 'targetClass' => 'addons\diandi_website\models\Solution', 'targetAttribute' => 'id', 'message' => '指定解决方案不存在', 'when' => function ($model) {
                return $model->solution_id != 0;
            }],
            ['is_website', 'in', 'range' => [-1, 1], 'message' => '是否是官网只能是\'-1\',或者\'1\'']
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
            'is_website' => '是否是官网',
            'title' => '标题',
            'icon' => 'Icon',
            'des' => '描述',
            'created_at' => '创建时间',
            'updated_at' => 'Updated At',
        ];
    }
}
