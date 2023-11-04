<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-14 14:03:55
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-26 11:47:33
 */


namespace addons\diandi_tea\models\member;

use Yii;

/**
 * This is the model class for table "{{%diandi_tea_member}}".
 *
 * @public int $id 人脸招聘
 * @public int $bloc_id 人脸库组id
 * @public int $store_id
 * @public string|null $create_time
 * @public string|null $update_time
 */
class DiandiTeaMember extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%diandi_tea_member}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
       
            [['bloc_id', 'store_id'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
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
                'time_type'=>'datetime'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => '人脸招聘',
            'bloc_id' => '人脸库组id',
            'store_id' => 'Store ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
