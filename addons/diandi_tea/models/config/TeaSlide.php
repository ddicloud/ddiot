<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-25 15:11:46
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-26 11:47:00
 */


namespace addons\diandi_tea\models\config;

use common\traits\ActiveQuery\StoreTrait;
use Yii;

/**
 * This is the model class for table "{{%diandi_tea_slide}}".
 *
 * @public int $id 人脸招聘
 * @public int $bloc_id 人脸库组id
 * @public int $store_id
 * @public string|null $create_time
 * @public string|null $update_time
 * @public string|null $slide 轮播图
 * @public int|null $type 幻灯片类型: 1.商店头部幻灯片  2.商店中间幻灯片
 */
class TeaSlide extends \yii\db\ActiveRecord
{
    use StoreTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%diandi_tea_slide}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
     
            [['bloc_id', 'store_id', 'type'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['slide'], 'string', 'max' => 255],
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
            'slide' => '轮播图',
            'type' => '幻灯片类型: 1.商店头部幻灯片  2.商店中间幻灯片',
        ];
    }
}
