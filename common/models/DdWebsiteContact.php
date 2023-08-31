<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-14 08:15:56
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-05-06 22:29:22
 */

namespace common\models;

/**
 * This is the model class for table "dd_website_contact".
 *
 * @public int         $id
 * @public string|null $contact
 * @public string|null $createtime
 * @public string|null $updatetime
 */
class DdWebsiteContact extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%website_contact}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['createtime', 'updatetime'], 'safe'],
            [['contact', 'name','feedback'], 'string', 'max' => 255],
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
               'updatedAttribute' => 'createtime',
               'createdAttribute' => 'updatetime',
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
            'contact' => '联系方式',
            'name' => '姓名',
            'feedback'=>'留言内容',
            'createtime' => '联系时间',
            'updatetime' => '更新时间',
        ];
    }
}
