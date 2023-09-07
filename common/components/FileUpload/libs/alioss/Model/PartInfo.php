<?php

namespace Alioss\Model;

/**
 * Class PartInfo
 * @package OSS\Model
 */
class PartInfo
{
    /**
     * PartInfo constructor.
     *
     * @param int $partNumber
     * @param string $lastModified
     * @param string $eTag
     * @param int $size
     */
    public function __construct(int $partNumber, string $lastModified, string $eTag, int $size)
    {
        $this->partNumber = $partNumber;
        $this->lastModified = $lastModified;
        $this->eTag = $eTag;
        $this->size = $size;
    }

    /**
     * @return int
     */
    public function getPartNumber(): int
    {
        return $this->partNumber;
    }

    /**
     * @return string
     */
    public function getLastModified(): string
    {
        return $this->lastModified;
    }

    /**
     * @return string
     */
    public function getETag(): string
    {
        return $this->eTag;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    private int $partNumber = 0;
    private string $lastModified = "";
    private string $eTag = "";
    private int $size = 0;
}