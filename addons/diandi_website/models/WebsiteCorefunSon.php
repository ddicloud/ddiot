<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-22 10:23:24
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-27 16:28:02
 */


namespace addons\diandi_website\models;

use Yii;
use common\traits\ActiveQuery\StoreTrait;

/**
 * This is the model class for table "{{%diandi_website_pro_corefun_son}}".
 *
 * @public int $id
 * @public int|null $store_id
 * @public int|null $bloc_id
 * @public string|null $create_time
 * @public string|null $update_time
 * @public string|null $logo logo
 * @public string|null $title 标题
 * @public string|null $describe 描述
 * @public int|null $corefun_id 关联核心功能id
 * @public int|null $sort 排序
 */
class WebsiteCorefunSon extends \yii\db\ActiveRecord
{
    use StoreTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_website_pro_corefun_son}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['store_id', 'bloc_id', 'corefun_id', 'sort'], 'integer'],
            [['create_time', 'update_time'], 'string', 'max' => 30],
            [['logo', 'describe'], 'string', 'max' => 255],
            [['title'], 'string', 'max' => 100],
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
                'time_type' => 'datetime',
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
            'store_id' => 'Store ID',
            'bloc_id' => 'Bloc ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'logo' => 'logo',
            'title' => '标题',
            'describe' => '描述',
            'corefun_id' => '关联核心功能id',
            'sort' => '排序',
        ];
    }
}
