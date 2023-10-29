<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-05-22 00:56:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-16 19:50:22
 */

namespace common\plugins\diandi_hub\services\events;

use Acme\Store\Order;
use common\components\events\DdHandleAddonsMethodEvent;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * The order.placed event is dispatched each time an order is created
 * in the system. 每当系统新建订单时，order.placed事件都会被派遣.
 * 需要跨越模块调度的集成DdHandleAddonsMethodEvent，不需要跨越的集成DdEvent.
 */
class DdOrderEvent extends DdHandleAddonsMethodEvent
{
    const EVENT_NAME = 'diandi_hub.order';
    
    const EVENT_ORDER_CREATE = 'diandi_hub.order_create';

    protected $order;

    protected $user_id;
    protected $cartIds;
    protected $total_price;
    protected $express_price;
    protected $express_type;
    protected $address_id;
    protected $remark;
    protected $name;
    protected $phone;
    protected $delivery_time;
    protected $order_id;
    protected $unqualified_type;
    protected $advance_package_price;
    protected $advance_freight_price;
    protected $extend;
    
    protected $orderInfo;

    public function __construct($user_id, $cartIds, $total_price, $express_price, $express_type, $address_id, $remark, $name, $phone, $delivery_time, $extend = [])
    {
        $this->user_id = $user_id;
        $this->cartIds = $cartIds;
        $this->total_price = $total_price;
        $this->express_price = $express_price;
        $this->express_type = $express_type;
        $this->address_id = $address_id;
        $this->remark = $remark;
        $this->name = $name;
        $this->phone = $phone;
        $this->delivery_time = $delivery_time;
        //扩展字段
        $this->extend = $extend;
        // $this->logistics_mark = $logistics_mark;
        // $this->flower_mark = $flower_mark;
        // $this->unqualified_type = $unqualified_type;
        // $this->advance_package_price = $advance_package_price;
        // $this->advance_freight_price = $advance_freight_price;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;
    }

    public function getCc()
    {
        return $this->cc;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getOrderId()
    {
        return $this->order_id;
    }
}
