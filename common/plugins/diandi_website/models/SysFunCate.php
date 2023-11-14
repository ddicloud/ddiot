<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-24 15:04:52
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-28 12:34:03
 */


namespace common\plugins\diandi_website\models;

use Yii;

/**
 * This is the model class for table "{{%diandi_website_sys_fun_cate}}".
 *
 * @public int $id ID
 * @public int $bloc_id
 * @public int $store_id
 * @public int $solution_id 解決方案
 * @public string $name 名称
 * @public string $icon ICON
 * @public string $des 描述
 * @public int $is_website 是否是官网
 * @public string $created_at 创建时间
 * @public string $updated_at 更新时间
 */
class SysFunCate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function  tableName(): string
    {
        return '{{%diandi_website_sys_fun_cate}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'icon', 'des'], 'required'],
            [['id', 'bloc_id', 'store_id', 'is_website'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 45],
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
    public function behaviors(): array
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
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'bloc_id' => 'Bloc ID',
            'store_id' => 'Store ID',
            'solution_id' => '解決方案ID',
            'name' => '名称',
            'icon' => 'ICON',
            'des' => '描述',
            'is_website' => '是否是官网',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    public static $funLimit = 10;
    public function getFun()
    {
        return $this->hasMany(SysFun::class, ['cate_id' => 'id'])->select(['title', 'icon', 'des', 'id', 'cate_id'])->limit(self::$funLimit);
    }
}
