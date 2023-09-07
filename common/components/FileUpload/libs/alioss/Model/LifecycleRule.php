<?php

namespace Alioss\Model;


/**
 * Class LifecycleRule
 * @package OSS\Model
 *
 * @link http://help.aliyun.com/document_detail/oss/api-reference/bucket/PutBucketLifecycle.html
 */
class LifecycleRule
{
    /**
     * 得到规则ID
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id 规则ID
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * 得到文件前缀
     *
     * @return string
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * 设置文件前缀
     *
     * @param string $prefix 文件前缀
     */
    public function setPrefix(string $prefix): void
    {
        $this->prefix = $prefix;
    }

    /**
     * Lifecycle规则的状态
     *
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * 设置Lifecycle规则状态
     *
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     *
     * @return LifecycleAction[]
     */
    public function getActions(): array
    {
        return $this->actions;
    }

    /**
     * @param LifecycleAction[] $actions
     */
    public function setActions(array $actions): void
    {
        $this->actions = $actions;
    }


    /**
     * LifecycleRule constructor.
     *
     * @param string $id 规则ID
     * @param string $prefix 文件前缀
     * @param string $status 规则状态，可选[self::LIFECYCLE_STATUS_ENABLED, self::LIFECYCLE_STATUS_DISABLED]
     * @param LifecycleAction[] $actions
     */
    public function __construct(string $id, string $prefix, string $status, array $actions)
    {
        $this->id = $id;
        $this->prefix = $prefix;
        $this->status = $status;
        $this->actions = $actions;
    }

    /**
     * @param \SimpleXMLElement $xmlRule
     */
    public function appendToXml(\SimpleXMLElement &$xmlRule): void
    {
        $xmlRule->addChild('ID', $this->id);
        $xmlRule->addChild('Prefix', $this->prefix);
        $xmlRule->addChild('Status', $this->status);
        foreach ($this->actions as $action) {
            $action->appendToXml($xmlRule);
        }
    }

    private string $id;
    private string $prefix;
    private string $status;
    private array $actions = array();

    const LIFECYCLE_STATUS_ENABLED = 'Enabled';
    const LIFECYCLE_STATUS_DISABLED = 'Disabled';
}