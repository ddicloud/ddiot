<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-05-22 01:35:34
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-24 11:04:29
 */

namespace addons\diandi_example\services\MySymfonys;

use common\helpers\loggingHelper;
use common\services\BaseService;

/**
 * 事件订阅器，用于定义业务流程有关的事件.
 *
 * @date 2022-05-23
 *
 * @example
 *
 * @author Wang Chunsheng
 *
 * @since
 */
class StoreSubscriber extends BaseService
{
    public static $listeners = [
        // 主模块的业务事件
        OrderPlacedEvent::EVENT_LOCK_OPEN => [
            ['diandi_example\services\ParentEventServer:ceshi', 1],
        ],
        OrderPlacedEvent::NAME => [
            ['onStoreOrder', 0],
            ['nihaode', 2],
        ],
        'HoomService.method_is_not_found' => [
            ['aaa', 5],
        ],
    ];

    public static function getSubscribedEvents()
    {
        // print_r(self::$listeners);

        return self::$listeners;

        // return parent::getSubscribedEvents();
    }

    public function nihaode(OrderPlacedEvent $event)
    {
        echo '触发订阅nihaode'.PHP_EOL;
    }

    public function onStoreOrder(OrderPlacedEvent $event)
    {
        echo '触发订阅onStoreOrder'.PHP_EOL;

        // ...
        loggingHelper::writeLog('diandi_doorlock', 'ExceptionSubscriber', 'onStoreOrder', [
            'll' => '订阅事件',
        ]);
    }

    public function Ceshi(OrderPlacedEvent $event)
    {
        echo '触发订阅Ceshi'.PHP_EOL;
        // print_r($event->getOrder());
    }
}
