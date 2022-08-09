<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-09-24 10:45:06
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-09-24 14:04:07
 */


namespace addons\diandi_website\models;

use Yii;

/**
 * This is the model class for table "{{%diandi_website_link}}".
 *
 * @property int $id
 * @property string|null $name 公司名称
 * @property string|null $intro 简介
 * @property string|null $logo 公司logo
 * @property string|null $wechat_code 公众号二维码
 * @property string|null $image 显示图片
 * @property string|null $link 链接地址
 * @property int|null $store_id
 * @property int|null $bloc_id
 * @property string|null $createtime
 * @property string|null $updatetime
 */
class WebsiteLink extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_website_link}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['intro'], 'string'],
            [['store_id', 'bloc_id'], 'integer'],
            [['name', 'logo', 'wechat_code', 'image', 'link'], 'string', 'max' => 255],
            [['createtime', 'updatetime'], 'string', 'max' => 30],
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
                'class' => \common\behaviors\SaveBehavior::className(),
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
            'name' => '公司名称',
            'intro' => '简介',
            'logo' => '公司logo',
            'wechat_code' => '公众号二维码',
            'image' => '显示图片',
            'link' => '链接地址',
            'store_id' => 'Store ID',
            'bloc_id' => 'Bloc ID',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
        ];
    }
}
