<?php
/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-02 16:16:00
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-11-04 23:11:35
 */
 

namespace common\plugins\diandi_hub\models\advertising;

use Yii;

/**
 * This is the model class for table "dd_wxapp".
 *
 * @public int $wxapp_id
 * @public string $app_name
 * @public string $app_id
 * @public string $app_secret
 * @public int $is_service
 * @public int $service_image_id
 * @public int $is_phone
 * @public string $phone_no
 * @public int $phone_image_id
 * @public string $mchid
 * @public string $apikey
 * @public int $create_time
 * @public int $update_time
 */
class HubWxapp extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_hub_wxapp}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['is_service', 'service_image_id', 'is_phone', 'phone_image_id', 'create_time', 'update_time'], 'integer'],
            [['app_name', 'app_id', 'app_secret', 'mchid'], 'string', 'max' => 50],
            [['phone_no'], 'string', 'max' => 20],
            [['apikey'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'wxapp_id' => 'Wxapp ID',
            'app_name' => 'App Name',
            'app_id' => 'App ID',
            'app_secret' => 'App Secret',
            'is_service' => 'Is Service',
            'service_image_id' => 'Service Image ID',
            'is_phone' => 'Is Phone',
            'phone_no' => 'Phone No',
            'phone_image_id' => 'Phone Image ID',
            'mchid' => 'Mchid',
            'apikey' => 'Apikey',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
