<?php

namespace Alioss\Model;

use Alioss\Core\OssException;


/**
 * Class CorsRule
 * @package OSS\Model
 * @link http://help.aliyun.com/document_detail/oss/api-reference/cors/PutBucketcors.html
 */
class CorsRule
{
    /**
     * Rule中增加一条allowedOrigin
     *
     * @param string $allowedOrigin
     */
    public function addAllowedOrigin(string $allowedOrigin): void
    {
        if (!empty($allowedOrigin)) {
            $this->allowedOrigins[] = $allowedOrigin;
        }
    }

    /**
     * Rule中增加一条allowedMethod
     *
     * @param string $allowedMethod
     */
    public function addAllowedMethod(string $allowedMethod): void
    {
        if (!empty($allowedMethod)) {
            $this->allowedMethods[] = $allowedMethod;
        }
    }

    /**
     * Rule中增加一条allowedHeader
     *
     * @param string $allowedHeader
     */
    public function addAllowedHeader(string $allowedHeader): void
    {
        if (!empty($allowedHeader)) {
            $this->allowedHeaders[] = $allowedHeader;
        }
    }

    /**
     * Rule中增加一条exposeHeader
     *
     * @param string $exposeHeader
     */
    public function addExposeHeader(string $exposeHeader): void
    {
        if (!empty($exposeHeader)) {
            $this->exposeHeaders[] = $exposeHeader;
        }
    }

    /**
     * @return int|null
     */
    public function getMaxAgeSeconds(): ?int
    {
        return $this->maxAgeSeconds;
    }

    /**
     * @param int $maxAgeSeconds
     */
    public function setMaxAgeSeconds(int $maxAgeSeconds): void
    {
        $this->maxAgeSeconds = $maxAgeSeconds;
    }

    /**
     * 得到AllowedHeaders列表
     *
     * @return string[]
     */
    public function getAllowedHeaders(): array
    {
        return $this->allowedHeaders;
    }

    /**
     * 得到AllowedOrigins列表
     *
     * @return string[]
     */
    public function getAllowedOrigins(): array
    {
        return $this->allowedOrigins;
    }

    /**
     * 得到AllowedMethods列表
     *
     * @return string[]
     */
    public function getAllowedMethods(): array
    {
        return $this->allowedMethods;
    }

    /**
     * 得到ExposeHeaders列表
     *
     * @return string[]
     */
    public function getExposeHeaders(): array
    {
        return $this->exposeHeaders;
    }

    /**
     * 根据提供的xmlRule， 把this按照一定的规则插入到$xmlRule中
     *
     * @param \SimpleXMLElement $xmlRule
     * @throws OssException
     */
    public function appendToXml(\SimpleXMLElement &$xmlRule): void
    {
        if (!isset($this->maxAgeSeconds)) {
            throw new OssException("maxAgeSeconds is not set in the Rule");
        }
        foreach ($this->allowedOrigins as $allowedOrigin) {
            $xmlRule->addChild(CorsConfig::OSS_CORS_ALLOWED_ORIGIN, $allowedOrigin);
        }
        foreach ($this->allowedMethods as $allowedMethod) {
            $xmlRule->addChild(CorsConfig::OSS_CORS_ALLOWED_METHOD, $allowedMethod);
        }
        foreach ($this->allowedHeaders as $allowedHeader) {
            $xmlRule->addChild(CorsConfig::OSS_CORS_ALLOWED_HEADER, $allowedHeader);
        }
        foreach ($this->exposeHeaders as $exposeHeader) {
            $xmlRule->addChild(CorsConfig::OSS_CORS_EXPOSE_HEADER, $exposeHeader);
        }
        $xmlRule->addChild(CorsConfig::OSS_CORS_MAX_AGE_SECONDS, strval($this->maxAgeSeconds));
    }

    private array $allowedHeaders = array();
    private array $allowedOrigins = array();
    private array $allowedMethods = array();
    private array $exposeHeaders = array();
    private ?int $maxAgeSeconds = null;
}