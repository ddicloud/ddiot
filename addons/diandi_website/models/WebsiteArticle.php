<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-09-16 11:51:03
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-27 16:10:14
 */


namespace addons\diandi_website\models;

use Yii;

/**
 * This is the model class for table "{{%diandi_website_article}}".
 *
 * @property int $id
 * @property int $ishot
 * @property int $pcate
 * @property int $ccate
 * @property string $template
 * @property string $title
 * @property string $description
 * @property string $content
 * @property string $thumb
 * @property int $incontent
 * @property string $source
 * @property string $author
 * @property int $displayorder
 * @property string $linkurl
 * @property int $createtime
 * @property int $edittime
 * @property string|null $icon
 */
class WebsiteArticle extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_website_article}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ishot', 'pcate', 'ccate', 'template', 'title', 'description', 'content', 'thumb', 'source', 'author', 'displayorder', 'linkurl', 'is_top'], 'required'],
            [['ishot', 'pcate', 'ccate',  'displayorder', 'create_time', 'update_time', 'bloc_id', 'store_id'], 'integer'],
            [['content'], 'string'],
            [['template'], 'string', 'max' => 300],
            [['title', 'description'], 'string', 'max' => 100],
            [['thumb', 'source'], 'string', 'max' => 255],
            [['author', 'type'], 'string', 'max' => 50],
            [['linkurl'], 'string', 'max' => 500],
            [['icon'], 'string', 'max' => 30],
            // ['is_top', 'in', 'range' => [-1, 1], 'message' => '是否置顶只能是\'-1\',或者\'1\''],
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
                'updatedAttribute' => 'create_time',
                'createdAttribute' => 'update_time',
            ],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->pcate) {
                //字段
                $this->type = WebsiteArticleCategory::find()->where(['id' => $this->pcate])->select('type')->scalar();
            }
            return true;
        } else {
            return false;
        }
    }

    public function getCate()
    {
        return $this->hasOne(WebsiteArticleCategory::className(), ['id' => 'pcate']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ishot' => 'Ishot',
            'pcate' => 'Pcate',
            'ccate' => 'Ccate',
            'template' => 'Template',
            'title' => 'Title',
            'description' => 'Description',
            'content' => 'Content',
            'thumb' => 'Thumb',
            'source' => 'Source',
            'author' => 'Author',
            'displayorder' => 'Displayorder',
            'linkurl' => 'Linkurl',
            'create_time' => 'Createtime',
            'update_time' => 'Edittime',
            'icon' => 'Icon',
            'is_top' => '是否置顶',
        ];
    }
}
