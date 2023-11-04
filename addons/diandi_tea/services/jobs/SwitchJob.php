<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-11 00:34:06
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-24 15:43:35
 */

namespace addons\diandi_tea\services\jobs;

use addons\diandi_tea\services\diandiLockSdk;
use common\components\Job;
use common\helpers\loggingHelper;
use GuzzleHttp\Client;

/**
 * 订单处理任务
 *
 * @date 2022-05-28
 *
 * @example
 *
 * @author Wang Chunsheng
 *
 * @since
 */
class SwitchJob extends Job
{
    public int $ext_room_id;
    public int  $switch_type;
    public int $switch_time_renew;
    public int $ext_event_id;
    public bool $is_queue;

    /**
     * @param \yii\queue\Queue $queue
     *
     * @return void
     *
     */
    public function execute($queue)
    {
        
        $ext_room_id = $this->ext_room_id;
        $switch_type  = $this->switch_type;
        $switch_time_renew = $this->switch_time_renew;
        $ext_event_id = $this->ext_event_id;
        $is_queue = $this->is_queue;

        $diandiLockSdk = new diandiLockSdk();
        // 增加5个关灯任务
        for ($i=0; $i <5 ; $i++) { 
            $switch_time_renew += 5*60; 
            $diandiLockSdk->switchStatue($ext_room_id, $switch_type, $switch_time_renew, $ext_event_id, $is_queue);
        }
    }
}
