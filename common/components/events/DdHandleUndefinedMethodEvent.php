<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-05-23 09:33:48
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-23 09:34:18
 */
namespace addons\diandi_doorlock\services\jobs;

use Symfony\Component\EventDispatcher\Event;
 
class DdHandleUndefinedMethodEvent extends Event
{
    protected $subject;
    protected $method;
    protected $arguments;
    protected $returnValue;
    protected $isProcessed = false;
 
    public function __construct($subject, $method, $arguments)
    {
        $this->subject = $subject;
        $this->method = $method;
        $this->arguments = $arguments;
    }
 
    public function getSubject()
    {
        return $this->subject;
    }
 
    public function getMethod()
    {
        return $this->method;
    }
 
    public function getArguments()
    {
        return $this->arguments;
    }
 
    /**
     * Sets the value to return and stops other listeners from being notified
     * 设置返回值，同时中止向其他监听发送通知
     */
    public function setReturnValue($val)
    {
        $this->returnValue = $val;
        $this->isProcessed = true;
        $this->stopPropagation();
    }
 
    public function getReturnValue()
    {
        return $this->returnValue;
    }
 
    public function isProcessed()
    {
        return $this->isProcessed;
    }
}