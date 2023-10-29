<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-04 23:11:51
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-11-04 23:12:01
 */
 

namespace common\plugins\diandi_hub\models\config;


use Yii;

/**
 * This is the model class for table "dd_diandi_hub_rules".
 *
 * @public int $id
 * @public int|null $bloc_id 公司ID
 * @public int|null $store_id 商户ID
 * @public int|null $goods_id 商品id
 * @public int|null $goods_spec_id 属性id
 * @public string|null $type 分销方式
 * @public int|null $group_id 分销商id
 * @public int|null $level_id 会员等级
 * @public float|null $money 分销参数
 * @public int|null $create_time 创建时间
 * @public int|null $update_time 更新时间
 */
class HubRules extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dd_diandi_hub_rules';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['bloc_id', 'store_id', 'goods_id', 'goods_spec_id', 'group_id', 'level_id', 'create_time', 'update_time'], 'integer'],
            [['type'], 'string'],
            [['money'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bloc_id' => '公司ID',
            'store_id' => '商户ID',
            'goods_id' => '商品id',
            'goods_spec_id' => '属性id',
            'type' => '分销方式',
            'group_id' => '分销商id',
            'level_id' => '会员等级',
            'money' => '分销参数',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}
