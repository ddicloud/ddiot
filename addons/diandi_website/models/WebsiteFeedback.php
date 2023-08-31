<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-09-16 11:53:43
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-09-16 11:58:58
 */


namespace addons\diandi_website\models;

use Yii;

/**
 * This is the model class for table "{{%diandi_website_feedback}}".
 *
 * @public int $id
 * @public string $subject
 * @public string $name
 * @public string $phone
 * @public string $email
 * @public string $body
 * @public int $created_at
 * @public int $updated_at
 */
class WebsiteFeedback extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_website_feedback}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
            [['subject'], 'string', 'max' => 125],
            [['name'], 'string', 'max' => 100],
            [['phone', 'email'], 'string', 'max' => 50],
            [['body'], 'string', 'max' => 255],
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
            'subject' => 'Subject',
            'name' => 'Name',
            'phone' => 'Phone',
            'email' => 'Email',
            'body' => 'Body',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
