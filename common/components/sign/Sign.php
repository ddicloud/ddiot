<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-07-16 09:18:03
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2023-04-27 22:24:55
 */

namespace common\components\sign;

use common\helpers\loggingHelper;
use diandi\addons\models\form\Api;
use Yii;
use yii\base\ActionFilter;
use yii\helpers\ArrayHelper;

class Sign extends ActionFilter
{
    /**
     * 明文key.
     */
    const APP_SECRET = 'navibar'; // 需和前端保持一致

    const APP_ID = '123456'; // 需和前端保持一致

    const C_TIME_LOSE = 30 * 60; // 30分钟失效

    /**
     * var string key 密钥.
     */
    public string $key;

    /**
     * var array optional 需要过滤的方法.
     */
    public array $optional = ['*'];

    /**
     * 需要进行验签的环境.
     */
    private array $needSignEnvironment = ['beta', 'production'];



    /**
     * Sign constructor.
     *
     * @throws SignException
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
        // in_array(\Yii::$App->params['server_name'], $this->needSignEnvironment
        // all代表全部需要，*代表全部不需要
        if ((in_array('all', $this->optional) || in_array(Yii::$app->controller->action->id, $this->optional)) && !in_array('*', $this->optional)) {
            $this->validateSign(
                // ArrayHelper::merge(\Yii::$App->request->bodyParams, \Yii::$App->request->get(), \Yii::$App->request->post())
                \Yii::$app->request->post()
            );
        }
    }

    /**
     * 根据key生成密钥 secret是由MD5(key+appid)生成 32位.
     *
     * @return string
     */
    public static function generateSecret(): string
    {
        global $_GPC;
        $apiConf = new Api();
        $apiConf->getConf(Yii::$app->request->input('bloc_id'));
        loggingHelper::writeLog('sign', 'generateSecret', 'app_secret', [
            'app_secret' => $apiConf['app_secret'],
            'app_id' => $apiConf['app_id'],
        ]);

        return md5($apiConf['app_secret'] . $apiConf['app_id']);
    }

    /**
     * 签名验证
     *
     * @param $params
     *
     * @return true
     * @throws SignException
     */
    public function validateSign($params): bool
    {
        // 验证签名(若通用型签名及固定商户签名均不满足，抛出异常)
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
        // 验证签名(若通用型签名及固定商户签名均不满足，抛出异常)
        if (empty($params['sign'])) {
            throw new SignException(CodeConst::CODE_90001);
        }

        if (!isset($params['timestamp']) || !$params['timestamp']) {
            throw new SignException(CodeConst::CODE_90002);
        }
        // 验证请求， 10分钟失效
        if (time() - $params['timestamp'] > self::C_TIME_LOSE) {
            throw new SignException(CodeConst::CODE_90004);
        }

        // 获取通用型的签名
        $forAllString = $this->paramFilter($params);  // 参数处理
        $forAllSign = $this->md5Sign($forAllString, $params['appid']);
        // && (!$forMerSign && $forMerSign != $params['sign'])
        if ($params['sign'] != $forAllSign) {
            throw  new SignException(CodeConst::CODE_90005);
        } else {
            return true;
        }
    }

    /**
     * 除去数组中的空值和签名参数.
     *
     * @param $param
     *
     * @return string 去掉空值与签名参数后的新签名参数组
     */
    public function paramFilter($param): string
    {
        $paraFilter = $param;
        unset($paraFilter['sign']); // 剔除sign本身
        array_filter($paraFilter); // 过滤空值
        ksort($paraFilter); // 对数组根据键名升序排序
        reset($paraFilter); // 函数将内部指针指向数组中的第一个元素，并输出
        return http_build_query($paraFilter);
    }

    /**
     * 生成md5签名字符串.
     *
     * @param $preStr string 需要签名的字符串
     * @param string $appId
     * @return string 签名结果
     * @throws SignException
     */
    public function md5Sign(string $preStr, string $appId = ''): string
    {
        // 生成sign  字符串和密钥拼接
        $str = $preStr . '&key=' . self::generateSecret();
        loggingHelper::writeLog('sign', 'md5Sign', '签名前数据', [$str, $appId]);
        $sign = md5($str);
        loggingHelper::writeLog('sign', 'md5Sign', '签名后数据', strtoupper($sign));

        return strtoupper($sign); // 转成大写
    }

    /**
     * 获取二级域名前缀
     *
     * @return mixed
     */
    public static function getPrefixOfDomain(): mixed
    {
        $url = '//' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
        preg_match("#//(.*?)\.#i", $url, $match);

        return $match[1];
    }
}
