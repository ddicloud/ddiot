<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-12 16:40:19
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-01-23 18:37:02
 */

namespace admin\models;

use common\helpers\loggingHelper;
use Yii;
use common\models\DdMemberGroup;
use common\models\enums\CodeStatus;
use common\models\User;
use diandi\admin\models\UserGroup;
use yii\web\UnauthorizedHttpException;
use yii\web\IdentityInterface;
use yii\db\ActiveRecord;
use yii\filters\RateLimitInterface;

/**
 * This is the model class for table "dd_admin_access_token".
 *
 * @public int         $id
 * @public string|null $refresh_token 刷新令牌
 * @public string|null $access_token  授权令牌
 * @public int|null    $user_id     用户id
 * @public string|null $openid        授权对象openid
 * @public string|null $group         组别
 * @public int|null    $status        状态[-1:删除;0:禁用;1启用]
 * @public int|null    $create_time   创建时间
 * @public int|null    $updated_time  修改时间
 */


class DdApiAccessToken extends ActiveRecord implements IdentityInterface, RateLimitInterface
{
    const STATUS_DELETED = -1; //删除
    const STATUS_INACTIVE = 0; //禁用
    const STATUS_ACTIVE = 1; //正常启用

    // 次数限制
    public int  $rateLimit;

    // 时间范围
    public int  $timeLimit;
 
    public int  $auth_key;

    
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%user_access_token}}';
    }

    /**
     * 行为.
     */
    public function behaviors(): array
    {
        /*自动添加创建和修改时间*/
        return [
            [
                'class' => \common\behaviors\SaveBehavior::className(),
                'updatedAttribute' => 'create_time',
                'createdAttribute' => 'update_time',
            ],
        ];
    }

    public function getRateLimit($request, $action): array
    {
        $this->rateLimit = Yii::$app->params['api']['rateLimit'];
        $this->timeLimit = Yii::$app->params['api']['timeLimit'];
      
        return [$this->rateLimit, $this->timeLimit];
    }

    public function loadAllowance($request, $action): array
    {
        $allowance = Yii::$app->cache->get($this->getCacheKey('api_rate_allowance'));
        $timestamp = Yii::$app->cache->get($this->getCacheKey('api_rate_timestamp'));

        if ($allowance === false) {
            return [$this->timeLimit, time()];
        }

        return [$allowance, $timestamp];
    }

    public function saveAllowance($request, $action, $allowance, $timestamp): void
    {
        Yii::$app->cache->set($this->getCacheKey('api_rate_allowance'), $allowance, $this->timeLimit);
        Yii::$app->cache->set($this->getCacheKey('api_rate_timestamp'), $timestamp, $this->timeLimit);
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['group_id', 'status', 'allowance', 'allowance_updated_at', 'create_time', 'updated_time'], 'integer'],
            [['refresh_token', 'access_token'], 'string', 'max' => 60],
            [['openid'], 'string', 'max' => 50],
            [['access_token'], 'unique'],
            [['refresh_token'], 'unique'],
        ];
    }

    /**
     * @param mixed $token
     * @param null  $type
     *
     * @return array|mixed|ActiveRecord|IdentityInterface|null
     *
     * @throws UnauthorizedHttpException
     */
    public static function findIdentityByAccessToken($token, $type = null): mixed
    {
        
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        // 判断验证token有效性是否开启
        if (Yii::$app->params['user.accessTokenValidity'] === true) {
            $timestamp = (int) substr($token, strrpos($token, '_') + 1);
            $expire = Yii::$app->params['user.accessTokenExpire'];

            // 验证有效期
            if ($timestamp + $expire <= time()) {
        
                throw new UnauthorizedHttpException('您的登录验证已经过期，请重新登录',CodeStatus::getValueByName('token失效'));
                
            }
        }
        $service = Yii::$app->service;
        $service->namespace = 'admin';
        // 优化版本到缓存读取用户信息 注意需要开启服务层的cache
        return $service->AccessTokenService->getTokenToCache($token, $type);
    }

    /**
     * @param $token
     * @param null $group
     *
     * @return DdApiAccessToken|null
     */
    public static function findIdentityByRefreshToken($token, $group = null): ?DdApiAccessToken
    {
        return static::findOne(['group_id' => $group, 'refresh_token' => $token, 'status' => 1]);
    }



    /**
     * 关联用户.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMember(): \yii\db\ActiveQuery
    {
        return $this->hasOne(User::class, ['user_id' => 'user_id']);
    }

    /**
     * 关联授权角色.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMemberGroup(): \yii\db\ActiveQuery
    {
        return $this->hasOne(UserGroup::class, ['id' => 'group_id'])
            ->where(['type' => Yii::$app->id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id): DdApiAccessToken|IdentityInterface|null
    {
        return static::findOne(['user_id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @return int|string 当前用户ID
     */
    public function getId(): int|string
    {
        return $this->user_id;
    }

    /**
     * @return int|string 当前用户的（cookie）认证密钥
     */
    public function getAuthKey(): int|string
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     *
     * @return bool if an auth key is valid for current user
     */
    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @param $key
     *
     * @return array
     */
    public function getCacheKey($key): array
    {
        return [__CLASS__, $this->getId(), $key];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'refresh_token' => 'Refresh Token',
            'access_token' => 'Access Token',
            'user_id' => '用户id',
            'openid' => 'Openid',
            'group_id' => '用户组',
            'status' => '用户状态',
            'create_time' => 'Create Time',
            'updated_time' => 'Updated Time',
        ];
    }
}
