<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-05-19 15:59:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-13 10:08:47
 */

namespace admin\models\auth;

use diandi\addons\models\DdAddons;
use diandi\admin\acmodels\AuthItem;

/**
 * This is the model class for table "{{%auth_route}}".
 *
 * @public int           $id
 * @public string        $name
 * @public int           $type
 * @public string|null   $description
 * @public string|null   $title
 * @public int|null      $pid
 * @public resource|null $data
 * @public string|null   $module_name
 * @public int|null      $created_at
 * @public int|null      $updated_at
 */
class AuthRoute extends \yii\db\ActiveRecord
{
    public array $route_types = ['根路由', '页面路由', '按钮路由', '接口路由'];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%auth_route}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'is_sys', 'route_name'], 'required'],
            [['is_sys', 'pid', 'route_type', 'item_id', 'created_at', 'updated_at'], 'integer'],
            [['description', 'data'], 'string'],
            [['name', 'title', 'route_name'], 'string', 'max' => 255],
            [['module_name'], 'string', 'max' => 50],
            [['name', 'route_name'], 'unique'],
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

    public function getAddons()
    {
        return $this->hasOne(DdAddons::className(), ['identifie' => 'module_name']);
    }

    public function getItem()
    {
        return $this->hasOne(AuthItem::className(), ['id' => 'item_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'is_sys' => 'Is_sys',
            'description' => 'Description',
            'title' => 'Title',
            'item_id' => 'Item_id',
            'pid' => 'Pid',
            'data' => 'Data',
            'route_type' => '路由类型',
            'route_name' => '路由名称',
            'module_name' => 'Module Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
