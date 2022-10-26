<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-07-29 01:59:56
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-26 15:37:37
 */

namespace admin\models;

use admin\models\addons\models\Bloc;
use admin\services\UserService;
use common\helpers\ErrorsHelper;
use common\helpers\FileHelper;
use common\helpers\ResultHelper;
use common\models\enums\UserStatus;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model.
 *
 * @property int    $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property int    $status
 * @property int    $created_at
 * @property int    $updated_at
 * @property string $password             write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = UserStatus::DELETE;
    const STATUS_INACTIVE = UserStatus::AUDIT;
    const STATUS_ACTIVE = UserStatus::APPROVE;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            ['status', 'default', 'value' => UserStatus::AUDIT],
            ['status', 'in', 'range' => UserStatus::getConstantsByName()],
            [['username', 'email', 'avatar', 'company', 'union_id', 'open_id'], 'safe'],
            ['parent_bloc_id', 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function setStatus(UserStatus $status)
    {
        $this->status = $status->getValue();
    }

    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup($username, $mobile, $email, $password, $invitation_code = '', $company = '', $status = 0)
    {
        $logPath = Yii::getAlias('@runtime/wechat/login/'.date('ymd').'.log');

        if (!$this->validate()) {
            FileHelper::writeLog($logPath, '登录日志:会员注册校验失败'.json_encode($this->validate()));

            return $this->validate();
        }

        /* 查看用户名是否重复 */
        $userinfo = $this->find()->where(['username' => $username])->select('id')->one();
        if (!empty($userinfo)) {
            return ResultHelper::json(401, '用户名已被占用');
        }
        /* 查看手机号是否重复 */
        if ($mobile) {
            $userinfo = $this->find()->where(['mobile' => $mobile])
                ->andWhere(['<>', 'mobile', 0])->select('id')->one();
            if (!empty($userinfo)) {
                return ResultHelper::json(401, '手机号已被占用');
            }
        }
        /* 查看邮箱是否重复 */
        if ($email) {
            $userinfo = $this->find()->where(['email' => $email])
                ->andWhere(['<>', 'email', 0])->select('id')->one();
            if (!empty($userinfo)) {
                return ResultHelper::json(401, '邮箱已被占用');
            }
        }
        FileHelper::writeLog($logPath, '登录日志:会员注册校验手机号'.json_encode($email));
        if ($invitation_code) {
            $parent_bloc_id = Bloc::find()->where(['invitation_code' => $invitation_code])->select('bloc_id')->scalar();
        }
        $this->username = $username;
        $this->email = $email;
        $this->parent_bloc_id = (int) $parent_bloc_id;
        $this->company = $company;
        $this->mobile = $mobile;
        $this->status = (int) $status;

        $this->setPassword($password);
        $this->generateAuthKey();
        $this->generateEmailVerificationToken();
        $this->generatePasswordResetToken();
        if ($this->save()) {
            $user_id = Yii::$app->db->getLastInsertID();
            UserService::initUserAuth($user_id);
            /* 写入用户apitoken */
            $service = Yii::$app->service;
            $service->namespace = 'admin';
            $userinfo = $service->AccessTokenService->getAccessToken($this, 1);

            return $userinfo;
        } else {
            $msg = ErrorsHelper::getModelError($this);
            FileHelper::writeLog($logPath, '登录日志:会员注册失败错误'.json_encode($msg));

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
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public static function findUser($mobile, $username)
    {
        $query = static::find();
        if (!empty($mobile)) {
            $user = $query->where(['mobile' => $mobile])->one();
        }

        if (!empty($username)) {
            $user = $query->where(['username' => $username])->one();
        }

        return $user;
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
        return static::find()->where(['username' => $username, 'status' => self::STATUS_ACTIVE])->one();
    }

    public static function findByMobile($mobile)
    {
        return static::find()->where(['mobile' => $mobile, 'status' => self::STATUS_ACTIVE])->one();
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
        return $this->id;
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
}
