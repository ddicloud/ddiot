<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-08-19 13:19:58
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-22 16:51:08
 */

namespace swooleService\models;

use common\helpers\ResultHelper;
use common\models\enums\CodeStatus;
use swooleService\servers\AccessTokenService;
use Yii;
use yii\filters\RateLimitInterface;
use yii\web\IdentityInterface;
use yii\web\UnauthorizedHttpException;

/**
 * This is the model class for table "{{%swoole_access_token}}".
 *
 * @property int         $id
 * @property string|null $refresh_token        刷新令牌
 * @property string|null $access_token         授权令牌
 * @property int|null    $member_id            用户id
 * @property string|null $openid               授权对象openid
 * @property string|null $group_id             组别
 * @property int|null    $bloc_id
 * @property int|null    $store_id
 * @property int|null    $status               状态[-1:删除;0:禁用;1启用]
 * @property int|null    $create_time          创建时间
 * @property int|null    $updated_time         修改时间
 * @property int|null    $login_num            登录次数
 * @property int|null    $allowance
 * @property int|null    $allowance_updated_at
 */
class SwooleAccessToken extends \yii\db\ActiveRecord  implements IdentityInterface, RateLimitInterface
{
    const STATUS_DELETED = 1; //删除
    const STATUS_INACTIVE = 2; //拉黑
    const STATUS_ACTIVE = 0; //正常
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%swoole_access_token}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['swoole_member_id','id','member_id','group_id', 'bloc_id', 'store_id', 'status', 'create_time', 'updated_time', 'login_num', 'allowance', 'allowance_updated_at'], 'integer'],
            [['refresh_token', 'access_token'], 'string', 'max' => 60],
            [['openid'], 'string', 'max' => 50],
            [['access_token'], 'unique'],
            [['swoole_member_id'], 'unique'],
            [['refresh_token'], 'unique'],
        ];
    }

    /**
     * 行为.
     */
    public function behaviors()
    {
        /*自动添加创建和修改时间*/
        return [
            [
                'class' => \common\behaviors\SaveBehavior::className(),
                'updatedAttribute' => 'update_time',
                'createdAttribute' => 'create_time',
            ],
        ];
    }


    public function getRateLimit($request, $action)
    {
        $this->rateLimit = Yii::$app->params['swoole']['rateLimit'];
        $this->timeLimit = Yii::$app->params['swoole']['timeLimit'];

        return [$this->rateLimit, $this->timeLimit];
    }

    public function loadAllowance($request, $action)
    {
        $allowance = Yii::$app->cache->get($this->getCacheKey('swoole_rate_allowance'));
        $timestamp = Yii::$app->cache->get($this->getCacheKey('swoole_rate_timestamp'));

        if ($allowance === false) {
            return [$this->timeLimit, time()];
        }

        return [$allowance, $timestamp];
    }

    public function saveAllowance($request, $action, $allowance, $timestamp)
    {
        Yii::$app->cache->set($this->getCacheKey('swoole_rate_allowance'), $allowance, $this->timeLimit);
        Yii::$app->cache->set($this->getCacheKey('swoole_rate_timestamp'), $timestamp, $this->timeLimit);
        $this->allowance = $allowance;
        $this->allowance_updated_at = $timestamp;
        $this->save();
    }

     /**
     * @param mixed $token
     * @param null  $type
     *
     * @return array|mixed|ActiveRecord|\yii\web\IdentityInterface|null
     *
     * @throws UnauthorizedHttpException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        // 判断验证token有效性是否开启
        if (Yii::$app->params['user.accessTokenValidity'] === true) {
            $timestamp = (int) substr($token, strrpos($token, '_') + 1);
            $expire = Yii::$app->params['user.accessTokenExpire'];
            // 验证有效期
            if ($timestamp + $expire <= time()) {
                throw new UnauthorizedHttpException('您的登录验证已经过期，请重新登录', CodeStatus::getValueByName('token失效'));
            }
        }
        
        $service = new AccessTokenService();
        // 优化版本到缓存读取用户信息 注意需要开启服务层的cache
        return $service->getTokenToCache($token, $type);
    }

    

      /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['swoole_member_id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @return int|string 当前用户ID
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @return string 当前用户的（cookie）认证密钥
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     *
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @param $key
     *
     * @return array
     */
    public function getCacheKey($key)
    {
        return [__CLASS__, $this->getId(), $key];
    }
   

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'refresh_token' => '刷新令牌',
            'access_token' => '授权令牌',
            'member_id' => '用户id',
            'openid' => '授权对象openid',
            'group_id' => '组别',
            'bloc_id' => 'Bloc ID',
            'store_id' => 'Store ID',
            'status' => '状态[-1:删除;0:禁用;1启用]',
            'create_time' => '创建时间',
            'updated_time' => '修改时间',
            'login_num' => '登录次数',
            'allowance' => 'Allowance',
            'allowance_updated_at' => 'Allowance Updated At',
        ];
    }
}
