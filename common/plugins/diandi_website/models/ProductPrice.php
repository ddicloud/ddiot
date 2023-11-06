<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-27 18:49:33
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-28 10:01:27
 */


namespace common\plugins\diandi_website\models;

use Yii;

/**
 * This is the model class for table "{{%diandi_website_product_price}}".
 *
 * @public int $id ID
 * @public int $bloc_id
 * @public int $store_id
 * @public int $solution_id 解决案例ID
 * @public string $name 产品名称
 * @public string $des 产品描述
 * @public float $price 产品价格
 * @public string $show_price 展示价格
 * @public int $drift 价格浮动
 * @public string $fun 产品功能
 * @public string $created_at 创建时间
 * @public string $updated_at
 */
class ProductPrice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_website_product_price}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name', 'des', 'price', 'show_price', 'fun', 'solution_id', 'back_color', 'is_recommend'], 'required'],
            [['bloc_id', 'store_id', 'solution_id', 'drift'], 'integer'],
            [['price'], 'number'],
            [['fun', 'created_at', 'updated_at'], 'safe'],
            [['name', 'show_price'], 'string', 'max' => 45],
            [['des'], 'string', 'max' => 450],
            ['solution_id', 'exist', 'targetClass' => 'addons\diandi_website\models\Solution', 'targetAttribute' => 'id', 'message' => '指定解决方案不存在', 'when' => function ($model) {
                return $model->solution_id != 0;
            }],
            ['fun', 'checkFun'],
            ['is_recommend', 'in', 'range' => [-1, 1], 'message' => '是否推荐只能是\'-1\',或者\'1\'']
        ];
    }

    public function checkFun($field, $scenario, $vali, $val)
    {
        if (json_decode($val, true) === null) {
            $this->addError('fun', '产品功能 无效的JSON格式!');
        }
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
            'solution_id' => '解决案例ID',
            'name' => '产品名称',
            'des' => '产品描述',
            'price' => '产品价格',
            'show_price' => '展示价格',
            'drift' => '价格浮动',
            'fun' => '产品功能',
            'back_color' => '背景色',
            'is_recommend' => '是否推荐',
            'created_at' => '创建时间',
            'updated_at' => 'Updated At',
        ];
    }
}
