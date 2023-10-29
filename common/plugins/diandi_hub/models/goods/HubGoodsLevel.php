<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-02-25 19:39:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-25 19:47:54
 */

namespace common\plugins\diandi_hub\models\goods;

/**
 * This is the model class for table "{{%diandi_hub_goods_level}}".
 *
 * @public int        $id
 * @public int|null   $bloc_id     公司ID
 * @public int|null   $store_id    商户ID
 * @public int|null   $goods_id    商品ID
 * @public int|null   $dis_id      分销活动ID
 * @public int|null   $level_num   会员等级
 * @public int|null   $team_num    团队等级
 * @public float|null $dis_option  分销参数
 * @public int|null   $create_time 创建时间
 * @public int|null   $update_time 更新时间
 */
class HubGoodsLevel extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_goods_level}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['bloc_id', 'store_id', 'goods_id', 'dis_id', 'level_num', 'team_num', 'create_time', 'update_time'], 'integer'],
            [['dis_option'], 'number'],
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

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bloc_id' => '公司ID',
            'store_id' => '商户ID',
            'goods_id' => '商品ID',
            'dis_id' => '分销活动ID',
            'level_num' => '会员等级',
            'team_num' => '团队等级',
            'dis_option' => '分销参数',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}
