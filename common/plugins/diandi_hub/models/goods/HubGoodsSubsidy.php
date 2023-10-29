<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-02-21 10:15:36
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-01 15:16:50
 */


namespace common\plugins\diandi_hub\models\goods;

use Yii;

/**
 * This is the model class for table "{{%diandi_hub_goods_subsidy}}".
 *
 * @public int $id
 * @public int|null $store_id
 * @public int|null $bloc_id
 * @public int $goods_id
 * @public float|null $integral_redio 积分补贴比例
 * @public float|null $credit1 credit1返利
 * @public float|null $credit2 credit2返利
 * @public float|null $credit3 credit3返利
 * @public float|null $credit4 credit4返利
 * @public float|null $credit5 credit5返利
 * @public int $create_time 创建时间
 * @public int|null $update_time 更新时间
 */
class HubGoodsSubsidy extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_goods_subsidy}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['store_id', 'bloc_id', 'goods_id', 'create_time', 'update_time'], 'integer'],
            [['integral_redio', 'credit1', 'credit2', 'credit3', 'credit4', 'credit5'], 'number'],
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
            'store_id' => 'Store ID',
            'bloc_id' => 'Bloc ID',
            'goods_id' => 'Goods ID',
            'integral_redio' => '积分补贴比例',
            'credit1' => 'credit1返利',
            'credit2' => 'credit2返利',
            'credit3' => 'credit3返利',
            'credit4' => 'credit4返利',
            'credit5' => 'credit5返利',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}
