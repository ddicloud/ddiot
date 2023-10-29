<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 16:36:48
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-11-04 22:46:39
 */


namespace common\plugins\diandi_hub\models\order;

use Yii;

/**
 * This is the model class for table "dd_order_address".
 *
 * @public int $order_address_id
 * @public string $name
 * @public string $phone
 * @public int $province_id
 * @public int $city_id
 * @public int $region_id
 * @public string $detail
 * @public int $order_id
 * @public int $user_id
 * @public int $create_time
 */
class HubOrderAddress extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_order_address}}';
    }

    /**
     * 行为
     */
    public function behaviors()
    {
        /*自动添加创建和修改时间*/
        return [
            [
                'class' => \common\behaviors\SaveBehavior::class,
                'updatedAttribute' => 'update_time',
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
            [['province_id','bloc_id','store_id', 'city_id', 'region_id', 'order_id', 'user_id', 'create_time', 'update_time'], 'integer'],
            [['name','delivery_time'], 'string', 'max' => 30],
            [['phone'], 'string', 'max' => 20],
            [['detail'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'order_address_id' => 'Order Address ID',
            'name' => '姓名',
            'phone' => '联系方式',
            'province_id' => '省份',
            'city_id' => '城市',
            'region_id' => '区县',
            'detail' => '地址详情',
            'order_id' => '订单ID',
            'user_id' => '用户ID',
            'delivery_time'=>'送货时间',
            'create_time' => 'Create Time',
            'update_time' => 'update_time'
        ];
    }
}
