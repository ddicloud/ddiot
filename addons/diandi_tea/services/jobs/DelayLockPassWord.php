<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-11 00:34:06
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-08-24 15:38:13
 */

namespace addons\diandi_tea\services\jobs;

use common\components\Job;
use common\helpers\loggingHelper;
use diandi\iot\services\diandiSdk;
use yii\queue\Queue;

/**
 * 延期门锁密码
 *
 * @date 2022-05-28
 *
 * @example
 *
 * @author Wang Chunsheng
 *
 * @since
 */
class DelayLockPassWord extends Job
{
    public int $ext_order_id = 0;
    public int $modifyType = 1;
    public int $ext_room_id = 0;
    public int $end_time  = 0;

    /**
     * @param Queue $queue
     *
     * @return void
     *
     */
    public function execute($queue): void
    {
        $ext_order_id = $this->ext_order_id;
        $modifyType = $this->modifyType;
        $ext_room_id = $this->ext_room_id;
        $end_time = $this->end_time;
        $diandiLockSdk = new diandiSdk();
        loggingHelper::writeLog('diandi_tea','CrelockOrder','新建密码');
        $diandiLockSdk->delayPassWord($ext_order_id,$modifyType,$ext_room_id,$end_time);
    }
}
