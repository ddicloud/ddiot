<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-07-29 01:59:56
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-03-10 17:46:21
 */

namespace admin\models;

use admin\models\addons\models\Bloc;
use admin\services\UserService;
use common\helpers\ErrorsHelper;
use common\helpers\FileHelper;
use common\helpers\ResultHelper;
use common\models\enums\UserStatus;
use diandi\admin\models\AuthAssignmentGroup;
use Throwable;
use Yii;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model.
 *
 * @property string $password_hash
 * @property string $auth_key
 * @property $username
 * @property int|mixed $status
 * @property int $id
 * @property string $access_token
 * @property mixed $avatar
 * @public int    $id
 * @public int    $store_id
 * @public string $username
 * @public string $password_hash
 * @public string $password_reset_token
 * @public string $verification_token
 * @public string $email
 * @public string $auth_key
 * @public int    $status
 * @public int    $created_at
 * @public int    $updated_at
 * @public string $password             write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = UserStatus::DELETE;
    const STATUS_INACTIVE = UserStatus::AUDIT;
    const STATUS_ACTIVE = UserStatus::APPROVE;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'bloc_id', 'store_id'], 'integer'],
            ['status', 'default', 'value' => UserStatus::AUDIT],
            ['status', 'in', 'range' => UserStatus::getConstantsByName()],
            [['username', 'email', 'avatar', 'company', 'union_id', 'open_id'], 'safe'],
            ['parent_bloc_id', 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function setStatus(UserStatus $status): void
    {
        $this->status = $status->getValue();
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getUserGroup(): \yii\db\ActiveQuery
    {
        return $this->hasOne(AuthAssignmentGroup::className(), ['user_id' => 'id']);
    }

    /**
     * Signs user up.
     * Source_type: 0主动注册1后台添加.
     *
     * @param $username
     * @param $mobile
     * @param $email
     * @param $password
     * @param int $status
     * @param string $invitation_code
     * @param int $source_type
     * @param string $company
     * @return array|bool|object[]|string[]
     * @throws ErrorException
     * @throws Exception|Throwable
     */
    public function signup($username, $mobile, $email, $password, int $status = 0, string $invitation_code = '', int $source_type = 0, string $company = ''): array|bool
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
        $parent_bloc_id = 0;
        if ($invitation_code) {
            $parent_bloc_id = Bloc::find()->where(['invitation_code' => $invitation_code])->select('bloc_id')->scalar();
        }
        $avatar = Yii::$app->request->input('avatar');

        $this->avatar = $avatar;
        $this->username = $username;
        $this->email = $email;
        $this->parent_bloc_id = (int) $parent_bloc_id;
        $this->company = $company;
        $this->mobile = $mobile;
        
        if ((int)Yii::$app->request->input('source_type') === 1) {
            $this->store_id = Yii::$app->request->input('store_id',0);
            $this->bloc_id = Yii::$app->request->input('bloc_id',0);
        }
        $this->status = (int) $status;

        $this->setPassword($password);
        $this->generateAuthKey();
        $this->generateEmailVerificationToken();
        $this->generatePasswordResetToken();
        if ($this->save()) {
            $user_id = Yii::$app->db->getLastInsertID();
            // 只有没有该参数才是正常的注册，否则是后台直接添加的用户
            $source_type = Yii::$app->request->input('source_type');
            if ((int)$source_type === 0) {
                UserService::initUserAuth($user_id);
            }
            /* 写入用户apitoken */
            $service = Yii::$app->service;
            $service->namespace = 'admin';
            return $service->AccessTokenService->getAccessToken($this, 1);
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
     * @throws Exception
     */
    public function generateAccessToken(): string
    {
        $this->access_token = Yii::$app->security->generateRandomString();

        return $this->access_token;
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id): User|IdentityInterface|null
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null): User|IdentityInterface|null
    {
        return static::findOne(['access_token' => $token]);
    }

    public static function findUser($mobile, $username): array|ActiveRecord|null
    {
        $user =  null;
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
     * @return User|ActiveRecord|null
     */
    public static function findByUsername(string $username): User|ActiveRecord|null
    {
        return static::find()->where(['username' => $username, 'status' => self::STATUS_ACTIVE])->one();
    }

    public static function findByMobile($mobile): ActiveRecord|null
    {
        return static::find()->where(['mobile' => $mobile, 'status' => self::STATUS_ACTIVE])->one();
    }

    /**
     * Finds user by password reset token.
     *
     * @param string $token password reset token
     *
     * @return User|null
     */
    public static function findByPasswordResetToken(string $token): ?static
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
     * @return User
     */
    public static function findByVerificationToken(string $token): static
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
    public static function isPasswordResetTokenValid(string $token): bool
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
    public function getAuthKey(): ?string
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey): ?bool
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password.
     *
     * @param string $password password to validate
     *
     * @return bool if the password provided is valid for the current user
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model.
     *
     * @param string $password
     * @throws Exception
     */
    public function setPassword(string $password): void
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key.
     * @throws ErrorException
     */
    public function generateAuthKey(): void
    {
        try {
            $this->auth_key = Yii::$app->security->generateRandomString();
        } catch (Exception $e) {
            throw new ErrorException($e->getMessage(),400);
        }
    }

    /**
     * Generates new password reset token.
     * @throws ErrorException
     */
    public function generatePasswordResetToken(): void
    {
        try {
            $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
        } catch (Exception $e) {
            throw new ErrorException($e->getMessage(),400);
        }
    }

    /**
     * Generates new token for email verification.
     * @throws ErrorException
     */
    public function generateEmailVerificationToken(): void
    {
        try {
            $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
        } catch (Exception $e) {
            throw new ErrorException($e->getMessage(),400);
        }
    }

    /**
     * Removes password reset token.
     */
    public function removePasswordResetToken(): void
    {
        $this->password_reset_token = null;
    }

    public function fields(): array
    {
        $fields = parent::fields();
        // 去掉一些包含敏感信息的字段
        unset($fields['auth_key'], $fields['password_hash'], $fields['verification_token']);

        return $fields;
    }
}
