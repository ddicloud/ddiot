<?php

namespace Alioss\Model;


/**
 * Class LoggingConfig
 * @package OSS\Model
 * @link http://help.aliyun.com/document_detail/oss/api-reference/bucket/PutBucketLogging.html
 */
class LoggingConfig implements XmlConfig
{
    /**
     * LoggingConfig constructor.
     * @param null $targetBucket
     * @param null $targetPrefix
     */
    public function __construct($targetBucket = null, $targetPrefix = null)
    {
        $this->targetBucket = $targetBucket;
        $this->targetPrefix = $targetPrefix;
    }

    /**
     * @param string $strXml
     * @return void
     */
    public function parseFromXml(string $strXml): void
    {
        $xml = simplexml_load_string($strXml);
        if (!isset($xml->LoggingEnabled)) return;
        foreach ($xml->LoggingEnabled as $status) {
            foreach ($status as $key => $value) {
                if ($key === 'TargetBucket') {
                    $this->targetBucket = strval($value);
                } elseif ($key === 'TargetPrefix') {
                    $this->targetPrefix = strval($value);
                }
            }
            break;
        }
    }

    /**
     *  序列化成xml字符串
     *
     */
    public function serializeToXml(): bool|string
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><BucketLoggingStatus></BucketLoggingStatus>');
        if (isset($this->targetBucket) && isset($this->targetPrefix)) {
            $loggingEnabled = $xml->addChild('LoggingEnabled');
            $loggingEnabled->addChild('TargetBucket', $this->targetBucket);
            $loggingEnabled->addChild('TargetPrefix', $this->targetPrefix);
        }
        return $xml->asXML();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->serializeToXml();
    }

    /**
     * @return string|null
     */
    public function getTargetBucket(): ?string
    {
        return $this->targetBucket;
    }

    /**
     * @return string|null
     */
    public function getTargetPrefix(): ?string
    {
        return $this->targetPrefix;
    }

    private ?string $targetBucket = "";
    private ?string $targetPrefix = "";

}