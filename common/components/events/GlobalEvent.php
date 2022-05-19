<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-15 22:50:42
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-19 23:00:29
 */

namespace common\components\events;

use common\helpers\loggingHelper;
use yii\base\Component;
use Yii;
use yii\base\ErrorException;

/**
 * @author Skilly
 */
class GlobalEvent extends Component
{
    // 定义事件名
    const EVENT_ADDONS_SERVICE = 'serviceEvents';


    public function run()
    {  
        $this->trigger(self::EVENT_ADDONS_SERVICE);
    }
}
