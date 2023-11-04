<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-04-21 22:58:32
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-07-29 18:24:34
 */

namespace admin\models\forms;

use admin\models\User;
use common\helpers\loggingHelper;
use common\helpers\MapHelper;
use common\helpers\ResultHelper;
use common\models\enums\UserStatus;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Login form.
 */
class LoginForm extends Model
{
    public $username;
    public $mobile;
    public $company;
    public $sms_code;
    public $password;
    public $type; //登录方式

    public $rememberMe = true;
    private $_user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'mobile'], 'eitherOneRequired', 'skipOnEmpty' => false, 'skipOnError' => false],
            // username and password are both required
            [['password', 'type'], 'required'],
            [['company'], 'string'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    public function eitherOneRequired($attribute, $params, $validator)
    {
        if ($this->type === 1 && empty($this->username)) {
            $this->addError($attribute, '用户名不能为空');

            return false;
        }

        if ($this->type === 2 && empty($this->username)) {
            $this->addError($attribute, '手机号不能为空');

            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
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
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!empty($user) && !$user->validatePassword($this->password)) {
                $Namemsg = (int)$this->type === 1 ? '用户名' : '手机号';
                $this->addError($attribute, $Namemsg . '或密码不正确');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return array|bool|object[]|string[]
     * @throws Exception
     */
    public function login(): array|bool
    {
        if ($this->validate()) {
            $mobile = $this->mobile;
            $code = $this->sms_code;
            $sendcode = Yii::$app->cache->get($mobile . '_code');

            $settings = Yii::$app->settings;
            $settings->invalidateCache();
            $info = $settings->getAllBySection('Website');

            if (!empty($info) && (int)$info['is_send_code'] === 1 && $this->type === 2) {
                if (empty($code)) {
                    return ResultHelper::json(401, '验证码不能为空');
                }
                if ($code != $sendcode) {
                    return ResultHelper::json(401, '验证码错误');
                }
            }

            $userInfo = $this->getUser();
            if (empty($userInfo)) {
                $info = User::findUser($this->mobile, $this->username);
                if (!empty($info)) {
                    $list = UserStatus::listData();
                    $status_str = $list[$info['status']];

                    return ResultHelper::json(400, '您的账户' . $status_str . '，请联系客服');
                } else {
                    return ResultHelper::json(400, '账户不存在');
                }
            }

            $Res = Yii::$app->user->login($userInfo, $this->rememberMe ? 3600 * 24 * 30 : 0);

            $last_login_ip = MapHelper::get_client_ip();
            $user = User::find()->where([
                'id' => Yii::$app->user->identity->id,
                'last_login_ip' => $last_login_ip,
            ])->select(['is_login'])->one();

            // if($user['is_login']==1 && $user['last_time']+60*5<time()){

            //     Yii::$App->user->logout();
            //     Yii::$App->session->setFlash('success', '该账户已在其他浏览器登录');
            //     return $this->goHome();
            // }
            // 记录最后登录的时间
            $password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
            User::updateAll([
                'last_time' => time(),
                'is_login' => 1,
                'last_login_ip' => $last_login_ip,
                'password_reset_token' => $password_reset_token,
            ], ['id' => Yii::$app->user->identity->id]);

            $userobj = (int)\Yii::$app->request->input('type') === 1 ? User::findByUsername($this->username) : User::findByMobile($this->mobile);
            $service = Yii::$app->service;
            $service->namespace = 'admin';
            $userinfo = $service->AccessTokenService->getAccessToken($userobj, 1);
            // 登录日志记录
            loggingHelper::actionLog(Yii::$app->user->identity->id, '账号登录', $last_login_ip);

            return ArrayHelper::toArray($userinfo);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]].
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = (int)$this->type === 1 ? User::findByUsername($this->username) : User::findByMobile($this->mobile);
        }

        return $this->_user;
    }
}
