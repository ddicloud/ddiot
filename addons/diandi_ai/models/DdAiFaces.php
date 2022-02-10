<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-07-29 01:51:13
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-09-19 09:41:43
 */

namespace addons\diandi_ai\models;

use diandi\diandiai\AipFace;
use Yii;

/**
 * This is the model class for table "dd_ai_faces".
 *
 * @property int         $id
 * @property int|null    $ai_user_id
 * @property int|null    $ai_group_id
 * @property string|null $createtime
 * @property string|null $updatetime
 */
class DdAiFaces extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_ai_faces}}';
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
               'updatedAttribute' => 'createtime',
               'createdAttribute' => 'updatetime',
           ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ai_user_id', 'ai_group_id'], 'integer'],
            [['face_token', 'face_image'], 'string'],
            [['id', 'face_token'], 'unique'],
        ];
    }

    /**
     * function_description.
     *
     * @param int|null post
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function addUser($images, $face_group_id, $face_id, $imageType = 'BASE64')
    {
        // 你的 APPID AK SK
        $settings = Yii::$app->settings;
        $APP_ID = $settings->get('Baidu', 'APP_ID');
        $API_KEY = $settings->get('Baidu', 'API_KEY');
        $SECRET_KEY = $settings->get('Baidu', 'SECRET_KEY');
        $client = new AipFace($APP_ID, $API_KEY, $SECRET_KEY);
        $image = base64_encode(file_get_contents($images));
        $res = $client->addUser($image, $imageType, $face_group_id, $face_id);
        $this->findOne($face_id);
        $this->ai_face_status = $res['error_code'];
        $this->face_token = $res['result']['face_token'];
        $this->update();

        return $res;
    }

    // 更新人脸
    public function updateUser($images, $face_group_id, $face_id, $imageType = 'BASE64')
    {
        $settings = Yii::$app->settings;
        $APP_ID = $settings->get('Baidu', 'APP_ID');
        $API_KEY = $settings->get('Baidu', 'API_KEY');
        $SECRET_KEY = $settings->get('Baidu', 'SECRET_KEY');
        $client = new AipFace($APP_ID, $API_KEY, $SECRET_KEY);
        $image = base64_encode(file_get_contents($images));
        $res = $client->updateUser($image, $imageType, $face_group_id, $face_id);
        $this->findOne($face_id);
        $this->ai_face_status = $res['error_code'];
        $this->face_token = $res['result']['face_token'];
        $this->update();

        return $res;
    }

    /* 删除人脸 */
    public function faceDelete($userId, $groupId, $faceToken)
    {
        $settings = Yii::$app->settings;
        $APP_ID = $settings->get('Baidu', 'APP_ID');
        $API_KEY = $settings->get('Baidu', 'API_KEY');
        $SECRET_KEY = $settings->get('Baidu', 'SECRET_KEY');
        $client = new AipFace($APP_ID, $API_KEY, $SECRET_KEY);
        $res = $client->faceDelete($userId, $groupId, $faceToken);

        return $res;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ai_user_id' => '用户id',
            'ai_group_id' => '用户分组',
            'face_token' => '人脸图片唯一标识',
            'face_image' => '人脸图片',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
        ];
    }
}
