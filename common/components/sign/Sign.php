<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-07-16 09:18:03
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-19 14:14:28
 */

namespace common\components\sign;

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
    public $key;

    /**
     * var array optional 需要过滤的方法.
     */
    public $optional = ['*'];

    /**
     * 需要进行验签的环境.
     */
    private $needSignEnvironment = ['beta', 'production'];

    /**
     * 根据key生成密钥 secret是由MD5(key+appid)生成 32位.
     *
     * @return string
     */
    public static function generateSecret($appId = null)
    {
        global $_GPC;
        $apiConf = new Api();
        $apiConf->getApiConf($appId ?: $_GPC['app_id']);
        if (empty($apiConf)) {
            throw new SignException(CodeConst::CODE_90000);
        }

        return $apiConf['app_secret'];
    }

    /**
     * Sign constructor.
     *
     * @throws SignException
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
        // in_array(\Yii::$app->params['server_name'], $this->needSignEnvironment
        // all代表全部需要，*代表全部不需要
        if ((in_array('all', $this->optional) || in_array(Yii::$app->controller->action->id, $this->optional)) && !in_array('*', $this->optional)) {
            $this->validateSign(
                ArrayHelper::merge(\Yii::$app->request->bodyParams, \Yii::$app->request->get(), \Yii::$app->request->post())
            );
        }
    }

    /**
     * 签名验证
     *
     * @param $params
     *
     * @throws SignException
     */
    public function validateSign($params, $appId = '')
    {
        // 验证签名(若通用型签名及固定商户签名均不满足，抛出异常)
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
        if (!isset($params['sign']) || empty($params['sign'])) {
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
        $forAllSign = $this->md5Sign($forAllString, $appId ?: ($params['app_id'] ?? ''));
        // && (!$forMerSign && $forMerSign != $params['sign'])
        if ($params['sign'] != $forAllSign) {
            // Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
            throw new SignException(CodeConst::CODE_90005);
        } else {
            return true;
        }
    }

    /**
     * 除去数组中的空值和签名参数.
     *
     * @param $param
     *
     * @return array 去掉空值与签名参数后的新签名参数组
     */
    public function paramFilter($param)
    {
        $paraFilter = $param;
        unset($paraFilter['sign']); // 剔除sign本身
        array_filter($paraFilter); // 过滤空值
        ksort($paraFilter); // 对数组根据键名升序排序
        reset($paraFilter); // 函数将内部指针指向数组中的第一个元素，并输出
        $data = http_build_query($paraFilter);

        return $data;
    }

    /**
     * 生成md5签名字符串.
     *
     * @param $preStr string 需要签名的字符串
     *
     * @return string 签名结果
     */
    public function md5Sign($preStr, $appId = '')
    {
        // 生成sign  字符串和密钥拼接
        $str = $preStr.'&key='.self::generateSecret($appId);
        var_dump($str);
        $sign = md5($str);

        return strtoupper($sign); // 转成大写
    }

    /**
     * 获取二级域名前缀
     *
     * @return mixed
     */
    public static function getPrefixOfDomain()
    {
        $url = '//'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
        preg_match("#//(.*?)\.#i", $url, $match);

        return $match[1];
    }
}
