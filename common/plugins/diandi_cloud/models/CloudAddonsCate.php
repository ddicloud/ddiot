<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-07-06 15:30:35
 * @Last Modified by:   Radish <minradish@163.com>
 * @Last Modified time: 2022-10-13 09:52:07
 */


namespace common\plugins\diandi_cloud\models;

use Yii;

/**
 * This is the model class for table "{{%diandi_cloud_addons_cate}}".
 *
 * @public int $id ID
 * @public int $pid 上级 ID
 * @public string $name 分类名称
 * @public int $sort 排序值
 * @public string $created_at 创建时间
 * @public string $updated_at 更新时间
 */
class CloudAddonsCate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_cloud_addons_cate}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['pid', 'sort'], 'integer'],
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 45],
            ['pid', 'exist', 'targetClass' => 'addons\diandi_cloud\models\CloudAddonsCate', 'targetAttribute' => 'id', 'message' => '所选上级分类不存在', 'when' => function ($model) {
                return $model->pid > 0;
            }],
        ];
    }

    public function getChildren()
    {
        return $this->hasMany(CloudAddonsCate::class, ['pid' => 'id']);
    }

    public function getAddons()
    {
        return $this->hasMany(CloudAddons::class, ['cate_id' => 'id']);
    }

    public function getParent()
    {
        return $this->hasOne(CloudAddonsCate::class, ['pid' => 'id']);
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
                'updatedAttribute' => 'created_at',
                'createdAttribute' => 'updated_at',
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
            'pid' => '上级 ID',
            'name' => '分类名称',
            'sort' => '排序值',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }
}
