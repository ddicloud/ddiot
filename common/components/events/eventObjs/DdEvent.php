<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-05-20 21:28:53
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-23 12:15:50
 */

namespace common\components\events\eventObjs;

use ErrorException;
// use Symfony\Component\EventDispatcher\Event;
use Symfony\Contracts\EventDispatcher\Event;
use Yii;

class DdEvent extends Event
{
    public string $_addons = '';
    
}
