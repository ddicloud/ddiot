<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-06-30 00:23:25
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-09 18:50:24
 */
 

namespace common\plugins\diandi_hub\models\advertising;

use Codeception\Lib\Generator\Shared\Classname;
use common\plugins\diandi_hub\models\goods\HubGoods;
use common\plugins\diandi_hub\models\goods\HubGoodsBaseGoods;
use Yii;

/**
 * This is the model class for table "{{%diandi_hub_location_goods}}".
 *
 * @public int $id
 * @public int|null $store_id 商户id
 * @public int|null $bloc_id 公司id
 * @public int|null $goods_id 商品id
 * @public int|null $location_id 广告位id
 * @public string|null $mark 英文标记
 * @public int|null $is_show 是否显示
 */
class HubLocationGoods extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_location_goods}}';
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

    
    public function getLocation()
    {
        return $this->hasOne(HubLocation::class,['id'=>'location_id']);
    }
    
    public function getGoods()
    {
        return $this->hasOne(HubGoodsBaseGoods::class,['goods_id'=>'goods_id']);
    }

    public function getDisgoods()
    {
        return $this->hasOne(HubGoods::class,['goods_id'=>'goods_id']);
    }

    
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['store_id', 'bloc_id', 'goods_id', 'location_id', 'is_show','displayorder'], 'integer'],
            [['mark'], 'string', 'max' => 255],
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
            'goods_id' => '商品id',
            'location_id' => '广告位id',
            'mark' => '英文标记',
            'displayorder'=> '排序',
            'is_show' => '是否显示',
        ];
    }
}
