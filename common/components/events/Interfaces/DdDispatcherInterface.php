<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-05-20 21:15:23
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-22 16:19:06
 */

namespace common\components\events\Interfaces;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * 调度接口
 * @date 2022-05-22
 * @example
 * @author Wang Chunsheng
 * @since
 */
interface DdDispatcherInterface extends EventDispatcherInterface
{
    const EVENT_BEFORE_SERVER = 'beforeServer';
    const EVENT_AFTER_SERVER = 'afterServer';

    public static function getSubscribedEvents();
}
