<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-10 20:37:35
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-02-03 19:32:51
 */

namespace app\modules\officialaccount\components;

use api\models\DdApiAccessToken;
use api\models\DdMember;
use api\modules\officialaccount\models\DdWechatFans;
use common\helpers\ArrayHelper;
use common\helpers\ErrorsHelper;
use common\helpers\FileHelper;
use common\helpers\StringHelper;
use yii\db\ActiveRecord;
use function GuzzleHttp\json_decode;
use Yii;
use yii\base\BaseObject;

class Fans extends BaseObject
{
    /**
     * 注册fans数据.
     *
     * @param int|null post
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function signup($users)
    {
        $logPath = Yii::getAlias('@runtime/wechat/login/'.date('ymd').'.log');
        FileHelper::writeLog($logPath, '登录日志:用户信息sign'.json_encode($users));

        $openid = $users['openid'];
        $nickname = $users['nickname'];
        $keys = $openid.'_userinfo';
        
        FileHelper::writeLog($logPath, '登录日志:用户信息openid'.json_encode($openid));
        FileHelper::writeLog($logPath, '登录日志:用户信息缓存获取'.json_encode(Yii::$app->cache->get($keys)));

        if (Yii::$app->cache->get($keys)) { //如果有缓存数据则返回缓存数据，没有则从数据库取病存入缓存中
            // 获取缓存
            $res = Yii::$app->cache->get($keys);
            // 验证有效期
            $isPeriod = Yii::$app->service->apiAccessTokenService->isPeriod($res['access_token']);
            FileHelper::writeLog($logPath, '登录日志:有缓存验证有效期'.json_encode($isPeriod));

            if (!$isPeriod) {
                return Yii::$app->cache->get($keys);
            }
        }
        
        $DdMember = new DdMember();
        // 校验openID是否存在

        $fans = $this->fansByopenid($openid);

        FileHelper::writeLog($logPath, '登录日志:校验openid是否存在'.json_encode($fans));

        if (!empty($fans)) {
            FileHelper::writeLog($logPath, '登录日志:有缓存');
            $member = $DdMember::findIdentity($fans['user_id']);
            $userinfo = Yii::$app->service->apiAccessTokenService->getAccessToken($member, 1);
            $userinfo['fans'] = $fans;
            Yii::$app->cache->set($keys, $userinfo);
            FileHelper::writeLog($logPath, '登录日志:有缓存数据'.json_encode($userinfo));

            return $userinfo;
        } else {
            $password = StringHelper::randomNum();

            FileHelper::writeLog($logPath, '登录日志:昵称去除特殊字符'.json_encode($this->removeEmoji($nickname)));

            $nickname = $this->removeEmoji($nickname);

            $nickname = $this->filterEmoji($nickname);
            // 去除斜杠后的数据
            
            FileHelper::writeLog($logPath, '登录日志:处理好以后的昵称：'.$nickname);
            
            if(empty($nickname)){
                // 使用随机昵称
                $strName  = StringHelper::getname();
                $nickname = $strName[0];
            }
            
            $res = $DdMember->signup($nickname, 0, $password);

            FileHelper::writeLog($logPath, '登录日志:会员注册返回结果'.json_encode($res));

            // 更新openid
            $member_id = $res['member']['member_id'];
            FileHelper::writeLog($logPath, '登录日志:获取用户id'.json_encode($member_id));

            $DdMember->updateAll(['openid' => $openid], ['member_id' => $member_id]);
            DdApiAccessToken::updateAll(['openid' => $openid], ['member_id' => $member_id]);
            FileHelper::writeLog($logPath, '登录日志:注册fans'.json_encode($member_id));

            // 注册fans
            // 生成随机的加密键
            $secretKey = Yii::$app->getSecurity()->generateRandomString();
            $dataFans = [
                'user_id' => $member_id,
                'avatarUrl' => $users['avatarUrl'],
                'openid' => $users['openid'],
                'nickname' => $nickname,
                'groupid' => $res['member']['group_id'],
                'fans_info' => $users['openid'],
                'unionid' => !empty($users['unionid']) ? $users['unionid'] : '',
                'gender' => $users['gender'],
                'country' => $users['country'],
                'city' => $users['city'],
                'province' => $users['province'],
                'secretKey' => $secretKey,
            ];
            FileHelper::writeLog($logPath, '登录日志:组装fans'.json_encode($dataFans));

            // 加密fans的所有资料
            // $dataFans['fans_info'] = $this->encrypt($dataFans, $secretKey);
            FileHelper::writeLog($logPath, '登录日志:组装fans001'.json_encode($dataFans));

            $DdWechatFans = new DdWechatFans();
            if ($DdWechatFans->load($dataFans, '') && $DdWechatFans->save()) {
                $res['fans'] = $dataFans;
                FileHelper::writeLog($logPath, '登录日志:组装fans002'.json_encode($res));
                Yii::$app->cache->set($keys, $res);

                return $res;
            } else {
                $errors = ErrorsHelper::getModelError($DdWechatFans);
                FileHelper::writeLog($logPath, '登录日志：写入错误'.json_encode($errors));

                return $errors;
            }
        }
    }

    /**
     * @param $openid
     * @return array|ActiveRecord|null
     */
    public function checkByopenid($openid): array|ActiveRecord|null
    {
        return DdWechatFans::find()->where(['openid' => $openid])->one();
    }

    public function fansByopenid($openid): array|ActiveRecord|null
    {
        return  DdWechatFans::find()->where(['openid' => $openid])->one();
    }

    public function removeEmoji($nickname): array|string|null
    {
        $clean_text = '';
        // Match Emoticons
        $regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
        $clean_text = preg_replace($regexEmoticons, '', $nickname);
        // Match Miscellaneous Symbols and Pictographs
        $regexSymbols = '/[\x{1F300}-\x{1F5FF}]/u';
        $clean_text = preg_replace($regexSymbols, '', $clean_text);
        // Match Transport And Map Symbols
        $regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
        $clean_text = preg_replace($regexTransport, '', $clean_text);
        // Match Miscellaneous Symbols
        $regexMisc = '/[\x{2600}-\x{26FF}]/u';
        $clean_text = preg_replace($regexMisc, '', $clean_text);
        // Match Dingbats
        $regexDingbats = '/[\x{2700}-\x{27BF}]/u';
        return preg_replace($regexDingbats, '', $clean_text);
    }

    public function filterEmoji($str): array|string|null
    {
        return preg_replace_callback('/./u',
        function (array $match) {
            return strlen($match[0]) >= 4 ? '' : $match[0];
        },
        $str);
    }

    /**
     * @param $data
     * @param string $key 密钥
     *
     * @return string
     */
    public static function encrypt($data, string $key): string
    {
        $string = base64_encode(json_encode($data));
        // openssl_encrypt 加密不同Mcrypt，对秘钥长度要求，超出16加密结果不变
        $data = openssl_encrypt($string, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);

        return strtolower(bin2hex($data));
    }

    /**
     * @param string $string 需要解密的字符串
     * @param string $key    密钥
     *
     * @return string
     */
    public static function decrypt(string $string, string $key): string
    {
        $decrypted = openssl_decrypt(hex2bin($string), 'AES-128-ECB', $key, OPENSSL_RAW_DATA);

        return json_decode(base64_decode($decrypted));
    }

     /**
     * 验证token是否一致
     *
     * @param string $signature 微信加密签名，signature结合了开发者填写的token参数和请求中的timestamp参数、nonce参数
     * @param integer $timestamp 时间戳
     * @param integer $nonce 随机数
     * @return bool
     */
    public static function verifyToken(string $signature, int $timestamp, int $nonce): bool
    {
        $logPath = Yii::getAlias('@runtime/wechat/msg/'.date('ymd').'.log');

        $params = Yii::$app->params;
        $wechat_token =  $params['wechatConfig']['token'];
        FileHelper::writeLog($logPath, '配置获取：'.json_encode($params['wechatConfig']));
        $token = $wechat_token ?? '';
        $tmpArr = [$token, $timestamp, $nonce];
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        
        FileHelper::writeLog($logPath, '验证结果：'.json_encode([$tmpStr,$signature]));

        return $tmpStr == $signature;
    }

    /**
     * 告诉微信已经成功了
     *
     * @return bool|string
     */
    public static function success(): bool|string
    {
        return ArrayHelper::toXml(['return_code' => 'SUCCESS', 'return_msg' => 'OK']);
    }

    /**
     * 告诉微信失败了
     *
     * @return bool|string
     */
    public static function fail(): bool|string
    {
        return ArrayHelper::toXml(['return_code' => 'FAIL', 'return_msg' => 'OK']);
    }

}
