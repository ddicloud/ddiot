<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-11 18:19:15
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-22 17:39:02
 */


namespace common\plugins\diandi_hub\models\pickup;

use Yii;

/**
 * This is the model class for table "dd_shop_areas".
 *
 * @public int $area_id 区域id
 * @public string $area_name 区域名称
 * @public int $create_time 创建时间
 * @public string|null $address 具体地址
 * @public string|null $logo 配送点标志
 * @public int|null $status 配送点状态
 * @public float|null $freight 运费
 * @public int|null $province_id 省份
 * @public int|null $city_id 城市
 * @public int|null $region_id 区县
 */
class HubShopAreas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_areas}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['create_time','bloc_id','store_id', 'update_time', 'status', 'province_id', 'city_id','is_default', 'region_id'], 'integer'],
            [['freight'], 'number'],
            [['area_name', 'address', 'logo'], 'string', 'max' => 255],
        ];
    }

    /**
     * 行为
     */
    public function behaviors()
    {
        /*自动添加创建和修改时间*/
        return [
            [
                'class' => \common\behaviors\SaveBehavior::class,
                'updatedAttribute' => 'create_time',
                'createdAttribute' => 'update_time',
            ]
        ];
    }



    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'area_id' => '配送点ID',
            'area_name' => '配送点名称',
            'create_time' => '创建时间',
            'address' => '具体地址',
            'logo' => '配送点标志',
            'status' => '配送点状态',
            'freight' => '运费',
            'province_id' => '省份',
            'city_id' => '城市',
            'is_default'=>'是否默认',
            'region_id' => '区县',
        ];
    }
}
