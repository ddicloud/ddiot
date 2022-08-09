<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-09-23 09:16:05
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-09-23 15:27:16
 */


namespace addons\diandi_website\models;

use Yii;

/**
 * This is the model class for table "{{%diandi_website_nav}}".
 *
 * @property int $id
 * @property string $name 名称
 * @property int $parent 父级
 * @property string|null $link 链接地址
 * @property int $order 排序
 * @property resource|null $data 数据
 * @property string|null $type 导航类型
 * @property string|null $icon 图标
 * @property int|null $is_show 是否显示
 * @property int|null $store_id 商户
 * @property int|null $bloc_id 公司
 * @property int|null $create_time 创建时间
 * @property int|null $update_time 更新时间
 */
class Nav extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_website_nav}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'parent'], 'required'],
            [['parent', 'order', 'is_show', 'store_id', 'bloc_id', 'create_time', 'update_time'], 'integer'],
            [['data'], 'string'],
            [['name'], 'string', 'max' => 128],
            [['link'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 20],
            [['icon'], 'string', 'max' => 30],
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
            'name' => '名称',
            'parent' => '父级',
            'link' => '链接地址',
            'order' => '排序',
            'data' => '数据',
            'type' => '导航类型',
            'icon' => '图标',
            'is_show' => '是否显示',
            'store_id' => '商户',
            'bloc_id' => '公司',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}
