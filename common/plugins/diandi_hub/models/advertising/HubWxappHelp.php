<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-09 23:33:12
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-11-04 22:47:37
 */
 

namespace common\plugins\diandi_hub\models\advertising;

use Yii;

/**
 * This is the model class for table "dd_wxapp_help".
 *
 * @public int $help_id
 * @public string $title
 * @public string $content
 * @public int $sort
 * @public int $wxapp_id
 * @public int $create_time
 * @public int $update_time
 */
class HubWxappHelp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_wxapp_help}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['content'], 'required'],
            [['content'], 'string'],
            [['sort', 'wxapp_id', 'create_time', 'update_time'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'help_id' => 'Help ID',
            'title' => 'Title',
            'content' => 'Content',
            'sort' => 'Sort',
            'wxapp_id' => 'Wxapp ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
