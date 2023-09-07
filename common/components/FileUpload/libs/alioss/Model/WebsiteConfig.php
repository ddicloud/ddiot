<?php

namespace Alioss\Model;


use Alioss\Core\OssException;


/**
 * Class WebsiteConfig
 * @package OSS\Model
 * @link http://help.aliyun.com/document_detail/oss/api-reference/bucket/PutBucketWebsite.html
 */
class WebsiteConfig implements XmlConfig
{
    /**
     * WebsiteConfig constructor.
     * @param string $indexDocument
     * @param string $errorDocument
     */
    public function __construct(string $indexDocument = "", string $errorDocument = "")
    {
        $this->indexDocument = $indexDocument;
        $this->errorDocument = $errorDocument;
    }

    /**
     * @param string $strXml
     * @return null
     */
    public function parseFromXml(string $strXml)
    {
        $xml = simplexml_load_string($strXml);
        if (isset($xml->IndexDocument->Suffix)) {
            $this->indexDocument = strval($xml->IndexDocument->Suffix);
        }
        if (isset($xml->ErrorDocument->Key)) {
            $this->errorDocument = strval($xml->ErrorDocument->Key);
        }
    }

    /**
     * 把WebsiteConfig序列化成xml
     *
     * @return string
     */
    public function serializeToXml(): string
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><WebsiteConfiguration></WebsiteConfiguration>');
        $index_document_part = $xml->addChild('IndexDocument');
        $error_document_part = $xml->addChild('ErrorDocument');
        $index_document_part->addChild('Suffix', $this->indexDocument);
        $error_document_part->addChild('Key', $this->errorDocument);
        return $xml->asXML();
    }

    /**
     * @return string
     */
    public function getIndexDocument(): string
    {
        return $this->indexDocument;
    }

    /**
     * @return string
     */
    public function getErrorDocument(): string
    {
        return $this->errorDocument;
    }

    private string $indexDocument = "";
    private string $errorDocument = "";
}