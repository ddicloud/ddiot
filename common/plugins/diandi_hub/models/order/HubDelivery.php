<?php
/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-02 08:20:39
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-11-04 23:13:59
 */
 


namespace common\plugins\diandi_hub\models\order;

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
class HubDelivery extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_delivery}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['method','bloc_id','store_id', 'sort', 'wxapp_id', 'create_time', 'update_time'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * 行为
     */
    public function behaviors()
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
    public function attributeLabels()
    {
        return [
            'delivery_id' => 'Delivery ID',
            'name' => '模板名称',
            'method' => '计费方式',
            'sort' => '排序',
//            'wxapp_id' => 'Wxapp ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
