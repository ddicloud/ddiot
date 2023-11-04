<?php
/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-02 16:16:06
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-14 18:13:18
 */
 

namespace addons\diandi_integral\models;

use Yii;

/**
 * This is the model class for table "dd_spec_value".
 *
 * @public int $spec_value_id
 * @public string $spec_value
 * @public int $spec_id
 * @public int $wxapp_id
 * @public int $create_time
 */
class IntegralSpecValue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%diandi_integral_spec_value}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['spec_value', 'spec_id', 'create_time'], 'required'],
            [['spec_id', 'create_time','bloc_id','store_id'], 'integer'],
            [['spec_value'], 'string', 'max' => 255],
        ];
    }

      /**
     * 行为
     */
    public function behaviors(): array
    {
        /*自动添加创建和修改时间*/
        return [
            [
                'class' => \common\behaviors\SaveBehavior::class,
                // 'updatedAttribute' => 'create_time',
                'createdAttribute' => 'create_time',
            ]
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'spec_value_id' => 'Spec Value ID',
            'spec_value' => 'Spec Value',
            'spec_id' => 'Spec ID',
            'wxapp_id' => 'Wxapp ID',
            'create_time' => 'Create Time',
        ];
    }
}
