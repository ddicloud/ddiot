<?php

namespace Alioss\Result;

use Alioss\Core\OssException;
use Alioss\Core\OssUtil;
use Alioss\Model\ObjectInfo;
use Alioss\Model\ObjectListInfo;
use Alioss\Model\PrefixInfo;
use yii\base\ErrorException;

/**
 * Class ListObjectsResult
 * @package OSS\Result
 */
class ListObjectsResult extends Result
{
    /**
     * 解析ListObjects接口返回的xml数据
     *
     * return ObjectListInfo
     * @throws ErrorException
     */
    protected function parseDataFromResponse(): ObjectListInfo
    {
        try {
            $xml = new \SimpleXMLElement($this->rawResponse->body);

        $encodingType = isset($xml->EncodingType) ? strval($xml->EncodingType) : "";
        $objectList = $this->parseObjectList($xml, $encodingType);
        $prefixList = $this->parsePrefixList($xml, $encodingType);
        $bucketName = isset($xml->Name) ? strval($xml->Name) : "";
        $prefix = isset($xml->Prefix) ? strval($xml->Prefix) : "";
        $prefix = OssUtil::decodeKey($prefix, $encodingType);
        $marker = isset($xml->Marker) ? strval($xml->Marker) : "";
        $marker = OssUtil::decodeKey($marker, $encodingType);
        $maxKeys = isset($xml->MaxKeys) ? intval($xml->MaxKeys) : 0;
        $delimiter = isset($xml->Delimiter) ? strval($xml->Delimiter) : "";
        $delimiter = OssUtil::decodeKey($delimiter, $encodingType);
        $isTruncated = isset($xml->IsTruncated) ? strval($xml->IsTruncated) : "";
        $nextMarker = isset($xml->NextMarker) ? strval($xml->NextMarker) : "";
        $nextMarker = OssUtil::decodeKey($nextMarker, $encodingType);
        return new ObjectListInfo($bucketName, $prefix, $marker, $nextMarker, $maxKeys, $delimiter, $isTruncated, $objectList, $prefixList);
        } catch (\Exception $e) {
            throw new ErrorException($e->getMessage());
        }
    }

    /**
     * @throws OssException
     */
    private function parseObjectList($xml, $encodingType): array
    {
        $retList = array();
        if (isset($xml->Contents)) {
            foreach ($xml->Contents as $content) {
                $key = isset($content->Key) ? strval($content->Key) : "";
                $key = OssUtil::decodeKey($key, $encodingType);
                $lastModified = isset($content->LastModified) ? strval($content->LastModified) : "";
                $eTag = isset($content->ETag) ? strval($content->ETag) : "";
                $type = isset($content->Type) ? strval($content->Type) : "";
                $size = isset($content->Size) ? intval($content->Size) : 0;
                $storageClass = isset($content->StorageClass) ? strval($content->StorageClass) : "";
                $retList[] = new ObjectInfo($key, $lastModified, $eTag, $type, $size, $storageClass);
            }
        }
        return $retList;
    }

    /**
     * @throws OssException
     */
    private function parsePrefixList($xml, $encodingType): array
    {
        $retList = array();
        if (isset($xml->CommonPrefixes)) {
            foreach ($xml->CommonPrefixes as $commonPrefix) {
                $prefix = isset($commonPrefix->Prefix) ? strval($commonPrefix->Prefix) : "";
                $prefix = OssUtil::decodeKey($prefix, $encodingType);
                $retList[] = new PrefixInfo($prefix);
            }
        }
        return $retList;
    }
}