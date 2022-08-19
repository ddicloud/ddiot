<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-12 01:50:17
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-19 14:45:49
 */

namespace swooleService\servers;

use api\modules\officialaccount\models\DdWechatFans;
use api\modules\wechat\models\DdWxappFans;
use common\helpers\ArrayHelper;
use common\helpers\ErrorsHelper;
use common\helpers\loggingHelper;
use common\helpers\StringHelper;
use common\models\DdMember;
use common\services\BaseService;
use swooleService\models\SwooleAccessToken;
use swooleService\models\SwooleMember;
use Yii;
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
    public $cache = true;

    /**
     * 缓存过期时间.
     *
     * @var int
     */
    public $timeout;

    /**
     * 获取token.
     *
     * @param int $cycle_index 重新获取次数
     *
     * @return array
     *
     * @throws \yii\base\Exception
     */
    public function getAccessToken(SwooleMember $member, $group_id, $cycle_index = 1)
    {
        $model = $this->findModel($member->id, $group_id);

        $model->swoole_member_id = $member->id;
        
        $model->member_id = $member->member_id;

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
        $member = ArrayHelper::toArray($member);
        $result['member'] = $member;
        // 获取fans数据
        $result['wechatFans'] = DdWechatFans::find()->where(['user_id' => $member['member_id']])->asArray()->one();
        $result['wxappFans'] = DdWxappFans::find()->where(['user_id' => $member['member_id']])->asArray()->one();
        $result['user'] = DdMember::find()->where(['member_id' => $member['member_id']])->asArray()->one();

        $this->upLoginNum($result['access_token']);
        $this->cache === true && Yii::$app->cache->set($this->getCacheKey($model->access_token), $model, $this->timeout);

        return $result;
    }

    /**
     * 忘记密码.
     *
     * @param int|null post
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function forgetpassword(SwooleMember $member, $mobile, $password)
    {
        $member->generatePasswordResetToken();
        $member->setPassword($password);
        $member->generateAuthKey();
        $member->generateEmailVerificationToken();

        return  $member->save(false);
    }

    /**
     * 判断access-token有效期.
     *
     * @param int|null post
     *
     * @return 到期：true
     *
     * @throws NotFoundHttpException
     */
    public static function isPeriod($token, $type = null)
    {
        loggingHelper::writeLog('AccessTokenService', 'isPeriod', '重复获取', [
            'token' => $token,
        ]);

        // 判断验证token有效性是否开启
        if (Yii::$app->params['user.accessTokenValidity'] === true) {
            $timestamp = (int) substr($token, strrpos($token, '_') + 1);

            loggingHelper::writeLog('AccessTokenService', 'isPeriod', '时间分割', [
                'timestamp' => $timestamp,
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
     * @param int|null post
     *
     * @return 到期：true
     *
     * @throws NotFoundHttpException
     */
    public static function isPeriodRefToken($token, $type = null)
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
     * @param int|null post
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function RefreshToken($member_id, $group_id = 1)
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
     * @param $token
     * @param $type
     *
     * @return array|mixed|ActiveRecord|null
     */
    public function getTokenToCache($token, $type)
    {
        if ($this->cache == false) {
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
    public function findByAccessToken($token)
    {
        return SwooleAccessToken::find()
            ->where(['access_token' => $token, 'status' => 1])
            ->one();
    }

    /**
     * 更新登录次数.
     *
     * @param $token
     *
     * @return array|ActiveRecord|AccessToken|null
     */
    public function upLoginNum($token)
    {
        return SwooleAccessToken::updateAllCounters(['login_num' => 1], ['access_token' => $token]);
    }

    /**
     * @param $access_token
     *
     * @return string
     */
    protected function getCacheKey($access_token)
    {
        return $access_token;
    }

    /**
     * 返回模型.
     *
     * @param $member_id
     *
     * @return array|AccessToken|ActiveRecord|null
     */
    protected function findModel($member_id, $group_id)
    {
        if (empty(($model = SwooleAccessToken::find()->where([
            'member_id' => $member_id,
            'group_id' => $group_id,
        ])->one()))) {
            $model = new SwooleAccessToken();

            return $model->loadDefaultValues();
        }

        return $model;
    }
}
