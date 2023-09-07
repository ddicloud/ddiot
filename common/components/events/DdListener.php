<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-05-23 09:39:50
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-10-12 18:53:09
 */

namespace common\components\events;

class DdListener
{
    public function onCall(DdHandleAddonsMethodEvent $event): void
    {
        echo 'onCall'.PHP_EOL;
        // only respond to the calls to the 'bar' method
        // 只对 'bar'方法的调用 进行响应
        // if ('bar' != $event->getMethod()) {
        //     // allow another listener to take care of this unknown method
        //     // 允许另一个监听接管这个未知方法
        //     return;
        // }

        // the subject object (the foo instance)
        // 被操作对象（主题对象。foo实例）
        $foo = $event->getSubject();
        // print_r($event);die;

        // the bar method arguments
        // bar方法的参数
        $arguments = $event->getArguments();

        // ... do something / 做一些事

        // set the return value
        // 设置返回值
        $event->setReturnValue([]);
    }
}
