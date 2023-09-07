<?php

namespace Alioss\Model;

/**
 * Class ObjectListInfo
 *
 * ListObjects接口返回数据
 *
 * @package OSS\Model
 * @link http://help.aliyun.com/document_detail/oss/api-reference/bucket/GetBucket.html
 */
class ObjectListInfo
{
    /**
     * ObjectListInfo constructor.
     *
     * @param string $bucketName
     * @param string $prefix
     * @param string $marker
     * @param string $nextMarker
     * @param string $maxKeys
     * @param string $delimiter
     * @param null $isTruncated
     * @param array $objectList
     * @param array $prefixList
     */
    public function __construct(string $bucketName, string $prefix, string $marker, string $nextMarker, string $maxKeys, string $delimiter, $isTruncated, array $objectList, array $prefixList)
    {
        $this->bucketName = $bucketName;
        $this->prefix = $prefix;
        $this->marker = $marker;
        $this->nextMarker = $nextMarker;
        $this->maxKeys = $maxKeys;
        $this->delimiter = $delimiter;
        $this->isTruncated = $isTruncated;
        $this->objectList = $objectList;
        $this->prefixList = $prefixList;
    }

    /**
     * @return string
     */
    public function getBucketName(): string
    {
        return $this->bucketName;
    }

    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * @return string
     */
    public function getMarker(): string
    {
        return $this->marker;
    }

    /**
     * @return int
     */
    public function getMaxKeys(): int|string
    {
        return $this->maxKeys;
    }

    /**
     * @return string
     */
    public function getDelimiter(): string
    {
        return $this->delimiter;
    }

    /**
     * @return mixed
     */
    public function getIsTruncated(): mixed
    {
        return $this->isTruncated;
    }

    /**
     * 返回ListObjects接口返回数据中的ObjectInfo列表
     *
     * @return ObjectInfo[]
     */
    public function getObjectList(): array
    {
        return $this->objectList;
    }

    /**
     * 返回ListObjects接口返回数据中的PrefixInfo列表
     *
     * @return PrefixInfo[]
     */
    public function getPrefixList(): array
    {
        return $this->prefixList;
    }

    /**
     * @return string
     */
    public function getNextMarker(): string
    {
        return $this->nextMarker;
    }

    private string $bucketName = "";
    private string $prefix = "";
    private string $marker = "";
    private string $nextMarker = "";
    private  $maxKeys = 0;
    private string $delimiter = "";
    private string |null $isTruncated = null;
    private array $objectList = array();
    private array $prefixList = array();
}