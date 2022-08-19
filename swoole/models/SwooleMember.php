<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-08-19 13:41:11
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-19 13:41:47
 */

namespace swooleService\models;

/**
 * This is the model class for table "{{%swoole_member}}".
 *
 * @property int         $id
 * @property int         $member_id
 * @property int         $group_id
 * @property int|null    $level
 * @property int|null    $store_id
 * @property int         $bloc_id
 * @property string|null $username             会员名称
 * @property string|null $mobile               手机号
 * @property string|null $address              用户地址
 * @property string      $nickName             微信昵称
 * @property string      $avatarUrl            会员头像
 * @property int         $gender               0男1女
 * @property string      $country              国家
 * @property string      $province             省份
 * @property int|null    $status               会员状态
 * @property string      $city                 城市
 * @property int         $address_id           收货地址id
 * @property string      $invitation_code
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
 * @property int|null    $organization_id      组织机构ID
 */
class SwooleMember extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%swoole_member}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['member_id', 'group_id', 'bloc_id', 'auth_key', 'password_hash'], 'required'],
            [['member_id', 'group_id', 'level', 'store_id', 'bloc_id', 'gender', 'status', 'address_id', 'create_time', 'update_time', 'organization_id'], 'integer'],
            [['username'], 'string', 'max' => 30],
            [['mobile'], 'string', 'max' => 11],
            [['address', 'nickName', 'avatarUrl', 'verification_token', 'password_hash', 'password_reset_token'], 'string', 'max' => 255],
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
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => 'Member ID',
            'group_id' => 'Group ID',
            'level' => 'Level',
            'store_id' => 'Store ID',
            'bloc_id' => 'Bloc ID',
            'username' => '会员名称',
            'mobile' => '手机号',
            'address' => '用户地址',
            'nickName' => '微信昵称',
            'avatarUrl' => '会员头像',
            'gender' => '0男1女',
            'country' => '国家',
            'province' => '省份',
            'status' => '会员状态',
            'city' => '城市',
            'address_id' => '收货地址id',
            'invitation_code' => 'Invitation Code',
            'verification_token' => '验证token',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'realname' => '真实姓名',
            'avatar' => '头像',
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
            'organization_id' => '组织机构ID',
        ];
    }
}
