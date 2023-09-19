<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-07-05 00:49:21
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-22 16:12:52
 */

namespace common\helpers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;

/**
 * 格式化数据返回.
 *
 * Class ResultHelper
 *
 * @author chunchun <2192138785@qq.com>
 */
class ResultHelper
{
    /**
     * @param int $code
     * @param string $message
     * @param array $data
     *
     * @return array
     */
    public static function json(int $code = 404, string $message = '未知错误', array $data = []): array
    {
        if (!empty($data) && is_array($data)) {
            if (array_key_exists('code', $data)) {
                return $data;
            }
        }
        if (in_array(Yii::$app->id, ['api', 'OAUTH2'])) {
            return static::api($code, $message, $data);
        }

        return static::baseJson($code, $message, $data);
    }

    public static function serverJson($status, $msg, $data = []): array
    {
        if (Yii::$app->id != 'App-console') {
            Yii::$app->response->format = Response::FORMAT_JSON;
        }

        return [
            'status' => $status,
            'message' => trim($msg),
            'data' => $data,
        ];
    }

    public static function socketJson($type, $code = 404, $message = '未知错误', $data = [])
    {
        if (!empty($data) && is_array($data)) {
            if (array_key_exists('code', $data)) {
                return $data;
            }
        }

        if (in_array(Yii::$app->id, ['api', 'OAUTH2'])) {
            return static::api($code, $message, $data);
        }

        return static::SocketBaseJson($type, $code, $message, $data);
    }


    /**
     * 返回json数据格式.
     *
     * @param int $code 状态码
     * @param string $message 返回的报错信息
     * @param array $data 返回的数据结构
     * @return array
     */
    protected static function baseJson(int $code, string $message, array $data): array
    {
        if (Yii::$app->id != 'App-console') {
            Yii::$app->response->format = Response::FORMAT_JSON;
        }

        return [
            'code' => (int) $code,
            'message' => trim($message),
            'data' => $data ? ArrayHelper::toArray($data) : [],
        ];
    }

    /**
     * 返回json字符串数据格式.
     *
     * @param $type
     * @param int $code 状态码
     * @param string $message 返回的报错信息
     * @param array $data 返回的数据结构
     * @return string
     */
    protected static function SocketBaseJson($type, int $code, string $message, array $data): string
    {
        $result = [
            'type' => $type,
            'data' => [
                'code' => (int) $code,
                'message' => trim($message),
                'data' => $data ? ArrayHelper::toArray($data) : [],
            ],
        ];

        return json_encode($result);
    }

    /**
     * 返回 array 数据格式 api 自动转为 json.
     *
     * @param int $code 状态码 注意：要符合http状态码
     * @param string $message 返回的报错信息
     * @param array $data 返回的数据结构
     * @return array|mixed|object[]|string[]
     */
    protected static function api(int $code, string $message, array $data): mixed
    {
        Yii::$app->response->setStatusCode($code, $message);
        Yii::$app->response->data = $data ? ArrayHelper::toArray($data) : [];

        return Yii::$app->response->data;
    }
}
