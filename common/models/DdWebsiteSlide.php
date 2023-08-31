<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-07-29 01:56:50
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-05-06 22:28:02
 */
 

namespace common\models;

use Yii;

/**
 * This is the model class for table "dd_website_slide".
 *
 * @public int $id
 * @public string|null $images
 * @public string|null $title
 * @public string|null $description
 * @public string|null $menuname
 * @public string|null $menuurl
 * @public string|null $createtime
 * @public string|null $updatetime
 */
class DdWebsiteSlide extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%website_slide}}';
    }

    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['createtime', 'updatetime'], 'safe'],
            [['images', 'title', 'description', 'menuname', 'menuurl'], 'string', 'max' => 255],
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
               'updatedAttribute' => 'updatetime',
               'createdAttribute' => 'createtime',
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
            'images' => '图片',
            'title' => '标题',
            'description' => '描述',
            'menuname' => '按钮名称',
            'menuurl' => '按钮地址',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
        ];
    }
}
