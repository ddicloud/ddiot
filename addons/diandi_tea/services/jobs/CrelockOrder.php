<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-11 00:34:06
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-24 15:38:13
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
class CrelockOrder extends Job
{
    public int $member_id;
    public string $password;
    public int $ext_room_id;
    public int $start_time;
    public int $end_time;
    public int $ext_order_id;

    /**
     * @param \yii\queue\Queue $queue
     *
     * @return void
     *
     */
    public function execute($queue): void
    {
        $diandiLockSdk = new diandiLockSdk();
        $ext_order_id = $this->ext_order_id;
        $member_id = $this->member_id;
        $password = $this->password;
        $ext_room_id = $this->ext_room_id;
        $start_time = $this->start_time;
        $end_time = $this->end_time;
        $diandiLockSdk->createLockOrder($ext_order_id, $member_id, $password, $ext_room_id, $start_time, $end_time);
    }
}
