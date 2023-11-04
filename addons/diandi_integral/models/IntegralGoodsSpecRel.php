<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-03 04:51:54
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-14 18:21:00
 */


namespace addons\diandi_integral\models;

use common\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "dd_goods_spec_rel".
 *
 * @public int $id
 * @public int $goods_id
 * @public int $spec_id
 * @public int $spec_value_id
 * @public int $wxapp_id
 * @public int $create_time
 */
class IntegralGoodsSpecRel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%diandi_integral_goods_spec_rel}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['goods_id','bloc_id','store_id', 'spec_id', 'spec_value_id', 'create_time', 'spec_item_show'], 'integer'],
            [['thumb'], 'string']
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
                'updatedAttribute' => 'update_time',
                'createdAttribute' => 'create_time',
            ],
        ];
    }


    public function getSpec(): \yii\db\ActiveQuery
    {
        return $this->hasOne(IntegralSpec::class, ['spec_id' => 'spec_id']);
    }

    public function getSpecvalue(): \yii\db\ActiveQuery
    {
        return $this->hasOne(IntegralSpecValue::class, ['spec_value_id' => 'spec_value_id']);
    }




    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'thumb' => '属性图片',
            'spec_item_show' => '属性图片',
            'goods_id' => 'Goods ID',
            'spec_id' => 'Spec ID',
            'spec_value_id' => 'Spec Value ID',
            'wxapp_id' => 'Wxapp ID',
            'create_time' => 'Create Time',
        ];
    }
}
