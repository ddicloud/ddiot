<?php

namespace Alioss\Model;

/**
 * Class UploadInfo
 *
 * ListMultipartUpload接口得到的UploadInfo
 *
 * @package OSS\Model
 */
class UploadInfo
{
    /**
     * UploadInfo constructor.
     *
     * @param string $key
     * @param string $uploadId
     * @param string $initiated
     */
    public function __construct(string $key, string $uploadId, string $initiated)
    {
        $this->key = $key;
        $this->uploadId = $uploadId;
        $this->initiated = $initiated;
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
     * @return string
     */
    public function getInitiated(): string
    {
        return $this->initiated;
    }

    private string $key = "";
    private string $uploadId = "";
    private string $initiated = "";
}