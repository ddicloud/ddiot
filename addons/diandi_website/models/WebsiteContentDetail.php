<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-09-16 11:53:18
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-09-16 11:58:25
 */


namespace addons\diandi_website\models;

use Yii;

/**
 * This is the model class for table "{{%diandi_website_content_detail}}".
 *
 * @property int $id
 * @property int $content_id
 * @property string $detail
 * @property string $params
 * @property string $file_url
 * @property int|null $created_at
 * @property int|null $updated_at
 */
class WebsiteContentDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_website_content_detail}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content_id', 'detail'], 'required'],
            [['content_id', 'created_at', 'updated_at'], 'integer'],
            [['detail'], 'string'],
            [['params'], 'string', 'max' => 1000],
            [['file_url'], 'string', 'max' => 255],
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
            'content_id' => 'Content ID',
            'detail' => 'Detail',
            'params' => 'Params',
            'file_url' => 'File Url',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
