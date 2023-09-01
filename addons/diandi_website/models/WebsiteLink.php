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
 * @public int $id
 * @public string|null $name 公司名称
 * @public string|null $intro 简介
 * @public string|null $logo 公司logo
 * @public string|null $wechat_code 公众号二维码
 * @public string|null $image 显示图片
 * @public string|null $link 链接地址
 * @public int|null $store_id
 * @public int|null $bloc_id
 * @public string|null $createtime
 * @public string|null $updatetime
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
    public function rules(): array
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
                'class' => \common\behaviors\SaveBehavior::class,
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
