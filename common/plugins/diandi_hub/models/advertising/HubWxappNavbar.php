<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-09 23:32:51
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-11-04 22:47:42
 */
 

namespace common\plugins\diandi_hub\models\advertising;

use Yii;

/**
 * This is the model class for table "dd_wxapp_navbar".
 *
 * @public int $wxapp_id
 * @public string $wxapp_title
 * @public int $top_text_color
 * @public string $top_background_color
 * @public int $create_time
 * @public int $update_time
 */
class HubWxappNavbar extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_wxapp_navbar}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['wxapp_id'], 'required'],
            [['wxapp_id', 'top_text_color', 'create_time', 'update_time'], 'integer'],
            [['wxapp_title'], 'string', 'max' => 100],
            [['top_background_color'], 'string', 'max' => 10],
            [['wxapp_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'wxapp_id' => 'Wxapp ID',
            'wxapp_title' => 'Wxapp Title',
            'top_text_color' => 'Top Text Color',
            'top_background_color' => 'Top Background Color',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
