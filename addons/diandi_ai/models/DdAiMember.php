<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-07-29 01:51:32
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-09-19 11:44:41
 */

namespace addons\diandi_ai\models;

use Yii;

/**
 * This is the model class for table "dd_ai_member".
 *
 * @property int         $user_id                 人脸招聘
 * @property int         $face_group_id           人脸库组id
 * @property string      $nickName
 * @property string      $face_image              人脸照片
 * @property int         $gender
 * @property int|null    $face_id                 人脸id
 * @property int|null    $uid                     线下标识id
 * @property string|null $face_token              脸部图片唯一标识
 * @property int|null    $wxapp_id
 * @property int         $create_time
 * @property int         $update_time
 * @property int|null    $ai_age                  ai年龄
 * @property string|null $ai_gender               ai性别
 * @property string|null $ai_glasses
 * @property string|null $ai_race                 ai种族
 * @property string|null $ai_emotion              ai情绪
 * @property string|null $face_shape              ai脸型
 * @property string|null $ai_quality_blur         ai图片质量1
 * @property string|null $ai_quality_illumination ai图片质量1
 * @property string|null $ai_quality_completeness ai图片质量1
 */
class DdAiMember extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_ai_member}}';
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

    public function addMember($aidatas, $face_image, $face_group_id)
    {
        $data = [
            'face_group_id' => $face_group_id,
            'face_image' => $face_image,
            'face_token' => $aidatas['face_token'],
            'ai_age' => $aidatas['age'],
            'ai_gender' => $aidatas['gender']['type'],
            'ai_glasses' => $aidatas['glasses']['type'],
            'ai_race' => $aidatas['race']['type'],
            'ai_emotion' => $aidatas['emotion']['type'],
            'face_shape' => $aidatas['face_shape']['type'],
            'ai_quality_blur' => $aidatas['quality']['blur'],
            'ai_quality_illumination' => $aidatas['quality']['illumination'],
            'ai_quality_completeness' => $aidatas['quality']['completeness'],
        ];
        $this->setAttributes($data);
        $this->save();
        $addres = $this->getErrors();
        if (!empty($addres)) {
            return $addres;
        }

        return Yii::$app->db->getLastInsertID();
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['face_group_id'], 'required'],
            [['face_group_id', 'gender', 'wxapp_id', 'ai_age'], 'integer'],
            [['ai_gender'], 'string'],
            [['nickName', 'face_image', 'face_token',
             'ai_glasses',
             'ai_race',
             'ai_emotion',
             'face_shape',
            //  'ai_quality_blur',
            //  'ai_quality_illumination',
            //  'ai_quality_completeness'
            ], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => '人脸ID',
            'face_group_id' => '人脸分组',
            'nickName' => '名字',
            'face_image' => '脸部图片',
            'gender' => '性别',
            'uid' => 'Uid',
            'face_token' => 'Face Token',
            'wxapp_id' => 'Wxapp ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'ai_age' => '年龄',
            'ai_gender' => '性别',
            'ai_glasses' => 'Ai Glasses',
            'ai_race' => 'Ai Race',
            'ai_emotion' => 'Ai Emotion',
            'face_shape' => 'Face Shape',
            'ai_quality_blur' => 'Ai Quality Blur',
            'ai_quality_illumination' => 'Ai Quality Illumination',
            'ai_quality_completeness' => 'Ai Quality Completeness',
        ];
    }
}
