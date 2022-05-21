<?php

/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-01-22 22:11:27
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-21 12:01:36
 */

namespace addons\diandi_example\services;

use common\components\events\eventObjs\MessageEvent;
use common\helpers\loggingHelper;
use common\services\BaseService;
use Yii;

class ParentEventServer extends BaseService
{
    const EVENT_LOCK_OPEN = 'diandi_im.ccce';

    public function ceshi($params)
    {
        echo '父级第一个输出';
        $store = Yii::$app->service->commonGlobalsService->getStoreDetail(80);
        print_r($store);
        print_r($params->data);
        loggingHelper::writeLog('diandi_doorlock', 'HoomService', '行为测试', $params);
        $model = new self();

        $MessageEvent = new MessageEvent();
        //触发己的事件
        $model->trigger(self::EVENT_LOCK_OPEN, $MessageEvent);
        // 移除己的事件
        $model->off(self::EVENT_LOCK_OPEN);


        return ['data'=>'456'];
    }
}
