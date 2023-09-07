<?php

namespace Alioss\Model;

/**
 * Class ListMultipartUploadInfo
 * @package OSS\Model
 *
 * @link http://help.aliyun.com/document_detail/oss/api-reference/multipart-upload/ListMultipartUploads.html
 */
class ListMultipartUploadInfo
{
    /**
     * ListMultipartUploadInfo constructor.
     *
     * @param string $bucket
     * @param string $keyMarker
     * @param string $uploadIdMarker
     * @param string $nextKeyMarker
     * @param string $nextUploadIdMarker
     * @param string $delimiter
     * @param string $prefix
     * @param int $maxUploads
     * @param string $isTruncated
     * @param array $uploads
     */
    public function __construct(string $bucket, string $keyMarker, string $uploadIdMarker, string $nextKeyMarker, string $nextUploadIdMarker, string $delimiter, string $prefix, int $maxUploads, string $isTruncated, array $uploads)
    {
        $this->bucket = $bucket;
        $this->keyMarker = $keyMarker;
        $this->uploadIdMarker = $uploadIdMarker;
        $this->nextKeyMarker = $nextKeyMarker;
        $this->nextUploadIdMarker = $nextUploadIdMarker;
        $this->delimiter = $delimiter;
        $this->prefix = $prefix;
        $this->maxUploads = $maxUploads;
        $this->isTruncated = $isTruncated;
        $this->uploads = $uploads;
    }

    /**
     * 得到bucket名称
     *
     * @return string
     */
    public function getBucket(): string
    {
        return $this->bucket;
    }

    /**
     * @return string
     */
    public function getKeyMarker(): string
    {
        return $this->keyMarker;
    }

    /**
     *
     * @return string
     */
    public function getUploadIdMarker(): string
    {
        return $this->uploadIdMarker;
    }

    /**
     * @return string
     */
    public function getNextKeyMarker(): string
    {
        return $this->nextKeyMarker;
    }

    /**
     * @return string
     */
    public function getNextUploadIdMarker(): string
    {
        return $this->nextUploadIdMarker;
    }

    /**
     * @return string
     */
    public function getDelimiter(): string
    {
        return $this->delimiter;
    }

    /**
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * @return int
     */
    public function getMaxUploads(): int
    {
        return $this->maxUploads;
    }

    /**
     * @return string
     */
    public function getIsTruncated(): string
    {
        return $this->isTruncated;
    }

    /**
     * @return UploadInfo[]
     */
    public function getUploads(): array
    {
        return $this->uploads;
    }

    private string $bucket = "";
    private string $keyMarker = "";
    private string $uploadIdMarker = "";
    private string $nextKeyMarker = "";
    private string $nextUploadIdMarker = "";
    private string $delimiter = "";
    private string $prefix = "";
    private int $maxUploads = 0;
    private string $isTruncated = "false";
    private array $uploads = array();
}