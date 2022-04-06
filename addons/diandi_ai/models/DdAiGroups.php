<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-07-29 01:51:22
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-09-19 09:41:12
 */

namespace addons\diandi_ai\models;

use diandi\diandiai\AipFace;
use Yii;

/**
 * This is the model class for table "dd_ai_groups".
 *
 * @property int         $id
 * @property int|null    $ai_group_id 百度ai用户组id
 * @property string|null $name        分组名称
 * @property string|null $createtime
 * @property string|null $updatetime
 */
class DdAiGroups extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%diandi_ai_groups}}';
    }

    public $is_default = 0;

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
            // [['id'], 'required'],
            [['ai_group_status', 'is_default'], 'integer'],
            // [['createtime', 'updatetime'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['id'], 'unique'],
        ];
    }

    /* 创建人脸库分组 */
    public function groupAdd($groupId)
    {
        // 你的 APPID AK SK
        $settings = Yii::$app->settings;
        $APP_ID = $settings->get('Baidu', 'APP_ID');
        $API_KEY = $settings->get('Baidu', 'API_KEY');
        $SECRET_KEY = $settings->get('Baidu', 'SECRET_KEY');
        $client = new AipFace($APP_ID, $API_KEY, $SECRET_KEY);
        // 带参数调用人脸检测
        $res = $client->groupAdd($groupId);
        $this->findOne($groupId);
        $this->ai_group_status = $res['error_code'];
        $this->update();

        return $res;
    }

    /* 删除人脸库分组 */
    public function groupDelete($groupId)
    {
        // 你的 APPID AK SK
        $settings = Yii::$app->settings;
        $APP_ID = $settings->get('Baidu', 'APP_ID');
        $API_KEY = $settings->get('Baidu', 'API_KEY');
        $SECRET_KEY = $settings->get('Baidu', 'SECRET_KEY');
        $client = new AipFace($APP_ID, $API_KEY, $SECRET_KEY);

        // 带参数调用人脸检测
        $res = $client->groupDelete($groupId);

        return $res;
    }

    /* 人脸库分组查询 */
    public function getGroupList($groupId)
    {
        // 你的 APPID AK SK
        $settings = Yii::$app->settings;
        $APP_ID = $settings->get('Baidu', 'APP_ID');
        $API_KEY = $settings->get('Baidu', 'API_KEY');
        $SECRET_KEY = $settings->get('Baidu', 'SECRET_KEY');
        $client = new AipFace($APP_ID, $API_KEY, $SECRET_KEY);
        // 带参数调用人脸检测
        $res = $client->getGroupList($groupId);

        return $res;
    }

    /* 获取用户组 */
    public function getGroupUsers($groupId)
    {
        // 你的 APPID AK SK
        $settings = Yii::$app->settings;
        $APP_ID = $settings->get('Baidu', 'APP_ID');
        $API_KEY = $settings->get('Baidu', 'API_KEY');
        $SECRET_KEY = $settings->get('Baidu', 'SECRET_KEY');
        $client = new AipFace($APP_ID, $API_KEY, $SECRET_KEY);
        // 带参数调用人脸检测
        $res = $client->getGroupUsers($groupId);

        return $res;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ai_group_status' => '创建状态',
            'name' => '用户组名称',
            'is_default' => '设置默认用户组',
            'createtime' => 'Createtime',
            'updatetime' => 'Updatetime',
        ];
    }
}
