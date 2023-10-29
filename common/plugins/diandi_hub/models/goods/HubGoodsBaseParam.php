<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-03 22:40:41
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-22 15:29:04
 */

namespace common\plugins\diandi_hub\models\goods;

/**
 * This is the model class for table "dd_goods_param".
 *
 * @public int         $id
 * @public int|null    $goods_id     商品id
 * @public string|null $title        属性名称
 * @public string|null $value        属性值
 * @public int|null    $displayorder 排序
 */
class HubGoodsBaseParam extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_basegoods_param}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['goods_id', 'bloc_id', 'store_id', 'displayorder'], 'integer'],
            [['value'], 'string'],
            [['title'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goods_id' => 'Goods ID',
            'title' => 'Title',
            'value' => 'Value',
            'displayorder' => 'Displayorder',
        ];
    }
}
