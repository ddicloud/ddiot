<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-07-13 08:45:20
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-08-11 07:35:24
 */

namespace addons\diandi_soot\models\article;

/**
 * This is the model class for table "dd_article_category".
 *
 * @public int    $id
 * @public string $title
 * @public int    $displayorder
 * @public string $type
 */
class DdArticleCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%website_article_category}}';
    }

    public function getArticle()
    {
        return $this->hasMany(DdArticle::className(), ['ccate' => 'id']);
    }

    public function getCate()
    {
        return $this->hasOne(DdArticle::className(), ['ccate' => 'id']);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'displayorder', 'type'], 'required'],
            [['displayorder', 'pcate'], 'integer'],
            [['title'], 'string', 'max' => 30],
            [['type'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '分类名称',
            'displayorder' => '排序',
            'type' => '类型',
            'pcate' => '父级id',
        ];
    }
}
