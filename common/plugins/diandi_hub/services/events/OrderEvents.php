<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-05-22 00:56:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-24 12:01:59
 */

namespace common\plugins\diandi_hub\services\events;

use common\components\events\DdHandleAddonsMethodEvent;

/**
 * 订单事件，事件中调度数据使用.
 *
 * @date 2022-05-24
 *
 * @example
 *
 * @author Wang Chunsheng
 *
 * @since
 */
class OrderEvents extends DdHandleAddonsMethodEvent
{
    const EVENT_ORDER_CREATE = 'diandi_hub.order_create';

    protected $order;

    protected $order_id;

    protected $user_id;
    protected $cartIds;
    protected $total_price;
    protected $express_price;
    protected $express_type;
    protected $address_id;
    protected $remark;
    protected $name;
    protected $phone;
    protected $delivery_ti;

    public function __construct($order_id, $order)
    {
        $this->order = $order;
        $this->order_id = $order_id;
    }

    public function setOrderId()
    {
        return $this->order_id;
    }

    public function getOrderId()
    {
        return $this->order_id;
    }

    public function setOrder()
    {
        return $this->order;
    }

    public function getOrder()
    {
        return $this->order;
    }
}
