<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-12 00:35:06
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-07-11 15:25:18
 */

namespace api\models;

use common\behaviors\ServiceBehavior;
use common\helpers\ErrorsHelper;
use common\helpers\FileHelper;
use common\helpers\HashidsHelper;
use common\helpers\ResultHelper;
use common\models\DdMemberAccount;
use Yii;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "dd_member".
 *
 * @property int         $member_id
 * @property string      $openid
 * @property string      $nickName
 * @property string      $avatarUrl
 * @property int         $gender
 * @property string      $country
 * @property string      $province
 * @property string      $city
 * @property int         $address_id
 * @property int         $wxapp_id
 * @property string|null $access_token
 * @property string|null $verification_token
 * @property int         $create_time
 * @property int         $update_time
 */
class DdMember extends ActiveRecord
{
    const STATUS_DELETED = 1; //删除
    const STATUS_INACTIVE = 2; //拉黑
    const STATUS_ACTIVE = 0; //正常

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%member}}';
    }

    /**
     * 行为.
     */
    public function behaviors(): array
    {
        /*自动添加创建和修改时间*/
        return [
            ServiceBehavior::class,
            [
                'class' => \common\behaviors\SaveBehavior::class,
                'updatedAttribute' => 'update_time',
                'createdAttribute' => 'create_time',
            ],
        ];
    }

    /**
     * @param bool  $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes): void
    {
        if ($insert) {
            empty($this->invitation_code) && DdMember::updateAll(['invitation_code' => HashidsHelper::encode($this->member_id)], ['member_id' => $this->member_id]);
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * 关联api验证token.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAccesstoken(): \yii\db\ActiveQuery
    {
        return $this->hasOne(DdApiAccessToken::class, ['member_id' => 'member_id']);
    }

    /**
     * 关联用户资产.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAccount(): \yii\db\ActiveQuery
    {
        return $this->hasOne(DdMemberAccount::class, ['member_id' => 'member_id']);
    }

    /**
     * Signs user up.
     *
     * @return array|bool|object[]|string[]
     * @throws ErrorException
     */
    public function signup($username, $mobile, $password): array|bool
    {
        $logPath = Yii::getAlias('@runtime/DdMember/signup/' . date('ymd') . '.log');

        if (!$this->validate()) {
            FileHelper::writeLog($logPath, '登录日志:会员注册校验失败' . json_encode($this->validate()));

            return $this->validate();
        }

        /* 查看用户名是否重复 */
        $userinfo = $this->find()->where(['username' => $username])->select('member_id')->one();
        if (!empty($userinfo)) {
            return ResultHelper::json(401, '用户名重复');
        }
        /* 查看手机号是否重复 */
        if ($mobile) {
            $userinfo = $this->find()->where(['mobile' => $mobile])
                ->andWhere(['<>', 'mobile', 0])->select('member_id')->one();
            if (!empty($userinfo)) {
                return ResultHelper::json(401, '手机号重复');
            }
        }
        FileHelper::writeLog($logPath, '登录日志:会员注册校验手机号' . json_encode($mobile));

        // 校验用户名是否重复
        // $isHave = $this->find()->where(['username' => $username])->select('member_id')->scalar();

        // if ($isHave) {
        //     return ResultHelper::json(401, '用户名已存在，请修改');
        // }

        $this->username = $username;
        $this->mobile = $mobile;
        $this->level = 1;
        $this->group_id = 1;
        $num = rand(1, 10);
        $this->avatarUrl = 'public/avatar' . $num . '.jpeg';

        try {
            $this->setPassword($password);
            $this->generateAuthKey();
            $this->generateEmailVerificationToken();
            $this->generatePasswordResetToken();
        } catch (ErrorException|Exception $e) {
            throw new ErrorException($e->getMessage(),400);
        }

        if ($this->save()) {
            $member_id = $this->getId();
            // 更新用户邀请码

            $isHave = DdMemberAccount::find()->where(['member_id' => $member_id])->asArray()->one();
            FileHelper::writeLog($logPath, '登录日志:获取用户ID' . json_encode([
                'member_id' => $member_id,
                'member_ids' => $this->getId(),
                'isHave' => $isHave,
                'this' => $this,
            ]));

            if (!empty($member_id) && empty($isHave)) {
                /* 写入用户初始资产 */
                $DdMemberAccount = new DdMemberAccount();
                $DdMemberAccount->member_id = $member_id;
                $DdMemberAccount->status = 1;
                $DdMemberAccount->level = 1;
                $DdMemberAccount->user_money = 0;
                $DdMemberAccount->accumulate_money = 0;
                $DdMemberAccount->give_money = 0;
                $DdMemberAccount->consume_money = 0;
                $DdMemberAccount->frozen_money = 0;
                $DdMemberAccount->consume_integral = 0;
                $DdMemberAccount->credit1 = 0;
                $DdMemberAccount->credit2 = 0;
                $DdMemberAccount->credit3 = 0;
                $DdMemberAccount->credit4 = 0;

                $DdMemberAccount->credit5 = 0;

                $DdMemberAccount->save();

                $msg = ErrorsHelper::getModelError($DdMemberAccount);
                FileHelper::writeLog($logPath, '登录日志:用户资产写入失败' . json_encode($msg));
            }

            /* 写入用户apitoken */
            $service = Yii::$app->service;
            $service->namespace = 'api';
            return $service->AccessTokenService->getAccessToken($this, 1);
        } else {
            $msg = ErrorsHelper::getModelError($this);
            FileHelper::writeLog($logPath, '登录日志:ddmember会员注册失败错误' . json_encode($msg));

            return ResultHelper::json(401, $msg);
        }
    }

    /**
     * 生成accessToken字符串.
     *
     * @return string|null
     *
     * @throws Exception
     */
    public function generateAccessToken(): ?string
    {
        $this->access_token = Yii::$app->security->generateRandomString();

        return $this->access_token;
    }

    /**
     * {}
     */
    public static function findIdentity($id): ?DdMember
    {
        return static::findOne(['member_id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by username.
     *
     * @param string $username
     *
     * @return array|ActiveRecord
     */
    public static function findByUsername(string $username): array|ActiveRecord
    {
        return static::find()
            ->where(['and', ['or', " username = '$username'", "mobile='$username'"], 'status =' . self::STATUS_ACTIVE])
            ->one();
    }

    /**
     * Finds user by password reset token.
     *
     * @param $mobile
     * @return static|null
     */
    public static function findByMobile($mobile): null|static
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
    public static function findByPasswordResetToken(string $token): null|static
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
    public static function findByVerificationToken(string $token): null|static
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
     * {}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {}
     */
    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    /**
     * {}
     */
    public function validateAuthKey($authKey): bool
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

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['gender', 'address_id', 'group_id', 'organization_id', 'create_time', 'update_time'], 'integer'],
            [['username', 'openid', 'invitation_code', 'mobile', 'nickName', 'avatarUrl', 'verification_token', 'address', 'email'], 'string', 'max' => 255],
            [['country', 'province', 'city'], 'string', 'max' => 100],
            // ['username', 'unique'],
        ];
    }

    public function fields(): array
    {
        $fields = parent::fields();
        // 去掉一些包含敏感信息的字段
        unset($fields['auth_key'], $fields['password_hash'], $fields['verification_token']);

        return $fields;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'member_id' => '用户id',
            'openid' => 'OpenID',
            'nickName' => '昵称',
            'group_id' => '用户组id',
            'avatarUrl' => '头像',
            'gender' => '性别',
            'country' => '国家',
            'province' => '省份',
            'city' => '城市',
            'address_id' => '地址',
            'invitation_code' => '邀请码',
            'access_token' => 'Access Token',
            'verification_token' => '验证token',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }
}
