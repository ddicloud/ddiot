<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-10-27 14:36:08
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-11 14:13:15
 */

namespace api\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Login form.
 */
class LoginForm extends Model
{
    public string $username = '';
    public string $mobile  = '';
    public string $password  = '';
    public bool $rememberMe = true;

    private mixed $_user;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['username', 'mobile'], 'eitherOneRequired', 'skipOnEmpty' => false, 'skipOnError' => false],
            // username and password are both required
            [['password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    public function eitherOneRequired($attribute, $params, $validator): bool
    {
        if (empty($this->username)
            && empty($this->mobile)
        ) {
            $this->addError($attribute, '用户名或手机号不能为空');

            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'rememberMe' => '记住',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params    the additional name-value pairs given in the rule
     */
    public function validatePassword(string $attribute, array $params): void
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, '用户名或密码不正确');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return array|bool|object[]|string[]
     */
    public function login(): array|bool
    {
        if ($this->validate()) {
            $userobj = DdMember::findByUsername($this->username);
            $service = Yii::$app->service;
            $service->namespace = 'api';
            $userinfo = $service->AccessTokenService->getAccessToken($userobj, 1);

            return ArrayHelper::toArray($userinfo);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]].
     *
     * @return array|\yii\db\ActiveRecord
     */
    protected function getUser(): array|\yii\db\ActiveRecord
    {
        if ($this->_user === null) {
            $this->_user = DdMember::findByUsername($this->username);
        }

        return $this->_user;
    }
}
