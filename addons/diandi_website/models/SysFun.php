<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-24 16:57:59
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-24 18:03:41
 */


namespace addons\diandi_website\models;

use Yii;

/**
 * This is the model class for table "{{%diandi_website_sys_fun}}".
 *
 * @public int $id ID
 * @public int $bloc_id
 * @public int $store_id
 * @public int $cate_id 分类ID
 * @public string $title 标题
 * @public string $icon
 * @public string $des 描述
 * @public string $created_at 创建时间
 * @public string $updated_at 最后一次更新时间
 */
class SysFun extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_website_sys_fun}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cate_id', 'title', 'icon', 'des'], 'required'],
            [['bloc_id', 'store_id', 'cate_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 45],
            [['icon'], 'string', 'max' => 180],
            [['des'], 'string', 'max' => 450],
            ['cate_id', 'exist', 'targetClass' => 'addons\diandi_website\models\SysFunCate', 'targetAttribute' => 'id', 'message' => '指定分类不存在'],
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
                'time_type' => 'datetime'
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
            'cate_id' => '分类ID',
            'title' => '标题',
            'icon' => 'ICON',
            'des' => '描述',
            'created_at' => '创建时间',
            'updated_at' => '最后一次更新时间',
        ];
    }

    public function getCate()
    {
        return $this->hasOne(SysFunCate::class, ['id' => 'cate_id'])->select(['name', 'icon', 'des', 'is_website']);
    }
}
