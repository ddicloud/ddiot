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
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Login form.
 */
class LoginForm extends Model
{
    public string $username = '';
    public string $mobile = '';
    public string $password = '';
    public bool $rememberMe = true;

    private mixed $_user = null;

    const SCENARIO_MOBILE = 'mobile';

    const SCENARIO_USERNAME = 'username';

    public function scenarios()
    {
        return [
            self::SCENARIO_MOBILE => ['mobile', 'password', 'rememberMe'],
            self::SCENARIO_USERNAME => ['username', 'password', 'rememberMe'],
        ];
    }

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
        if (empty($this->username) && $this->scenario === 'username') {
            $this->addError($attribute, '用户名不能为空');
            return false;
        } elseif (empty($this->mobile) && $this->scenario === 'mobile') {
            $this->addError($attribute, '手机号不能为空');
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
     */
    public function validatePassword(string $attribute): bool
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (empty($user->toArray())){
                $this->addError($attribute,  $this->scenario === 'username'?'用户不存在':'手机号不存在');
            }
            if (!$user->validatePassword($this->password)) {
                $this->addError($attribute, '密码不正确');
            }
            return true;
        }
        return true;
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return array|bool|object[]|string[]
     */
    public function login(): array|bool
    {
        if ($this->validate()) {
            $userobj = $this->scenario === 'username'? DdMember::findByUsername($this->username):DdMember::findByMobile($this->mobile);
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
     * @return array|ActiveRecord|null
     */
    protected function getUser(): array|ActiveRecord|null
    {
        if ($this->_user === null) {
            $this->_user = $this->scenario === 'username'? DdMember::findByUsername($this->username):DdMember::findByMobile($this->mobile);
        }

        return $this->_user;
    }
}
