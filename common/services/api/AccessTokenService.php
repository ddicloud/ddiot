<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-12 01:50:17
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-03-13 09:45:08
 */

namespace common\services\api;

use api\modules\officialaccount\models\DdWechatFans;
use api\models\DdApiAccessToken;
use api\models\DdMember;
use api\modules\wechat\models\DdWxappFans;
use common\helpers\ArrayHelper;
use common\helpers\ErrorsHelper;
use common\helpers\loggingHelper;
use common\helpers\ResultHelper;
use common\helpers\StringHelper;
use common\services\BaseService;
use Yii;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\db\ActiveRecord;
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
    public int $timeout;

    /**
     * 获取token.
     *
     * @param DdMember $member
     * @param $group_id
     * @param int $cycle_index 重新获取次数
     *
     * @return array
     *
     * @throws UnprocessableEntityHttpException
     * @throws Exception
     */
    public function getAccessToken(DdMember $member, $group_id, int $cycle_index = 1): array
    {
        $model = $this->findModel($member->id, $group_id);
        $member_id = $member->id;
        $model->member_id = $member->id;

        $model->group_id = $group_id;

        loggingHelper::writeLog('AccessTokenService', 'getAccessToken', '获取开始', [
            'member' => $member->id,
            'group_id' => $group_id,
            'time' => date('Y-m-d H:i:s'),
        ]);

        /* access-token 是否到期，到期就重置 */
        if ($this->isPeriod($model->access_token) || empty($model->access_token)) {
            // 删除缓存
            !empty($model->access_token) && Yii::$app->cache->delete($this->getCacheKey($model->access_token));
            if ($this->isPeriodRefToken($model->refresh_token) || empty($model->refresh_token)) {
                loggingHelper::writeLog('AccessTokenService', 'getAccessToken', '刷新refresh_token', [
                    'model' => $model,
                    'time' => date('Y-m-d H:i:s'),
                    'expire' => Yii::$app->params['user.refreshTokenExpire'],
                    'refresh_token' => $model->refresh_token,
                    'isPeriodRefToken' => $this->isPeriodRefToken($model->refresh_token),
                ]);
                $model->refresh_token = StringHelper::uuid('sha1').'_'.time();
            }
            $model->access_token = StringHelper::uuid('sha1').'_'.time();
            $model->status = 1;
            if (!$model->save()) {
                if ($cycle_index <= 3) {
                    ++$cycle_index;
                    loggingHelper::writeLog('AccessTokenService', 'getAccessToken', '重复获取', [
                        'model' => $model,
                        'time' => date('Y-m-d H:i:s'),
                        'access_token' => $model->access_token,
                        'cycle_index' => $cycle_index,
                    ]);

                    return self::getAccessToken($member, $group_id, $cycle_index);
                }
                $errorshelper = new ErrorsHelper();
                throw new UnprocessableEntityHttpException($errorshelper->getModelError($model));
            }
        }

        $result = [];
        $result['refresh_token'] = $model->refresh_token;
        $result['access_token'] = $model->access_token;
        $result['login_num'] = $model->login_num;
        $result['expiration_time'] = Yii::$app->params['user.accessTokenExpire'];
        // 关联账号信息
        $account = $member->account;
        $member = ArrayHelper::toArray($member);
        $result['member'] = $member;
        $result['member']['account'] = ArrayHelper::toArray($account);
        // 获取fans数据
        $result['wechatFans'] = DdWechatFans::find()->where(['user_id' => $member_id])->asArray()->one();
        $result['wxappFans'] = DdWxappFans::find()->where(['user_id' => $member_id])->asArray()->one();

        
        loggingHelper::writeLog('AccessTokenService', 'getAccessToken', '获取sql', [
            'member' => DdWxappFans::find()->where(['user_id' => $member_id])->createCommand()->getRawSql()
        ]);

        $this->upLoginNum($result['access_token']);
        // 写入缓存 暂时解决方案
        $keys = $member['openid'].'_userinfo';
        Yii::$app->cache->delete($keys);
        $this->cache === true && Yii::$app->cache->set($this->getCacheKey($model->access_token), $model, $this->timeout);

        return $result;
    }

    /**
     * 忘记密码.
     *
     * @param DdMember $member
     * @param $mobile
     * @param $password
     * @return array|object[]|string|string[]
     */
    public function forgetpassword(DdMember $member, $mobile, $password): array|string
    {
        try {
            $member->generatePasswordResetToken();
            $member->setPassword($password);
            $member->generateAuthKey();
            $member->generateEmailVerificationToken();
        } catch (ErrorException|Exception $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        }


        return  $member->save(false);
    }

    /**
     * 判断access-token有效期.
     *
     * @param string $token post
     *
     * @return  true
     *
     */
    public static function isPeriod(string $token, $type = null): bool
    {
        loggingHelper::writeLog('AccessTokenService', 'isPeriod', '重复获取', [
            'token' => $token
        ]);

        // 判断验证token有效性是否开启
        if (Yii::$app->params['user.accessTokenValidity'] === true) {
            $timestamp = (int) substr($token, strrpos($token, '_') + 1);
            
            loggingHelper::writeLog('AccessTokenService', 'isPeriod', '时间分割', [
                'timestamp' => $timestamp
            ]);
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
     *
     */
    public static function isPeriodRefToken(string $token, $type = null): bool
    {
        // 判断验证token有效性是否开启
        if (Yii::$app->params['user.refreshTokenValidity'] === true) {
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
     * @param int|null $member_id post
     * @param int $group_id
     * @return string
     *
     * @throws \Exception
     */
    public function RefreshToken(?int $member_id, int $group_id = 1): string
    {
        $model = $this->findModel($member_id, $group_id);

        !empty($model->access_token) && Yii::$app->cache->delete($this->getCacheKey($model->access_token));
        $model->access_token = StringHelper::uuid('sha1').'_'.time();
        if ($model->save()) {
            return $model->access_token;
        } else {
            return '修改失败';
        }
    }

    /**
     * @param string $token
     * @return array|mixed|ActiveRecord|null
     */
    public function getTokenToCache(string $token): mixed
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
     * @param string $access_token
     * @return bool
     */
    public function disableByAccessToken(string $access_token): bool
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
     * @return array|ActiveRecord|DdApiAccessToken|null
     */
    public function findByAccessToken($token): DdApiAccessToken|array|ActiveRecord|null
    {
        return DdApiAccessToken::find()
            ->where(['access_token' => $token, 'status' => 1])
            ->one();
    }

    /**
     * 更新登录次数.
     *
     * @param $token
     *
     * @return int
     */
    public function upLoginNum($token): int
    {
        return DdApiAccessToken::updateAllCounters(['login_num' => 1], ['access_token' => $token]);
    }

    /**
     * @param $access_token
     *
     * @return string
     */
    protected function getCacheKey($access_token): string
    {
        return $access_token;
    }

    /**
     * 返回模型.
     *
     * @param $member_id
     * @param $group_id
     * @return array|DdApiAccessToken|ActiveRecord|null
     */
    protected function findModel($member_id, $group_id): DdApiAccessToken|array|ActiveRecord|null
    {
        if (empty(($model = DdApiAccessToken::find()->where([
            'member_id' => $member_id,
            'group_id' => $group_id,
        ])->one()))) {
            $model = new DdApiAccessToken();

            return $model->loadDefaultValues();
        }

        return $model;
    }
}
