<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-05-22 00:56:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-24 11:43:20
 */

namespace addons\diandi_example\services\MySymfonys;

use Acme\Store\Order;
use common\components\events\DdHandleAddonsMethodEvent;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * The order.placed event is dispatched each time an order is created
 * in the system. 每当系统新建订单时，order.placed事件都会被派遣.
 * 需要跨越模块调度的集成DdHandleAddonsMethodEvent，不需要跨越的集成DdEvent.
 */
class OrderPlacedEvent extends DdHandleAddonsMethodEvent
{
    const NAME = 'order.nndd';
    const EVENT_LOCK_OPEN = 'foo.method_is_not_found';

    protected $order;

    protected $cc;

    public function __construct($order, $cc)
    {
        $this->order = $order;
        $this->cc = $cc;
    }

    public function setOrder()
    {
        return $this->order;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function getCc()
    {
        return $this->cc;
    }
}
