<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-15 22:50:42
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-19 23:01:41
 */

namespace common\components\events;

use common\helpers\loggingHelper;
use yii\base\Component;
use Yii;
use yii\base\ErrorException;

/**
 * @author Skilly
 */
class ServiceEvent extends Component
{
    // 定义事件名
    const EVENT_ADDONS_SERVICE = 'serviceEvents';

    public $_addons;
    // public function addons($addons,$serviceClassName,$action,$params)
    public function addons($event)
    {
        if(!empty($event->data['addons'])){
            $namespace = 'addons\\'.$event->data['addons'].'\\services\\';
            $serviceClassName = $event->data['serviceClassName'];
            $ClassName = $namespace.$serviceClassName;
            
            if(class_exists($ClassName)){
                $service = Yii::createObject([
                    'class' => $ClassName,
                ]);
                $action = $event->data['action'];
                try {
                    $Res = call_user_func_array([$service, $action], $event->data['params']);
                    $this->trigger(self::EVENT_ADDONS_SERVICE);
        
                    return $Res;
                } catch (\Exception $e) {
                    throw $e;
                }
            }else{
                throw new ErrorException('插件不存在', 404);
            }
        }
        
        $this->trigger(self::EVENT_ADDONS_SERVICE);

    }
}
