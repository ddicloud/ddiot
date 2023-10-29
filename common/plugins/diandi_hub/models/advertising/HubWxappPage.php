<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-09 23:31:05
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-11-04 22:47:46
 */
 

namespace common\plugins\diandi_hub\models\advertising;

use Yii;

/**
 * This is the model class for table "dd_wxapp_page".
 *
 * @public int $page_id
 * @public int $page_type
 * @public string $page_data
 * @public int $wxapp_id
 * @public int $create_time
 * @public int $update_time
 */
class HubWxappPage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_wxapp_page}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['page_type', 'wxapp_id', 'create_time', 'update_time'], 'integer'],
            [['page_data'], 'required'],
            [['page_data'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'page_id' => 'Page ID',
            'page_type' => 'Page Type',
            'page_data' => 'Page Data',
            'wxapp_id' => 'Wxapp ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
