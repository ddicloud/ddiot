<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-09-16 14:45:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-09-24 17:13:26
 */


namespace common\plugins\diandi_website\models;

use Yii;

/**
 * This is the model class for table "{{%diandi_website_contact}}".
 *
 * @public int $id
 * @public string|null $name 公司名称
 * @public string|null $mobile 联系电话
 * @public string|null $phone 座机号码
 * @public string|null $email 邮箱
 * @public string|null $address 具体地址
 * @public string|null $intro 简介
 * @public string|null $logo 公司logo
 * @public string|null $wechat_code 公众号二维码
 * @public string|null $createtime
 * @public string|null $updatetime
 */
class WebsiteContact extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function  tableName(): string
    {
        return '{{%diandi_website_contact}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['intro'], 'string'],
            [['store_id', 'bloc_id'], 'integer'],
            [['name', 'address', 'logo', 'wechat_code', 'image'], 'string', 'max' => 255],
            [['mobile', 'phone'], 'string', 'max' => 15],
            [['email', 'fax', 'postcode', 'icp'], 'string', 'max' => 50],
            [['createtime', 'updatetime'], 'string', 'max' => 30],
        ];
    }

    /**
     * 行为.
     */
    public function behaviors(): array
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
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => '公司名称',
            'mobile' => '联系电话',
            'phone' => '座机号码',
            'email' => '邮箱',
            'address' => '具体地址',
            'intro' => '简介',
            'logo' => '公司logo',
            'image' => '配图',
            'fax' => '传真',
            'postcode' => '邮编',
            'icp' => '备案号',
            'wechat_code' => '公众号二维码',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
        ];
    }
}
