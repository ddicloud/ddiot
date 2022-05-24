<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-05-22 00:16:37
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-24 11:04:22
 */

namespace addons\diandi_example\services\MySymfonys;

use common\components\events\DdListener;
use common\components\events\eventObjs\DdEvent;

class AcmeListener extends DdListener
{
    // ...

    public function onFooAction(DdEvent $event, $eventName)
    {
        echo '监听器/'.$eventName.'#'.PHP_EOL;
        // print_r($event);
        // ... do something 做一些事
    }
}
