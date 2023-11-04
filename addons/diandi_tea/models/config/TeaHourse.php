<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-16 15:05:17
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-07-02 16:04:29
 */

namespace addons\diandi_tea\models\config;

use addons\diandi_tea\models\order\TeaCouponList;
use addons\diandi_tea\models\order\TeaOrderList;
use common\helpers\DateHelper;

/**
 * This is the model class for table "{{%diandi_tea_hourse}}".
 *
 * @public int         $id           包间id
 * @public int         $bloc_id      人脸库组id
 * @public int         $store_id     店铺id
 * @public string|null $create_time
 * @public string      $update_time
 * @public string      $name         包间名
 * @public string|null $picture      包间图片
 * @public string|null $introduce    包间介绍
 * @public int|null    $max_num      可容纳人数
 * @public string|null $tip          包间说明
 * @public int|null    $status       包间状态：1.空闲中 2.待打扫 3.待客中
 * @public string|null $set_meal_ids 包间套餐列表
 * @public string|null $fit_num      包间适合人数
 */
class TeaHourse extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%diandi_tea_hourse}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['price'], 'number'],
            [['bloc_id', 'store_id', 'max_num', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['name', 'set_meal_ids', 'fit_num'], 'string', 'max' => 100],
            [['picture'], 'string', 'max' => 255],
            [['introduce', 'tip', 'slide'], 'string'],
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

    public function getOrder(): \yii\db\ActiveQuery
    {
        $today = DateHelper::today();
        $whereTime = ['between', 'start_time', date('Y-m-d H:i:s', $today['start']), date('Y-m-d H:i:s', $today['end'])];
        return $this->hasMany(TeaOrderList::class,['hourse_id'=>'id'])->where(['status'=>2])->andWhere($whereTime);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => '包间id',
            'bloc_id' => '人脸库组id',
            'store_id' => '店铺id',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'name' => '包间名',
            'picture' => '包间图片',
            'introduce' => '包间介绍',
            'max_num' => '可容纳人数',
            'tip' => '包间说明',
            'status' => '包间状态：1.空闲中 2.待打扫 3.待客中',
            'set_meal_ids' => '包间套餐列表',
            'fit_num' => '包间适合人数',
            'slide' => '包间幻灯片',
        ];
    }
}
