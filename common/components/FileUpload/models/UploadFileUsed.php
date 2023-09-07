<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-21 22:02:36
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-26 16:17:25
 */

namespace common\components\FileUpload\models;

/**
 * This is the model class for table "dd_upload_file_used".
 *
 * @property int        $used_id     用户id
 * @property int        $file_id     文件id
 * @property int        $bloc_id     公司id
 * @property int|null   $store_id    商户id
 * @property int        $create_time 创建时间
 * @property UploadFile $file
 */
class UploadFileUsed extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%user_upload_file}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['file_id', 'bloc_id', 'store_id', 'create_time'], 'integer'],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => UploadFile::class, 'targetAttribute' => ['file_id' => 'file_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'used_id' => '用户id',
            'file_id' => '文件id',
            'bloc_id' => '公司id',
            'store_id' => '商户id',
            'create_time' => '创建时间',
        ];
    }

    /**
     * Gets a query for [[File]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFile(): \yii\db\ActiveQuery
    {
        return $this->hasOne(UploadFile::className(), ['file_id' => 'file_id']);
    }
}
