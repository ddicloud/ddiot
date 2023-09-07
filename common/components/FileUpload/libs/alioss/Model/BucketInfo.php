<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-13 01:14:45
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-26 19:01:40
 */


namespace Alioss\Model;


/**
 * Bucket信息，ListBuckets接口返回数据
 *
 * Class BucketInfo
 * @package OSS\Model
 */
class BucketInfo
{
    /**
     * BucketInfo constructor.
     *
     * @param string $location
     * @param string $name
     * @param string $createDate
     */
    public function __construct(string $location, string $name, string $createDate)
    {
        $this->location = $location;
        $this->name = $name;
        $this->createDate = $createDate;
    }

    /**
     * 得到bucket所在的region
     *
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * 得到bucket的名称
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * 得到bucket的创建时间
     *
     * @return string
     */
    public function getCreateDate(): string
    {
        return $this->createDate;
    }

    /**
     * bucket所在的region
     *
     * @var string
     */
    private string $location;
    /**
     * bucket的名称
     *
     * @var string
     */
    private string $name;

    /**
     * bucket的创建事件
     *
     * @var string
     */
    private string $createDate;

}