<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-07-11 01:54:19
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-02-05 21:25:29
 */
 

namespace common\plugins\diandi_hub\models\goods;

use common\plugins\diandi_hub\models\goods\HubGoodsBaseGoods;
use Yii;

/**
 * This is the model class for table "dd_diandi_hub_gift".
 *
 * @public int $id
 * @public int|null $bloc_id 公司ID
 * @public int|null $store_id 商户ID
 * @public int|null $goods_id 商品ID
 * @public float|null $gift_price 礼包价格
 * @public string|null $thumb 礼包主图
 * @public string|null $images 礼包相册
 * @public int|null $level_num 礼包对应的会员等级
 * @public string|null $content 礼包介绍
 * @public int|null $create_time 创建时间
 * @public int|null $update_time 更新时间
 */
class HubGift extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dd_diandi_hub_gift';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['bloc_id','cate', 'store_id', 'goods_id', 'level_num', 'create_time', 'update_time'], 'integer'],
            [['gift_price','performance'], 'number'],
            [['content'], 'string'],
            [['images'], 'required'],
            [['thumb'], 'string', 'max' => 255],
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert))
        {
            if(is_array($this->images))
            {
               //字段
                $this->images=serialize($this->images);
            }
            return true;
        }
        else
            return false;
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

    public function getGoods()
    {
        return $this->hasOne(HubGoodsBaseGoods::class,['goods_id'=>'goods_id']);
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
            'gift_price' => '礼包价格',
            'thumb' => '礼包主图',
            'images' => '礼包相册',
            'cate' => '分类',
            'performance'=> '业绩',
            'level_num' => '礼包对应的会员等级',
            'content' => '礼包介绍',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}
