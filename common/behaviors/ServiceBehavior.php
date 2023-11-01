<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-05-15 22:50:42
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-19 22:57:42
 */

namespace common\behaviors;

use common\helpers\loggingHelper;
use Yii;
use yii\base\Behavior;
use yii\base\ErrorException;
use yii\base\InvalidConfigException;

/**
 * @author Skilly
 */
class ServiceBehavior extends Behavior
{
    // 定义事件名
    const EVENT_ADDONS_SERVICE = 'serviceEvents';

    public string $addons = '';

    public string $serviceClassName = '';

    public string $action = '';

    public array $params = [];

    public function init(): void
   {
        // if ($this->addons || $this->serviceClassName || $this->action || $this->params) {
        // }
    }

    //@see http://www.yiichina.com/doc/api/2.0/yii-base-behavior#events()-detail
    public function events(): array
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

        $namespace = 'addons\\'.$this->addons.'\\services\\';
        $serviceClassName = $this->serviceClassName;


        try {
            $service = Yii::createObject([
                'class' => $namespace . $serviceClassName,
            ]);
            $action = $this->action;
            return call_user_func_array([$service, $action], $this->params);
        } catch (InvalidConfigException $e) {
            throw new ErrorException($e->getMessage());
        }

    }
}
