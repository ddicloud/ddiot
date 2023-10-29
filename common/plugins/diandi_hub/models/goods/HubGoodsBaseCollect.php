<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-02-06 12:54:05
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-21 19:27:16
 */

namespace common\plugins\diandi_hub\models\goods;

use common\plugins\diandi_integral\models\IntegralGoods;

/**
 * This is the model class for table "diandi_hub_goods_collect".
 *
 * @public int      $id
 * @public int|null $bloc_id
 * @public int|null $store_id
 * @public int|null $goods_type
 * @public int|null $goods_id    商品id
 * @public int|null $member_id   用户id
 * @public int|null $create_time 收藏时间
 * @public int|null $update_time
 */
class HubGoodsBaseCollect extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_basegoods_collect}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['bloc_id', 'store_id', 'goods_type', 'goods_id', 'member_id', 'create_time', 'update_time'], 'integer'],
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

    public function getGoods()
    {
        return $this->hasOne(HubGoodsBaseGoods::class, ['goods_id' => 'goods_id']);
        //return $this->hasOne(IntegralGoods::class, ['goods_id' => 'goods_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'bloc_id' => 'Bloc ID',
            'store_id' => 'Store ID',
            'goods_type' => 'Goods Type',
            'goods_id' => '商品id',
            'member_id' => '用户id',
            'create_time' => '收藏时间',
            'update_time' => 'Update Time',
        ];
    }
}
