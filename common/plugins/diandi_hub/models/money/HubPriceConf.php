<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-01 15:17:08
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-11-04 23:13:47
 */

namespace common\plugins\diandi_hub\models\money;

/**
 * This is the model class for table "dd_diandi_hub_price_conf".
 *
 * @public int      $id
 * @public int|null $bloc_id     公司id
 * @public int|null $store_id    商户id
 * @public int|null $pricefield  价格字段
 * @public int|null $name        字段名称
 * @public int|null $level_id    等级id
 * @public int|null $group_id    分销商id
 * @public int|null $create_time 创建时间
 * @public int|null $update_time 更新时间
 */
class HubPriceConf extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dd_diandi_hub_price_conf';
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
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['bloc_id', 'store_id', 'is_use', 'level_id', 'group_id', 'create_time', 'update_time'], 'integer'],
            [['pricefield', 'name'], 'string'],
            [['pricefield'],'unique'],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bloc_id' => '公司id',
            'store_id' => '商户id',
            'pricefield' => '价格字段',
            'name' => '字段名称',
            'is_use' => '是否使用',
            'level_id' => '等级id',
            'group_id' => '分销商id',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}
