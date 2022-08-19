<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-08-19 13:41:11
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-19 17:00:42
 */

namespace swooleService\models;

use common\helpers\ErrorsHelper;
use common\helpers\loggingHelper;
use common\helpers\ResultHelper;
use swooleService\servers\AccessTokenService;
use Yii;

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
    const STATUS_DELETED = 1; //删除
    const STATUS_INACTIVE = 2; //拉黑
    const STATUS_ACTIVE = 0; //正常
    
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
            [['group_id', 'bloc_id', 'auth_key', 'password_hash'], 'required'],
            [['member_id', 'group_id', 'level', 'store_id', 'gender', 'status', 'address_id', 'create_time', 'update_time', 'organization_id'], 'integer'],
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
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup($username, $mobile, $password)
    {
        
        // if (!$this->validate()) {
        //     loggingHelper::writeLog('AccessTokenService', 'signup', '登录开始', [
        //         'username'=> $username, 
        //         'mobile'=> $mobile, 
        //         'password'=> $password,
        //         'validate'=> $this->validate(),
        //     ]);
        //     return $this->validate();
        // }

        /* 查看用户名是否重复 */
        // $userinfo = $this->find()->where(['username' => $username])->select('member_id')->one();
        // if (!empty($userinfo)) {
        //     return ResultHelper::json(401, '用户名重复');
        // }
        /* 查看手机号是否重复 */
        if ($mobile) {
            $userinfo = $this->find()->where(['mobile' => $mobile])
                ->andWhere(['<>', 'mobile', 0])->select('id')->one();
            if (!empty($userinfo)) {
                return ResultHelper::json(401, '手机号重复');
            }
        }

        loggingHelper::writeLog('AccessTokenService', 'signup', '会员注册校验手机号');

        $this->username = $username;
        $this->mobile = $mobile;
        $this->level = 1;
        $this->group_id = 1;
        $num = rand(1, 10);
        $this->avatarUrl = 'public/avatar' . $num . '.jpeg';

        $this->setPassword($password);
        $this->generateAuthKey();
        $this->generateEmailVerificationToken();
        $this->generatePasswordResetToken();
        if ($this->save()) {
            $service = new  AccessTokenService();
            $userinfo = $service->AccessTokenService->getAccessToken($this, 1);
            return $userinfo;
        } else {
            $msg = ErrorsHelper::getModelError($this);
            loggingHelper::writeLog('AccessTokenService', 'signup', '会员数据写入失败：'.$msg);
            return ResultHelper::json(401, $msg);
        }
    }

     /**
     * 生成accessToken字符串.
     *
     * @return string
     *
     * @throws \yii\base\Exception
     */
    public function generateAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString();

        return $this->access_token;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by username.
     *
     * @param string $username
     *
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::find()
            ->where(['and', ['or', " username = '{$username}'", "mobile='{$username}'"], 'status ='.self::STATUS_ACTIVE])
            ->one();
    }

    /**
     * Finds user by password reset token.
     *
     * @return static|null
     */
    public static function findByMobile($mobile)
    {
        return static::findOne([
            'mobile' => $mobile,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by password reset token.
     *
     * @param string $token password reset token
     *
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token.
     *
     * @param string $token verify email token
     *
     * @return static|null
     */
    public static function findByVerificationToken($token)
    {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid.
     *
     * @param string $token password reset token
     *
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];

        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password.
     *
     * @param string $password password to validate
     *
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model.
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key.
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token.
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString().'_'.time();
    }

    /**
     * Generates new token for email verification.
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString().'_'.time();
    }

    /**
     * Removes password reset token.
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }


    public function fields()
    {
        $fields = parent::fields();
        // 去掉一些包含敏感信息的字段
        unset($fields['auth_key'], $fields['password_hash'], $fields['verification_token']);

        return $fields;
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
