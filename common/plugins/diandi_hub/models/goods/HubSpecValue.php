<?php
/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-02 16:16:06
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-14 18:07:29
 */

namespace common\plugins\diandi_hub\models\goods;

/**
 * This is the model class for table "dd_spec_value".
 *
 * @public int    $spec_value_id
 * @public string $spec_value
 * @public int    $spec_id
 * @public int    $wxapp_id
 * @public int    $create_time
 */
class HubSpecValue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_spec_value}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['spec_value', 'spec_id'], 'required'],
            [['spec_id', 'create_time', 'bloc_id', 'store_id'], 'integer'],
            [['spec_value'], 'string', 'max' => 255],
            [['category_ids'], 'string'],
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
                // 'updatedAttribute' => 'create_time',
                'createdAttribute' => 'create_time',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'spec_value_id' => 'Spec Value ID',
            'spec_value' => 'Spec Value',
            'spec_id' => 'Spec ID',
            'wxapp_id' => 'Wxapp ID',
            'create_time' => 'Create Time',
            'category_ids' => '分类集合',
        ];
    }
}
