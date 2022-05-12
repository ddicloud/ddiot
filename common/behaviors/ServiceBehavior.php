<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-15 22:50:42
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-12 19:51:35
 */

namespace common\behaviors;

use common\helpers\loggingHelper;
use Yii;
use yii\base\Behavior;

/**
 * @author Skilly
 */
class ServiceBehavior extends Behavior
{
    // 定义事件名
    const EVENT_ADDONS_SERVICE = 'serviceEvents';

    public function init()
    {
        global $_GPC;
    }

    //@see http://www.yiichina.com/doc/api/2.0/yii-base-behavior#events()-detail
    public function events()
    {
        return [
            self::EVENT_ADDONS_SERVICE => 'serviceEvents',
        ];
    }

    public function serviceEvents($event)
    {
        loggingHelper::writeLog('SignUpBehavior', 'SignUpBehavior', '会员存储行为', [
            'owner' => $this->owner,
            'event' => $event,
        ]);

        $namespace = 'addons\\'.$event->addons.'\\services\\';
        $serviceClassName = $event->serviceClassName;

        $service = Yii::createObject([
            'class' => $namespace.$serviceClassName,
        ]);
        $action = $event->action;
        try {
            $Res = call_user_func_array([$service, $action], $event->params);

            return $Res;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
