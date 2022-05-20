<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-05-20 21:28:53
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-20 21:29:18
 */
namespace common\components\events\eventObjs;

use yii\base\Component;
use yii\base\Event;

class MessageEvent extends Event
{
    public $message;
}