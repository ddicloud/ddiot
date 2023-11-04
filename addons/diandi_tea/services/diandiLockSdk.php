<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-06-21 13:50:41
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-22 19:52:58
 */

namespace addons\diandi_tea\services;

use common\helpers\loggingHelper;
use common\helpers\ResultHelper;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Yii;
use yii\base\BaseObject;
use yii\base\ErrorException;
use yii\base\InvalidCallException;

class diandiLockSdk extends BaseObject
{
    public static string $apiUrl = 'https://www.dandicloud.cn';

    public static string $username;

    public static string $password;

    public static int $bloc_id;

    public static int $store_id;

    public static string $client_secret;

    public static string $access_token;
    public static int $uid;
    public static string $refresh_token;
    public static int $expires_in;

    public static string $auth_key = 'diandiLockSdk-token';

    public static array $header = [
        'ContentType' => 'application/x-www-form-urlencoded',
    ];

    /**
     * @throws ErrorException
     */
    public static function __init(): void
    {
        $confPath = yii::getAlias('@addons/diandi_tea/config/diandi.php');
        if (file_exists($confPath)) {
            $config = require $confPath;
            self::$username = $config['username'];
            self::$password = $config['password'];
            self::$bloc_id = (int)$config['bloc_id'];
            self::$store_id = (int)$config['store_id'];
            // 鉴权
            try {
                self::apartmentLogin(self::$username, self::$password);
            } catch (GuzzleException $e) {
                throw new ErrorException($e->getMessage());
            }
        } else {
            self::putAuthConf();
        }
    }

    /**
     * 统一请求
     *
     * @param $datas
     * @param $url
     * @param array $headers 请求头部
     *
     * @return array
     * @throws GuzzleException
     * @date 2022-05-11
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public static function postHttp($datas, $url, array $headers = []): array
    {
        $headersToeken = array_merge(self::$header, [
            'access-token' => self::$access_token,
            'store-id' => self::$store_id,
            'bloc-id' => self::$bloc_id,
        ]);
        $headers = array_merge(self::$header, $headers, $headersToeken);
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => self::$apiUrl,
            // You can set any number of default request options.
            'timeout' => 10,
        ]);

        $res = $client->request('POST', $url, [
            'form_params' => $datas,
            'headers' => $headers,
        ]);

        $body = $res->getBody();
        $remainingBytes = $body->getContents();

        return self::analysisRes(json_decode($remainingBytes, true));
    }

    public static function createData($data)
    {
        return $data;
    }

    // 解析返回的内容
    public static function analysisRes($Res)
    {
        if ((int)$Res['errcode']) {
            throw new InvalidCallException($Res['message']);
        } else {
//            $data = [
//                'code' => $Res['resultCode'],
//                'content' => $Res['reason'],
//            ];

            return $Res;
        }
    }

    /**
     * 鉴权V1.0.
     *
     * @param $username
     * @param $password
     * @return array
     * @throws GuzzleException
     */
    public static function apartmentLogin($username, $password): array
    {
        $key = self::$auth_key;
        $tokenIdS = Yii::$app->cache->get($key);

        if (!empty($tokenIdS['access_token'])) {
            self::$access_token = $tokenIdS['access_token'];
            self::$uid = $tokenIdS['uid'];
            self::$refresh_token = $tokenIdS['refresh_token'];
            self::$expires_in = $tokenIdS['expires_in'];
        } else {
            $data = self::createData([
                'username' => $username,
                'password' => $password,
            ]);
            $Res = self::postHttp($data, '/api/user/login');
            if ($Res['code'] === 200) {
                self::$access_token = $Res['data']['access_token'];
                self::$uid = $Res['data']['uid'];
                self::$refresh_token = $Res['data']['refresh_token'];
                self::$expires_in = $Res['data']['expiration_time'];
                Yii::$app->cache->set($key, [
                    'access_token' => $Res['data']['access_token'],
                    'uid' => $Res['data']['member']['member_id'],
                    'refresh_token' => $Res['data']['refresh_token'],
                    'expires_in' => $Res['data']['expiration_time'],
                ], $Res['data']['expiration_time']);
            }
        }
        return ResultHelper::json(200, '登录成功');
    }

    public static function putAuthConf($username = '', $password = '', $bloc_id = '', $store_id = ''): void
    {
        $confPath = yii::getAlias('@addons/diandi_tea/config/diandi.php');
        if (!file_exists($confPath)) {
            $config = self::local_auth_config();
            $config = str_replace([
                '{username}', '{password}', '{bloc_id}', '{store_id}',
            ], [
                $username, $password, $bloc_id, $store_id,
            ], $config);
            file_put_contents($confPath, $config);
        }
    }

    /**
     * 智能开关控制.
     *
     * @param $ext_room_id
     * @param $switch_type
     * @param $delay
     * @param $ext_event_id
     * @param bool $is_queue （是否使用队列）
     *
     * @return array
     * @throws GuzzleException
     * @date 2022-06-28
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public static function switchStatue($ext_room_id, $switch_type, $delay, $ext_event_id, bool $is_queue = false): array
    {
        $data = self::createData([
            'ext_room_id' => $ext_room_id,
            'switch_type' => $switch_type,
            'delay' => $delay,
            'ext_event_id' => $ext_event_id,
            'is_queue' => $is_queue,
        ]);
        loggingHelper::writeLog('diandi_tea', 'diandiLockSdk/switchStatue', '开关操作数据', $data);
        $Res = self::postHttp($data, '/api/diandi_switch/open/switch');
        loggingHelper::writeLog('diandi_tea', 'diandiLockSdk/switchStatue', '开关操作数据结果', $Res);

        if ($Res['code'] === 200) {
            return $Res['data'];
        } elseif (in_array($Res['code'], [402, 403])) {
            $key = self::$auth_key;
            Yii::$app->cache->set($key, '');
            try {
                self::__init();
            } catch (ErrorException $e) {
                return ResultHelper::json(400, $e->getMessage(), (array)$e);
            }
            return self::switchStatue($ext_room_id, $switch_type, $delay, $is_queue);
        }
        return ResultHelper::json(200, '控制成功');
    }

    /**
     * 创建开锁订单.修改结束时间表示延迟权限.
     *
     * @param $ext_order_id
     * @param $member_id
     * @param $password
     * @param $ext_room_id
     * @param $start_time
     * @param $end_time
     * @return array
     * @throws GuzzleException
     * @date 2022-06-28
     *
     * @example
     *
     * @author Wang Chunsheng
     *
     * @since
     */
    public function createLockOrder($ext_order_id, $member_id, $password, $ext_room_id, $start_time, $end_time): array
    {
        $data = self::createData([
            'ext_order_id' => $ext_order_id,
            'member_id' => $member_id,
            'password' => $password,
            'ext_room_id' => $ext_room_id,
            'start_time' => $start_time,
            'end_time' => $end_time,
        ]);
        loggingHelper::writeLog('diandi_tea', 'diandiLockSdk/createLockOrder', '创建开锁订单数据', $data);

        $Res = self::postHttp($data, '/api/diandi_doorlock/order/create');
        loggingHelper::writeLog('diandi_tea', 'diandiLockSdk/createLockOrder', '创建开锁订单结果', $Res);

        if ($Res['code'] === 200) {
            return $Res['data'];
        } elseif (in_array($Res['code'], [402, 403])) {
            $key = self::$auth_key;
            Yii::$app->cache->set($key, '');
            try {
                self::__init();
            } catch (ErrorException $e) {
                return ResultHelper::json(400, $e->getMessage(), (array)$e);
            }
            return self::createLockOrder($ext_order_id, $member_id, $password, $ext_room_id, $start_time, $end_time);
        }
        return ResultHelper::json(400, '创建订单失败');
    }

    public function LockOpen($hourse_id, $pwd, $phoneNo, $keyName, $lock_type, $member_id, $ext_order_id)
    {
        $data = self::createData([
            'hourse_id' => $hourse_id,
            'pwd' => $pwd,
            'phoneNo' => $phoneNo,
            'keyName' => $keyName,
            'lock_type' => $lock_type,
            'member_id' => $member_id,
            'ext_order_id' => $ext_order_id,
        ]);

        loggingHelper::writeLog('diandi_tea', 'diandiLockSdk/LockOpen', '开锁数据', $data);

        try {
            $Res = self::postHttp($data, '/api/diandi_doorlock/lock/openlock');
            loggingHelper::writeLog('diandi_tea', 'diandiLockSdk/LockOpen', '开锁结果', $Res);

            if ((int) $Res['code'] === 200) {
                return $Res['data'];
            } elseif (in_array($Res['code'], [402, 403])) {
                $key = self::$auth_key;
                Yii::$app->cache->set($key, '');
                try {
                    self::__init();
                } catch (ErrorException $e) {
                    return ResultHelper::json(400, $e->getMessage(), (array)$e);
                }
                return self::LockOpen($hourse_id, $pwd, $phoneNo, $keyName, $lock_type, $member_id, $ext_order_id);
            }
        } catch (GuzzleException $e) {
            return ResultHelper::json(400, $e->getMessage(), (array)$e);
        }

        return ResultHelper::json(400,'开锁失败');
    }

    public static function local_auth_config(): string
    {
        $cfg = <<<EOF
<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-18 16:51:31
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-02-28 10:21:41
 */

return [
    'username' => '{username}',
    'password' => '{password}',
    'bloc_id' => '{bloc_id}',
    'store_id' => '{store_id}',
];
EOF;

        return trim($cfg);
    }
}

try {
    diandiLockSdk::__init();
} catch (ErrorException $e) {
    throw new ErrorException($e->getMessage());
}
