<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-03-30 10:34:57
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-03-30 11:02:01
 */


namespace addons\diandi_integral\models;

use Yii;

/**
 * This is the model class for table "{{%diandi_integral_company}}".
 *
 * @public int $id
 * @public string|null $title 名称
 * @public string|null $code 编码
 * @public int|null $status 是否启用
 * @public int|null $display_order 排序
 * @public string|null $mobile 联系电话
 * @public string|null $link_man 联系人
 * @public int|null $is_default 是否默认
 * @public int|null $create_time
 * @public int|null $update_time
 * @public int|null $store_id
 * @public int|null $bloc_id
 */
class IntegralCompany extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%diandi_integral_company}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['status', 'display_order', 'is_default', 'create_time', 'update_time', 'store_id', 'bloc_id'], 'integer'],
            [['title', 'code'], 'string', 'max' => 255],
            [['mobile'], 'string', 'max' => 20],
            [['link_man'], 'string', 'max' => 30],
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
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'title' => '名称',
            'code' => '编码',
            'status' => '是否启用',
            'display_order' => '排序',
            'mobile' => '联系电话',
            'link_man' => '联系人',
            'is_default' => '是否默认',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'store_id' => 'Store ID',
            'bloc_id' => 'Bloc ID',
        ];
    }
}
