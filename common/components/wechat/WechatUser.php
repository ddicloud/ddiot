<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-24 12:17:15
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-05-27 18:32:20
 */

namespace common\components\wechat;

use yii\base\Component;

/**
 * Class WechatUser.
 */
class WechatUser extends Component
{
    /**
     * @var string
     */
    public string $id;
    /**
     * @var string
     */
    public string $nickname;
    /**
     * @var string
     */
    public string $name;
    /**
     * @var string
     */
    public string $email;
    /**
     * @var string
     */
    public string $avatar;
    /**
     * @var array
     */
    public array $original;
    /**
     * @var \Overtrue\Socialite\AccessToken
     */
    public \Overtrue\Socialite\AccessToken $token;
    /**
     * @var string
     */
    public string $provider;

    /**
     * @return string
     */
    public function getOpenId(): string
    {
        return $this->original['openid'] ?? '';
    }
}
