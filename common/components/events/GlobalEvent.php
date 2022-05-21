<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-15 22:50:42
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-21 10:19:53
 */

namespace common\components\events;

use yii\base\Component;

/**
 * @author Skilly
 */
class GlobalEvent extends Component
{
    // 定义事件名
    const EVENT_GLOBAL_SERVICE = 'serviceEvents';

    public function run()
    {
        $this->trigger(self::EVENT_GLOBAL_SERVICE);
    }
}
