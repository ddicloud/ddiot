<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-07-29 01:51:01
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-09-19 09:35:43
 */

namespace addons\diandi_ai\models;

/**
 * This is the model class for table "dd_ai_applications".
 *
 * @property int         $id
 * @property string|null $name        人脸库应用名称
 * @property string|null $appid       appid
 * @property string|null $create_time
 * @property string|null $updatetime
 */
class DdAiApplications extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_ai_applications}}';
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
               'updatedAttribute' => 'create_time',
               'createdAttribute' => 'updatetime',
           ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['create_time', 'updatetime'], 'safe'],
            [['name', 'APP_ID', 'API_KEY', 'SECRET_KEY'], 'string', 'max' => 50],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '应用名称',
            'APP_ID' => 'APP_ID',
            'API_KEY' => 'API_KEY',
            'SECRET_KEY' => 'SECRET_KEY',
            'create_time' => '创建时间',
            'updatetime' => '更新时间',
        ];
    }
}
