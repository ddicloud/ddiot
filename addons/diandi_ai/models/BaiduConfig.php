<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-09-19 09:03:55
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-09-19 09:05:51
 */

namespace addons\diandi_ai\models;

/**
 * This is the model class for table "{{%diandi_ai_baidu_config}}".
 *
 * @public int         $id
 * @public int|null    $bloc_id     公司id
 * @public int|null    $store_id    商户id
 * @public string|null $APP_ID
 * @public string|null $API_KEY
 * @public string|null $SECRET_KEY
 * @public string|null $name        应用名称
 * @public int|null    $create_time 创建时间
 * @public int|null    $update_time 更新时间
 */
class BaiduConfig extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_ai_baidu_config}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bloc_id', 'store_id', 'create_time', 'update_time'], 'integer'],
            [['APP_ID', 'API_KEY', 'SECRET_KEY', 'name'], 'string', 'max' => 100],
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
            'bloc_id' => '公司id',
            'store_id' => '商户id',
            'APP_ID' => 'App ID',
            'API_KEY' => 'Api Key',
            'SECRET_KEY' => 'Secret Key',
            'name' => '应用名称',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}
