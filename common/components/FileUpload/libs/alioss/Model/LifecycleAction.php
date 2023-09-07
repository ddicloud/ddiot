<?php

namespace Alioss\Model;

/**
 * Class LifecycleAction
 * @package OSS\Model
 * @link http://help.aliyun.com/document_detail/oss/api-reference/bucket/PutBucketLifecycle.html
 */
class LifecycleAction
{
    /**
     * LifecycleAction constructor.
     * @param string $action
     * @param string $timeSpec
     * @param string $timeValue
     */
    public function __construct(string $action, string $timeSpec, string $timeValue)
    {
        $this->action = $action;
        $this->timeSpec = $timeSpec;
        $this->timeValue = $timeValue;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param string $action
     */
    public function setAction(string $action): void
    {
        $this->action = $action;
    }

    /**
     * @return string
     */
    public function getTimeSpec()
    {
        return $this->timeSpec;
    }

    /**
     * @param string $timeSpec
     */
    public function setTimeSpec(string $timeSpec): void
    {
        $this->timeSpec = $timeSpec;
    }

    /**
     * @return string
     */
    public function getTimeValue(): string
    {
        return $this->timeValue;
    }

    /**
     * @param string $timeValue
     */
    public function setTimeValue(string $timeValue): void
    {
        $this->timeValue = $timeValue;
    }

    /**
     * appendToXml 把actions插入到xml中
     *
     * @param \SimpleXMLElement $xmlRule
     */
    public function appendToXml(\SimpleXMLElement &$xmlRule): void
    {
        $xmlAction = $xmlRule->addChild($this->action);
        $xmlAction->addChild($this->timeSpec, $this->timeValue);
    }

    private string $action;
    private string $timeSpec;
    private string $timeValue;

}