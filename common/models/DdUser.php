<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-04-13 16:25:31
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-02 09:32:30
 */

namespace common\models;

/**
 * This is the model class for table "dd_user".
 *
 * @public int    $user_id
 * @public string $open_id
 * @public string $nickName
 * @public string $avatarUrl
 * @public int    $gender
 * @public string $country
 * @public string $province
 * @public string $city
 * @public int    $address_id
 * @public int    $wxapp_id
 * @public int    $create_time
 * @public int    $update_time
 */
class DdUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gender', 'address_id', 'wxapp_id', 'create_time', 'update_time', 'is_login'], 'integer'],
            [['open_id', 'nickName', 'avatarUrl'], 'string', 'max' => 255],
            [['country', 'province', 'city', 'last_login_ip'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'is_login' => '是否登录',
            'last_login_ip' => '最后登录ip',
            'user_id' => 'User ID',
            'open_id' => 'Open ID',
            'nickName' => 'Nick Name',
            'avatarUrl' => 'Avatar Url',
            'gender' => 'Gender',
            'country' => 'Country',
            'province' => 'Province',
            'city' => 'City',
            'address_id' => 'Address ID',
            'wxapp_id' => 'Wxapp ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
