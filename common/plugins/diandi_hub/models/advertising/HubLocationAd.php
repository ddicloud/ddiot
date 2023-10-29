<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-11 00:53:56
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-01-10 14:31:19
 */
 

namespace common\plugins\diandi_hub\models\advertising;

use Yii;

/**
 * This is the model class for table "{{%diandi_hub_location_ad}}".
 *
 * @public int $id
 * @public int|null $store_id 商户id
 * @public int|null $bloc_id 公司id
 * @public string|null $thumb 图片
 * @public int|null $location_id 广告位id
 * @public string|null $mark 英文标记
 * @public int|null $is_show 是否显示
 */
class HubLocationAd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_location_ad}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['store_id', 'bloc_id', 'location_id', 'is_show','goods_id'], 'integer'],
            [['thumb', 'mark','url'], 'string', 'max' => 255],
            [['name'], 'string', 'max' =>50],
        ];
    }

    public function beforeSave($insert)
    {
        parent::beforeSave($insert);
        $list = HubLocation::find()->where(['id'=>$this->location_id])->one();
        $this->mark = $list['mark'];
        return true;
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

    public function getLocation()
    {
        return $this->hasOne(HubLocation::class,['id'=>'location_id']);
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
            'thumb' => '图片',
            'url' => '链接地址',
            'name' => '广告名称',
            'goods_id'=>'商品ID',
            'location_id' => '广告位id',
            'mark' => '英文标记',
            'is_show' => '是否显示',
        ];
    }
}
