<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-07-29 01:55:39
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-01-01 17:23:08
 */
 

namespace common\components\FileUpload\models;

use Yii;

/**
 * This is the model class for table "dd_upload_file_used".
 *
 * @property int $used_id
 * @property int $file_id
 * @property int $from_id
 * @property string $from_type
 * @property int $wxapp_id
 * @property int $create_time
 */
class DdUploadFileUsed extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%upload_file_used}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['file_id', 'from_id', 'create_time','bloc_id', 'store_id','user_id'], 'integer'],
            [['from_type'], 'string', 'max' => 20],
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
            'user_id' => 'user_id',
            'file_id' => 'File ID',
            'from_id' => 'From ID',
            'from_type' => 'From Type',
            'bloc_id' => 'bloc_id',
            'create_time' => 'Create Time',
        ];
    }
}
