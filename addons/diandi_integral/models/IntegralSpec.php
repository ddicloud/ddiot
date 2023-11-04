<?php
/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-02 16:16:08
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-14 18:13:13
 */
 

namespace addons\diandi_integral\models;

use Yii;
use common\behaviors\SaveBehavior;

/**
 * This is the model class for table "dd_spec".
 *
 * @public int $spec_id
 * @public string $spec_name
 * @public int $wxapp_id
 * @public int $create_time
 */
class IntegralSpec extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%diandi_integral_spec}}';
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
    public function rules(): array
    {
        return [
            [['wxapp_id','bloc_id','store_id', 'create_time'], 'integer'],
            [['create_time'], 'required'],
            [['spec_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'spec_id' => 'Spec ID',
            'spec_name' => 'Spec Name',
            'wxapp_id' => 'Wxapp ID',
            'create_time' => 'Create Time',
        ];
    }
}
