<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-21 22:57:50
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-01-01 16:49:34
 */
 

namespace common\components\FileUpload\models;

use diandi\addons\models\Bloc;
use diandi\addons\models\BlocStore;
use Yii;

/**
 * This is the model class for table "dd_upload_file_group".
 *
 * @property int $group_id 分组ID
 * @property int $user_id 用户ID
 * @property int|null $store_id 商户ID
 * @property int $bloc_id 公司ID
 * @property int $create_time 创建时间
 *
 * @property UploadFile[] $uploadFiles
 */
class UploadFileGroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%upload_file_group}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['user_id', 'store_id', 'bloc_id', 'create_time'], 'integer'],
            [['bloc_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bloc::className(), 'targetAttribute' => ['bloc_id' => 'bloc_id']],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => BlocStore::className(), 'targetAttribute' => ['store_id' => 'store_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'group_id' => '分组ID',
            'user_id' => '用户ID',
            'store_id' => '商户ID',
            'bloc_id' => '公司ID',
            'create_time' => '创建时间',
        ];
    }

    /**
     * Gets query for [[Bloc]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBloc(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Bloc::className(), ['bloc_id' => 'bloc_id']);
    }

    /**
     * Gets a query for [[Store]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStore(): \yii\db\ActiveQuery
    {
        return $this->hasOne(BlocStore::className(), ['store_id' => 'store_id']);
    }

    /**
     * Gets query for [[UploadFiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUploadFiles(): \yii\db\ActiveQuery
    {
        return $this->hasMany(UploadFile::className(), ['group_id' => 'group_id']);
    }
}
