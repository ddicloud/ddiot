<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-17 09:36:05
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-23 15:03:01
 */

namespace addons\diandi_tea\models\marketing;

/**
 * This is the model class for table "{{%diandi_tea_coupon}}".
 *
 * @public int         $id           卡券id
 * @public int         $bloc_id      人脸库组id
 * @public int         $store_id
 * @public string|null $create_time
 * @public string|null $update_time
 * @public string      $name         卡券名称
 * @public string|null $explain      卡券说明
 * @public int|null    $type         卡券类型  1：代金券 2：时长卡  3：次卡 4：折扣券 5：体验券
 * @public float|null  $price        卡券价格
 * @public string|null $use_start    时间限制-开始时间
 * @public string|null $use_end      时间限制-结束时间
 * @public string|null $enable_start 有效期开始时间
 * @public string|null $enable_end   有效期结束时间
 * @public int|null    $use_num      使用次数
 * @public string|null $max_time     消费时长
 * @public string|null $enable_store 适用店铺
 * @public string|null $enable_week  适用星期(分别对应1~7）
 * @public string|null $third_party  第三方编号
 * @public int|null    $all_num      总发放量
 * @public int|null    $max_num      最多可购买数量
 * @public float|null  $cash         代金券金额
 * @public float       $discount     折扣券折扣
 * @public float       $coupon_img   卡券图片
 */
class TeaCoupon extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%diandi_tea_coupon}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['bloc_id', 'store_id', 'type', 'use_num', 'all_num', 'max_num', 'num_sort', 'meal_type'], 'integer'],
            [['create_time', 'update_time', 'use_start', 'use_end', 'enable_start', 'enable_end'], 'safe'],
            [['price', 'cash', 'discount'], 'number'],
            [['name', 'max_time', 'enable_store', 'third_party'], 'string', 'max' => 100],
            [['explain', 'enable_week', 'background', 'coupon_img', 'use_hourse'], 'string', 'max' => 255],
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
            'id' => '卡券id',
            'bloc_id' => '人脸库组id',
            'store_id' => 'Store ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'name' => '卡券名称',
            'explain' => '卡券说明',
            'type' => '卡券类型  1：代金券 2：时长卡  3：次卡 4：折扣券 5：体验券',
            'price' => '卡券价格',
            'use_start' => '时间限制-开始时间',
            'use_end' => '时间限制-结束时间',
            'enable_start' => '有效期开始时间',
            'enable_end' => '有效期结束时间',
            'use_num' => '已使用数量',
            'max_time' => '消费时长',
            'enable_store' => '适用店铺',
            'enable_week' => '适用星期(分别对应1~7）',
            'third_party' => '第三方编号',
            'all_num' => '总发放量',
            'max_num' => '最多可购买数量',
            'cash' => '代金券金额',
            'discount' => '折扣券折扣',
            'coupon_img' => '卡券图片',
            'use_hourse' => '使用房间',
        ];
    }
}
