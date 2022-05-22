<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-05-20 21:15:23
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-22 13:13:21
 */

namespace common\components\events\Interfaces;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

interface DdInterface extends EventSubscriberInterface
{
    const EVENT_BEFORE_SERVER = 'beforeServer';
    const EVENT_AFTER_SERVER = 'afterServer';

    public static function getSubscribedEvents();
}
