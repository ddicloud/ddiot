<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-05-20 21:28:53
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-22 13:15:20
 */

namespace common\components\events\eventObjs;

use ErrorException;
use Symfony\Contracts\EventDispatcher\Event as EventDispatcherEvent;
use Yii;

class DdEvent extends EventDispatcherEvent
{
    public $_addons;

    // public function addons($addons,$serviceClassName,$action,$params)
    public function addons($event)
    {
        if (!empty($event->data['addons'])) {
            $namespace = 'addons\\'.$event->data['addons'].'\\services\\';
            $serviceClassName = $event->data['serviceClassName'];
            $ClassName = $namespace.$serviceClassName;

            if (class_exists($ClassName)) {
                $service = Yii::createObject([
                    'class' => $ClassName,
                ]);
                $action = $event->data['action'];
                try {
                    $Res = call_user_func_array([$service, $action], $event->data['params']);

                    return $Res;
                } catch (\Exception $e) {
                    throw $e;
                }
            } else {
                throw new ErrorException('插件不存在', 404);
            }
        }
    }
}
