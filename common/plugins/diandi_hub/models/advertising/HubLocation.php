<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-30 00:22:57
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-07-28 19:29:50
 */

namespace common\plugins\diandi_hub\models\advertising;

/**
 * This is the model class for table "{{%diandi_hub_location}}".
 *
 * @public int         $id
 * @public int|null    $store_id 商户id
 * @public int|null    $bloc_id  公司id
 * @public string|null $name     位置名称
 * @public int|null    $maxnum   显示数量
 * @public string|null $mark     英文标记
 * @public int|null    $is_show  是否显示
 */
class HubLocation extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_location}}';
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
            [['store_id', 'bloc_id', 'maxnum', 'is_show', 'displayorder', 'type', 'goods_id', 'is_show_thumb'], 'integer'],
            [['name', 'page', 'style'], 'string', 'max' => 50],
            [['mark', 'url', 'thumb'], 'string', 'max' => 255],
            ['mark', 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'store_id' => '商户id',
            'bloc_id' => '公司id',
            'name' => '位置名称',
            'maxnum' => '显示数量',
            'mark' => '英文标记',
            'is_show' => '是否显示',
            'page' => '页面',
            'style' => '排列样式',
            'displayorder' => '排序',
            'type' => '广告位类型',
            'thumb' => '广告图片',
            'is_show_thumb' => '是否显示广告图片',
            'goods_id' => '商品ID',
            'url' => '链接地址',
        ];
    }
}
