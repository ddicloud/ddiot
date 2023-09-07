<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-05-23 09:33:48
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-02 10:09:21
 */

namespace common\components\events;

use common\components\events\eventObjs\DdEvent;

/**
 * 模块事件统一调度.
 *
 * @date 2022-05-23
 *
 * @example
 *
 * @author Wang Chunsheng
 *
 * @since
 */
class DdHandleAddonsMethodEvent extends DdEvent
{
    protected object $subject;
    protected string $method;
    protected array $arguments;
    protected array $returnValue;
    protected bool $isProcessed = false;

    public function __construct($subject, $method, $arguments)
    {
        $this->subject = $subject;
        $this->method = $method;
        $this->arguments = $arguments;
        echo '调度开始'.PHP_EOL;
    }

    public function __set($property_name, $value)
    {
        $this->$property_name = $value;
    }

    public function __get($property_name)
    {
        return isset($this->$property_name) ? $this->$property_name : null;
    }

    public function __isset($property_name)
    {
        return isset($this->$property_name);
    }

    public function __unset($property_name)
    {
        unset($this->$property_name);
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
     * 设置返回值，同时中止向其他监听发送通知.
     */
    public function setReturnValue($val)
    {
        $this->returnValue = $val;
        $this->isProcessed = true;
        $this->stopPropagation();
    }

    public function getReturnValue()
    {
        $action = $this->getMethod();
        $service = $this->getSubject();
        // $this->getArguments()
        // call_user_func();
        // $Res = call_user_func_array([$service, $action], [$this->getArguments()]);
        $Res = $service->$action($this->getArguments());
        // call_user_func_array([$service, $action], [$this->getArguments()]);

        return $Res;
    }

    public function isProcessed()
    {
        return $this->isProcessed;
    }
}
