<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-12-07 00:11:55
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-16 17:18:16
 */

namespace common\plugins\diandi_hub\models\express;

/**
 * This is the model class for table "{{%diandi_hub_express_company}}".
 *
 * @public int         $id
 * @public string|null $title         名称
 * @public string|null $code          编码
 * @public int|null    $status        是否启用
 * @public int|null    $display_order 排序
 * @public int|null    $mobile        联系电话
 * @public string|null $link_man      联系人
 * @public int|null    $is_default    是否默认
 * @public int|null    $create_time
 * @public int|null    $update_time
 */
class HubExpressCompany extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_express_company}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['status', 'display_order', 'is_default', 'create_time', 'update_time'], 'integer'],
            [['title', 'code'], 'string', 'max' => 255],
            [['link_man'], 'string', 'max' => 30],
            [['mobile'], 'string', 'max' => 11],
        ];
    }

    /**
     * 行为.
     */
    public function behaviors()
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

    public function getTemplate()
    {
        return $this->hasOne(HubExpressTemplate::class, ['express_id' => 'id']);
    }

    public function getArea()
    {
        return $this->hasOne(HubExpressTemplateArea::class, ['express_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
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
        ];
    }
}
