<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-02-21 10:15:36
 * @Last Modified by:   Radish minradish@163.com
 * @Last Modified time: 2022-07-28 16:40:44
 */

namespace common\plugins\diandi_hub\models\goods;

/**
 * This is the model class for table "{{%diandi_hub_goods}}".
 *
 * @public int         $id
 * @public int|null    $bloc_id     公司ID
 * @public int|null    $store_id    商户ID
 * @public int|null    $goods_id    商品ID
 * @public string|null $goods_name  商品名称
 * @public string|null $share_title 分销标题
 * @public string|null $share_desc  分销描述
 * @public string|null $share_img   分销描述
 * @public int|null    $type        分销类型
 * @public int|null    $create_time 创建时间
 * @public int|null    $update_time 更新时间
 */
class HubGoods extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_goods}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['bloc_id', 'store_id', 'goods_id', 'type', 'create_time', 'update_time'], 'integer'],
            [['one_options', 'two_options', 'three_options'], 'number'],
            [['goods_name', 'share_title', 'share_desc', 'share_img'], 'string', 'max' => 100],
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
            'goods_name' => '商品名称',
            'share_title' => '分销标题',
            'share_desc' => '分销描述',
            'share_img' => '分销描述',
            'type' => '分销类型',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }

    public function getGoods()
    {
        return $this->hasOne(HubGoodsBaseGoods::class, ['goods_id' => 'goods_id'])->select(['goods_id', 'goods_name']);
    }
}
