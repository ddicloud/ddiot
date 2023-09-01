<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-27 09:41:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-29 09:39:22
 */


namespace addons\diandi_website\models;

use Yii;

/**
 * This is the model class for table "{{%diandi_website_solution_cate}}".
 *
 * @public int $id ID
 * @public int $bloc_id
 * @public int $store_id
 * @public string $name 名称
 * @public string $des 描述
 * @public string $created_at 创建时间
 * @public string $updated_at 更新时间
 */
class SolutionCate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_website_solution_cate}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'des'], 'required'],
            [['bloc_id', 'store_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 45],
            [['des'], 'string', 'max' => 450],
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
            'name' => '名称',
            'des' => '描述',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    public static $solutionLimit = 10;
    public  function getSolution()
    {
        return $this->hasMany(Solution::class, ['cate_id' => 'id'])->select(['cate_id', 'name', 'icon', 'des'])->limit(self::$solutionLimit);
    }
}
