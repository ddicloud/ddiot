<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-12 17:49:24
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-08-31 10:14:50
 */


namespace common\models;

use Yii;

/**
 * This is the model class for table "dd_user_address".
 *
 * @public int $address_id
 * @public string $name
 * @public string $phone
 * @public int $province_id
 * @public int $city_id
 * @public int $region_id
 * @public string $detail
 * @public int $user_id
 * @public int $wxapp_id
 * @public int $create_time
 * @public int $update_time
 */
class DdUserAddress extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user_address}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['province_id', 'city_id', 'region_id', 'user_id', 'wxapp_id', 'create_time', 'update_time'], 'integer'],
            [['name'], 'string', 'max' => 30],
            [['phone'], 'string', 'max' => 20],
            [['detail', 'country'], 'string', 'max' => 255],
        ];
    }


    /* 获取分类 */
    public function getRegions()
    {
        return $this->hasOne(DdRegion::className(), ['id' => 'region_id']);
    }

    /* 获取分类 */
    public function getProvince()
    {
        return $this->hasOne(DdRegion::className(), ['id' => 'province_id']);
    }

    /* 获取分类 */
    public function getCity()
    {
        return $this->hasOne(DdRegion::className(), ['id' => 'city_id']);
    }

    /* 获取分类 */
    public function getRegion()
    {
        return $this->hasOne(DdRegion::className(), ['id' => 'region_id']);
    }

    /**
     * 行为
     */
    public function behaviors()
    {
        /*自动添加创建和修改时间*/
        return [
            [
                'class' => \common\behaviors\SaveBehavior::className(),
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
            'address_id' => 'Address ID',
            'name' => '收货人',
            'phone' => '联系电话',
            'country' => '国家',
            'province_id' => '省份',
            'city_id' => '城市',
            'region_id' => '区县',
            'detail' => '具体地址',
            'user_id' => '会员ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
