<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-17 14:10:10
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-07-28 10:02:33
 */

namespace admin\models\forms;

use admin\models\User;
use common\models\DdUser;
use Yii;
use yii\base\Model;

class EdituserinfoForm extends Model
{
    /**
     * 用户名.
     */
    public $username;

    /**
     * 手机号.
     */
    public $mobile;

    /**
     * 公司.
     */
    public $company;

    /**
     * 头像.
     */
    public $avatar;

    /**
     * 邮箱.
     *
     * @var [type]
     * @date 2022-07-28
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public $email;

    /**
     * @var User
     */
    private $_user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'mobile', 'company', 'avatar',  'email'], 'filter', 'filter' => 'trim'],
            ['mobile', 'match', 'pattern' => '/^[1][34578][0-9]{9}$/'],
            ['email', 'match', 'pattern' => '/^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/'],
            ['mobile', 'validateMobile'],
            ['username', 'validateUsername'],
            ['email', 'validateEmail'],
        ];
    }

    public function validateMobile($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            $hasuser = DdUser::find()->where(['and', ['=', 'mobile', $this->mobile], ['!=', 'id', $user->id]])->select('id')->one();
            if ($hasuser) {
                return   $this->addError($attribute, '手机号已经被占用');
            }
        }
    }

    public function validateUsername($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            $hasuser = DdUser::find()->where(['and', ['=', 'username', $this->username], ['!=', 'id', $user->id]])->select('id')->one();
            if ($hasuser) {
                return   $this->addError($attribute, '用户名已经被占用');
            }
        }
    }

    public function validateEmail($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            $hasuser = DdUser::find()->where(['and', ['=', 'username', $this->username], ['!=', 'id', $user->id]])->select('id')->one();
            if ($hasuser) {
                return   $this->addError($attribute, '用户名已经被占用');
            }
        }
    }

    /**
     * 修改用户资料.
     *
     * @return bool whether the user is logged in successfully
     */
    public function edituserinfo()
    {
        if ($this->validate()) {
            $userobj = $this->getUser();
            $userobj->load($this->attributes, '');

            if ($userobj->save()) {
                $service = Yii::$app->service;
                $service->namespace = 'admin';
                $userinfo = $service->AccessTokenService->getAccessToken($userobj, 1);

                return $userinfo;
            }
        } else {
            return false;
        }
    }

    /**
     * 获取用户信息.
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            /** @var User $identity */
            $user_id = Yii::$app->user->identity->id;
            $this->_user = User::findOne($user_id);
        }

        return $this->_user;
    }

    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'mobile' => '手机号',
            'avatar' => '头像',
            'company' => '公司名称',
            'email' => '邮箱',
        ];
    }
}
