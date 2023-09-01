<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-06 18:29:32
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-27 15:56:41
 */

namespace addons\diandi_website\models;

use common\traits\ActiveQuery\StoreTrait;

/**
 * This is the model class for table "{{%diandi_website_pro_customer}}".
 *
 * @public int         $id
 * @public int|null    $store_id
 * @public int|null    $bloc_id
 * @public string|null $create_time
 * @public string|null $update_time
 * @public string|null $image       图片
 * @public string|null $title       标题
 * @public string|null $content     内容
 * @public string|null $link        链接地址
 */
class WebsiteProCustomer extends \yii\db\ActiveRecord
{
    use StoreTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_website_pro_customer}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['store_id', 'bloc_id', 'solution_id', 'is_website'], 'integer'],
            [['content'], 'string'],
            [['create_time', 'update_time'], 'string', 'max' => 30],
            [['image', 'link'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 100],
            ['solution_id', 'exist', 'targetClass' => 'addons\diandi_website\models\Solution', 'targetAttribute' => 'id', 'message' => '指定解决方案不存在', 'when' => function ($model) {
                return $model->solution_id != 0;
            }],
            ['is_website', 'in', 'range' => [-1, 1], 'message' => '是否是官网只能是\'-1\',或者\'1\''],
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
            'image' => '图片',
            'title' => '标题',
            'content' => '内容',
            'link' => '链接地址',
            'solution_id' => '解决方案ID',
            'is_website' => '是否是官网',
        ];
    }
}
