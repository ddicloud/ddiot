<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-17 11:30:51
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-13 10:01:18
 */

namespace addons\diandi_tea\models\marketing;

/**
 * This is the model class for table "{{%diandi_tea_set_meal}}".
 *
 * @public int         $id          包间套餐id
 * @public int         $bloc_id     人脸库组id
 * @public int         $store_id
 * @public string|null $create_time
 * @public string|null $update_time
 * @public string|null $title       套餐名
 * @public float|null  $duration    套餐时长
 * @public float|null  $price       套餐价格
 * @public float|null  $renew_price 每半小时续费单价
 * @public int|null    $type        套餐类型：1.小时套餐  2.计时套餐
 */
class TeaSetMeal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%diandi_tea_set_meal}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['type'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['price', 'duration', 'renew_price'], 'number'],
            [['title'], 'string', 'max' => 100],
            [['details'], 'string'],
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
            'id' => '包间套餐id',
            'bloc_id' => '人脸库组id',
            'store_id' => 'Store ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'title' => '套餐名',
            'duration' => '套餐时长',
            'price' => '套餐价格',
            'renew_price' => '每半小时续费单价',
            'type' => '套餐类型：1.小时套餐  2.计时套餐',
            'details' => '详情',
        ];
    }
}
