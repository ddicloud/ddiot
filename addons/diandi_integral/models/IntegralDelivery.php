<?php
/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-02 08:20:39
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-29 14:16:29
 */
 


namespace addons\diandi_integral\models;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use Yii;

/**
 * This is the model class for table "dd_delivery".
 *
 * @public int $delivery_id
 * @public string $name
 * @public int $method
 * @public int $sort
 * @public int $wxapp_id
 * @public int $create_time
 * @public int $update_time
 */
class IntegralDelivery extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%diandi_integral_delivery}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['bloc_id','store_id', 'sort', 'create_time', 'update_time'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
               'class'=>\common\behaviors\SaveBehavior::class,
               'updatedAttribute'=>'create_time',
               'createdAttribute'=>'update_time',
           ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'delivery_id' => 'Delivery ID',
            'name' => '模板名称',
            'bloc_id' => '公司ID',
            'store_id' => '商户ID',
            'sort' => '排序',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
