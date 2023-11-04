<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-12 01:50:17
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-03-10 22:27:04
 */

namespace common\services\admin;

use admin\models\DdApiAccessToken;
use admin\models\User;
use common\helpers\ArrayHelper;
use common\helpers\ErrorsHelper;
use common\helpers\ImageHelper;
use common\helpers\StringHelper;
use common\models\DdUser;
use common\models\UserBloc;
use common\models\UserStore;
use common\services\BaseService;
use diandi\addons\models\AddonsUser;
use diandi\addons\models\DdAddons;
use Yii;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;
use yii\web\UnprocessableEntityHttpException;

/**
 * Class AccessTokenService.
 *
 * @author wangchunsheng <2192138785@qq.com>
 */
class AccessTokenService extends BaseService
{
    /**
     * 是否加入缓存.
     *
     * @var bool
     */
    public bool $cache = true;

    /**
     * 缓存过期时间.
     *
     * @var int
     */
    public int $timeout = 7200;

    /**
     * 获取token.
     *
     * @param User $member
     * @param [type] $group_id
     * @param int $cycle_index
     *
     * @return array
     * @throws UnprocessableEntityHttpException
     * @date 2022-10-18
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public function getAccessToken(User $member, $group_id, int $cycle_index = 1): array
    {
        $model = $this->findModel($member->id, $group_id);

        $model->user_id = $member->id;
        $model->id = $member->id;

        $model->group_id = $group_id;

        /* 是否到期，到期就重置 */
        if ($this->isPeriod($model->access_token) || empty($model->access_token)) {
            // 删除缓存
            !empty($model->access_token) && Yii::$app->cache->delete($this->getCacheKey($model->access_token));
            if ($this->isPeriodRefToken($model->refresh_token) || empty($model->refresh_token)) {
                $model->refresh_token = StringHelper::uuid('sha1').'_'.time();
            }
            $model->access_token = StringHelper::uuid('sha1').'_'.time();
            $model->status = 1;
            if (!$model->save()) {
                if ($cycle_index <= 3) {
                    ++$cycle_index;

                    return $this->getAccessToken($member, $group_id, $cycle_index);
                }
                $errorshelper = new ErrorsHelper();
                throw new UnprocessableEntityHttpException($errorshelper->getModelError($model));
            }
        }

        $result = [];
        $result['refresh_token'] = $model->refresh_token;
        $result['access_token'] = $model->access_token;
        $result['expiration_time'] = Yii::$app->params['user.accessTokenExpire'];
        // 关联账号信息
        $user = ArrayHelper::toArray($member);
        $user['avatar'] = ImageHelper::tomedia($user['avatar']);
        $result['user'] = $user;
        $result['addons'] = false;

        // 关联用户的默认模块和商户
        $module_name = AddonsUser::find()->where(['is_default' => 1, 'user_id' => $user['id']])->select('module_name')->scalar();
        $store_id = UserStore::find()->where(['is_default' => 1, 'user_id' => $user['id']])->select('store_id')->scalar();
        $bloc = UserBloc::find()->where(['is_default' => 1, 'user_id' => $user['id']])->with(['bloc'])->asArray()->one();
        if(!empty($bloc) && $bloc['bloc']){
            $bloc['bloc']['logo'] = ImageHelper::tomedia($bloc['bloc']['logo']);
            $result['bloc'] = $bloc['bloc'];
        }

        // 商户为空授权的是公司
        if (!empty($module_name)) {
            $result['addons'] = [
                'module_name' => $module_name,
                'module_info' => DdAddons::find()->where(['identifie' => $module_name])->asArray()->one(),
                'store_id' => $store_id,
            ];
        }

        // 写入缓存
        $this->cache === true && Yii::$app->cache->set($this->getCacheKey($model->access_token), $model, $this->timeout);

        return $result;
    }

    /**
     * 忘记密码.
     *
     * @param User $member
     * @param $password
     * @return string
     *
     * @throws ErrorException
     * @throws Exception
     */
    public function forgetpassword(User $member, $password)
    {
        $member->generatePasswordResetToken();
        $member->setPassword($password);
        $member->generateAuthKey();
        $member->generateEmailVerificationToken();

        return  $member->save(false);
    }

    /**
     * 判断有效期.
     *
     * @param string $token post
     * @param null $type
     * @return bool
     */
    public static function isPeriod(string $token, $type = null): bool
    {
        // 判断验证token有效性是否开启
        if (isset(Yii::$app->params['user.accessTokenValidity'])  && Yii::$app->params['user.accessTokenValidity'] === true) {
            $timestamp = (int) substr($token, strrpos($token, '_') + 1);
            $expire = Yii::$app->params['user.accessTokenExpire'];
            // 验证有效期
            if ($timestamp + $expire <= time()) {
                // 过期
                return true;
            }
        }
        // 未到期
        return false;
    }

    /**
     * 判断refresh_token有效期.
     *
     * @param string $token post
     *
     * @return true
     *
     */
    public static function isPeriodRefToken(string $token, $type = null):bool
    {
        // 判断验证token有效性是否开启
        if (isset(Yii::$app->params['user.refreshTokenValidity'])  && Yii::$app->params['user.refreshTokenValidity'] === true) {
            $timestamp = (int) substr($token, strrpos($token, '_') + 1);
            $expire = Yii::$app->params['user.refreshTokenExpire'];
            // 验证有效期
            if ($timestamp + $expire <= time()) {
                // 过期
                return true;
            }
        }
        // 未到期
        return false;
    }

    /**
     * 修改accesstoken.
     *
     * @param int|null $user_id post
     * @param int $group_id
     * @return string
     *
     * @throws \Exception
     */
    public function RefreshToken(?int $user_id, $group_id = 1): string
    {
        $model = $this->findModel($user_id, $group_id);

        !empty($model->access_token) && Yii::$app->cache->delete($this->getCacheKey($model->access_token));
        $model->access_token = StringHelper::uuid('sha1').'_'.time();
        if ($model->save()) {
            return $model->access_token;
        } else {
            return '修改失败';
        }
    }

    /**
     * @param $token
     * @param $type
     *
     * @return array|mixed|ActiveRecord|null
     */
    public function getTokenToCache($token, $type)
    {
        if (!$this->cache) {
            return $this->findByAccessToken($token);
        }

        $key = $this->getCacheKey($token);
        if (!($model = Yii::$app->cache->get($key))) {
            $model = $this->findByAccessToken($token);
            Yii::$app->cache->set($key, $model, $this->timeout);
        }

        return $model;
    }

    /**
     * 禁用token.
     *
     * @param $access_token
     * @return bool
     */
    public function disableByAccessToken($access_token)
    {
        $this->cache === true && Yii::$app->cache->delete($this->getCacheKey($access_token));

        if ($model = $this->findByAccessToken($access_token)) {
            $model->status = 1;

            return $model->save();
        }

        return false;
    }

    /**
     * 获取token.
     *
     * @param $token
     *
     * @return array|ActiveRecord|AccessToken|null
     */
    public function findByAccessToken($token): AccessToken|array|ActiveRecord|null
    {
        return DdApiAccessToken::find()
            ->where(['access_token' => $token, 'status' => 1])
            ->one();
    }

    /**
     * @param $access_token
     *
     * @return string
     */
    protected function getCacheKey($access_token): string
    {
        // 区分传统模式后台登录
        return $access_token.'_admin';
    }

    /**
     * 注册和登录发送验证码
     *
     * @param [type] $mobile
     * @param array $data
     *
     * @return void
     * @date 2022-07-12
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public function send($mobile, array $data = [])
    {
        $settings = Yii::$app->settings;
        $settings->invalidateCache();
        $config = $settings->getAllBySection('Website');

        Yii::$app->params['conf']['sms'] = [
            'access_key_id' => $config['access_key_id'],
            'access_key_secret' => $config['access_key_secret'],
            'sign_name' => $config['sign_name'],
            'template_code' => $config['template_code'],
        ];

        $res = Yii::$app->service->apiSmsService->sendContent($mobile, $data, $config['template_code']);

        return $res;
    }

    // 修改用户基础信息
    public static function editInfo($user_id, $fields = [])
    {
        $DdMember = new DdUser();
        $res = $DdMember->updateAll($fields, ['id' => $user_id]);

        return $res;
    }

    /**
     * 返回模型.
     *
     * @param $user_id
     * @param $group_id
     * @return ActiveRecord|array|DdApiAccessToken|null
     */
    protected function findModel($user_id, $group_id): DdApiAccessToken|array|ActiveRecord|null
    {
        if (empty(($model = DdApiAccessToken::find()->where([
            'user_id' => $user_id,
            'group_id' => $group_id,
        ])->one()))) {
            $model = new DdApiAccessToken();

            return $model->loadDefaultValues();
        }

        return $model;
    }
}
