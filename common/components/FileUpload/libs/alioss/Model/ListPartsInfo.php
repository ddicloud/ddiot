<?php

namespace Alioss\Model;

/**
 * Class ListPartsInfo
 * @package OSS\Model
 * @link http://help.aliyun.com/document_detail/oss/api-reference/multipart-upload/ListParts.html
 */
class ListPartsInfo
{

    /**
     * ListPartsInfo constructor.
     * @param string $bucket
     * @param string $key
     * @param string $uploadId
     * @param int $nextPartNumberMarker
     * @param int $maxParts
     * @param string $isTruncated
     * @param array $listPart
     */
    public function __construct(string $bucket, string $key, string $uploadId, int $nextPartNumberMarker, int $maxParts, string $isTruncated, array $listPart)
    {
        $this->bucket = $bucket;
        $this->key = $key;
        $this->uploadId = $uploadId;
        $this->nextPartNumberMarker = $nextPartNumberMarker;
        $this->maxParts = $maxParts;
        $this->isTruncated = $isTruncated;
        $this->listPart = $listPart;
    }

    /**
     * @return string
     */
    public function getBucket(): string
    {
        return $this->bucket;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getUploadId(): string
    {
        return $this->uploadId;
    }

    /**
     * @return int
     */
    public function getNextPartNumberMarker(): int
    {
        return $this->nextPartNumberMarker;
    }

    /**
     * @return int
     */
    public function getMaxParts(): int
    {
        return $this->maxParts;
    }

    /**
     * @return string
     */
    public function getIsTruncated(): string
    {
        return $this->isTruncated;
    }

    /**
     * @return array
     */
    public function getListPart(): array
    {
        return $this->listPart;
    }

    private string $bucket = "";
    private string $key = "";
    private string $uploadId = "";
    private int $nextPartNumberMarker = 0;
    private int $maxParts = 0;
    private string $isTruncated = "";
    private array $listPart = array();
}