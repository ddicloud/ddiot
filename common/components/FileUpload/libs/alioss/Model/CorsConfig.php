<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-13 01:14:45
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-26 19:01:42
 */


namespace Alioss\Model;


use Alioss\Core\OssException;
use ErrorException;

/**
 * Class CorsConfig
 * @package OSS\Model
 *
 * @link http://help.aliyun.com/document_detail/oss/api-reference/cors/PutBucketcors.html
 */
class CorsConfig implements XmlConfig
{
    /**
     * CorsConfig constructor.
     */
    public function __construct()
    {
        $this->rules = array();
    }

    /**
     * 得到CorsRule列表
     *
     * @return CorsRule[]
     */
    public function getRules(): array
    {
        return $this->rules;
    }


    /**
     * 添加一条CorsRule
     *
     * @param CorsRule $rule
     * @throws OssException
     */
    public function addRule(CorsRule $rule): void
    {
        if (count($this->rules) >= self::OSS_MAX_RULES) {
            throw new OssException("num of rules in the config exceeds self::OSS_MAX_RULES: " . strval(self::OSS_MAX_RULES));
        }
        $this->rules[] = $rule;
    }

    /**
     * 从xml数据中解析出CorsConfig
     *
     * @param string $strXml
     * @return null
     *@throws OssException
     */
    public function parseFromXml(string $strXml)
    {
        $xml = simplexml_load_string($strXml);
        if (!isset($xml->CORSRule)) return;
        foreach ($xml->CORSRule as $rule) {
            $corsRule = new CorsRule();
            foreach ($rule as $key => $value) {
                if ($key === self::OSS_CORS_ALLOWED_HEADER) {
                    $corsRule->addAllowedHeader(strval($value));
                } elseif ($key === self::OSS_CORS_ALLOWED_METHOD) {
                    $corsRule->addAllowedMethod(strval($value));
                } elseif ($key === self::OSS_CORS_ALLOWED_ORIGIN) {
                    $corsRule->addAllowedOrigin(strval($value));
                } elseif ($key === self::OSS_CORS_EXPOSE_HEADER) {
                    $corsRule->addExposeHeader(strval($value));
                } elseif ($key === self::OSS_CORS_MAX_AGE_SECONDS) {
                    $corsRule->setMaxAgeSeconds(strval($value));
                }
            }
            $this->addRule($corsRule);
        }
        return;
    }

    /**
     * 生成xml字符串
     *
     * @return string
     * @throws OssException
     */
    public function serializeToXml(): string
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><CORSConfiguration></CORSConfiguration>');
        foreach ($this->rules as $rule) {
            $xmlRule = $xml->addChild('CORSRule');
            $rule->appendToXml($xmlRule);
        }
        return $xml->asXML();
    }

    public function __toString()
    {
        try {
            return $this->serializeToXml();
        } catch (OssException $e) {
            throw new ErrorException($e->getMessage());
        }
    }

    const OSS_CORS_ALLOWED_ORIGIN = 'AllowedOrigin';
    const OSS_CORS_ALLOWED_METHOD = 'AllowedMethod';
    const OSS_CORS_ALLOWED_HEADER = 'AllowedHeader';
    const OSS_CORS_EXPOSE_HEADER = 'ExposeHeader';
    const OSS_CORS_MAX_AGE_SECONDS = 'MaxAgeSeconds';
    const OSS_MAX_RULES = 10;

    /**
     * orsRule列表
     *
     * @var CorsRule[]
     */
    private array $rules = array();
}