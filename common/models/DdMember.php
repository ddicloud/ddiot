<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-02 00:50:23
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-12-27 03:29:50
 */

namespace common\models;

use api\modules\officialaccount\models\DdWechatFans;
use api\modules\wechat\models\DdWxappFans;
use common\helpers\HashidsHelper;
use Yii;

/**
 * This is the model class for table "{{%member}}".
 *
 * @property int         $member_id
 * @property int|null    $group_id
 * @property int|null    $level
 * @property string      $openid
 * @property int|null    $store_id
 * @property int         $bloc_id
 * @property string|null $username             会员名称
 * @property int|null    $mobile               手机号
 * @property string|null $address              用户地址
 * @property string      $nickName             微信昵称
 * @property string      $avatarUrl            会员头像
 * @property int         $gender               0男1女
 * @property string      $country              国家
 * @property string      $province             省份
 * @property int|null    $status               会员状态
 * @property string      $city                 城市
 * @property int         $address_id           收货地址id
 * @property int         $wxapp_id
 * @property string|null $verification_token   验证token
 * @property int         $create_time
 * @property int         $update_time
 * @property string      $auth_key
 * @property string      $password_hash
 * @property string|null $password_reset_token
 * @property string|null $realname             真实姓名
 * @property string|null $avatar               头像
 * @property string|null $qq                   QQ号
 * @property string|null $vip                  VIP级别
 * @property string|null $birthyear            出生生日
 * @property string|null $constellation        星座
 * @property string|null $zodiac               生肖
 * @property string|null $telephone            固定电话
 * @property string|null $idcard               证件号码
 * @property string|null $studentid            学号
 * @property string|null $grade                班级
 * @property string|null $zipcode              邮编
 * @property string|null $nationality          国籍
 * @property string|null $resideprovince       居住地址
 * @property string|null $graduateschool       毕业学校
 * @property string|null $company              公司
 * @property string|null $education            学历
 * @property string|null $occupation           职业
 * @property string|null $position             职位
 * @property string|null $revenue              年收入
 * @property string|null $affectivestatus      情感状态
 * @property string|null $lookingfor           交友目的
 * @property string|null $bloodtype            血型
 * @property string|null $height               身高
 * @property string|null $weight               体重
 * @property string|null $alipay               支付宝帐号
 * @property string|null $msn                  MSN
 * @property string|null $email                电子邮箱
 * @property string|null $taobao               阿里旺旺
 * @property string|null $site                 主页
 * @property string|null $bio                  自我介绍
 * @property string|null $interest             兴趣爱好
 */
class DdMember extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%member}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['group_id', 'level', 'store_id', 'bloc_id', 'mobile', 'gender', 'status', 'address_id', 'create_time', 'update_time'], 'integer'],
            [['bloc_id', 'auth_key', 'password_hash'], 'required'],
            [['openid', 'address', 'nickName', 'avatarUrl', 'verification_token', 'password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['username'], 'string', 'max' => 30],
            [['country', 'province', 'city', 'invitation_code'], 'string', 'max' => 100],
            [['auth_key'], 'string', 'max' => 32],
            [['realname', 'avatar', 'qq', 'vip', 'birthyear', 'constellation', 'zodiac', 'telephone', 'idcard', 'studentid', 'grade', 'zipcode', 'nationality', 'resideprovince', 'graduateschool', 'company', 'education', 'occupation', 'position', 'revenue', 'affectivestatus', 'lookingfor', 'bloodtype', 'height', 'weight', 'alipay', 'msn', 'email', 'taobao', 'site', 'bio', 'interest'], 'string', 'max' => 10],
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
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            empty($this->invitation_code) && DdMember::updateAll(['invitation_code' => HashidsHelper::encode($this->member_id)], ['member_id' => $this->member_id]);
        }
        parent::afterSave($insert, $changedAttributes);
    }


    public function getAccount()
    {
        return $this->hasOne(DdMemberAccount::className(), ['member_id' => 'member_id']);
    }

    public function getGroup()
    {
        return $this->hasOne(DdMemberGroup::className(), ['group_id' => 'group_id']);
    }

    public function getFans()
    {
        return $this->hasOne(DdWxappFans::className(), ['user_id' => 'member_id']);
    }

    public function getWechatfans()
    {
        return $this->hasOne(DdWechatFans::className(), ['user_id' => 'member_id']);
    }

  

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'member_id' => '会员ID',
            'group_id' => '会员组ID',
            'level' => 'Level',
            'openid' => 'Openid',
            'store_id' => '商户ID',
            'bloc_id' => '公司ID',
            'username' => '会员名称',
            'mobile' => '手机号',
            'address' => '用户地址',
            'nickName' => '微信昵称',
            'avatarUrl' => '微信头像',
            'gender' => '0男1女',
            'country' => '国家',
            'province' => '省份',
            'status' => '会员状态',
            'city' => '城市',
            'address_id' => '收货地址id',
            'invitation_code' => '邀请码',
            'verification_token' => '验证token',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'realname' => '真实姓名',
            'avatar' => '会员头像',
            'qq' => 'QQ号',
            'vip' => 'VIP级别',
            'birthyear' => '出生生日',
            'constellation' => '星座',
            'zodiac' => '生肖',
            'telephone' => '固定电话',
            'idcard' => '证件号码',
            'studentid' => '学号',
            'grade' => '班级',
            'zipcode' => '邮编',
            'nationality' => '国籍',
            'resideprovince' => '居住地址',
            'graduateschool' => '毕业学校',
            'company' => '公司',
            'education' => '学历',
            'occupation' => '职业',
            'position' => '职位',
            'revenue' => '年收入',
            'affectivestatus' => '情感状态',
            'lookingfor' => ' 交友目的',
            'bloodtype' => '血型',
            'height' => '身高',
            'weight' => '体重',
            'alipay' => '支付宝帐号',
            'msn' => 'MSN',
            'email' => '电子邮箱',
            'taobao' => '阿里旺旺',
            'site' => '主页',
            'bio' => '自我介绍',
            'interest' => '兴趣爱好',
        ];
    }
}
