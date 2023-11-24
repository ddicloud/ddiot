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
 * 添加门锁密码
 *
 * @date 2022-05-28
 *
 * @example
 *
 * @author Wang Chunsheng
 *
 * @since
 */
class CreateLockPassWord extends Job
{
    public int $member_id = 0;
    public string $password = '';
    public int $ext_room_id = 0;
    public int $start_time  = 0;
    public int $end_time  = 0;
    public int $ext_order_id  = 0;

    /**
     * @param Queue $queue
     *
     * @return void
     *
     */
    public function execute($queue): void
    {
        $ext_order_id = $this->ext_order_id;
        $member_id = $this->member_id;
        $password = $this->password;
        $ext_room_id = $this->ext_room_id;
        $start_time = $this->start_time;
        $end_time = $this->end_time;
        $diandiLockSdk = new diandiSdk();
        loggingHelper::writeLog('diandi_tea','CrelockOrder','新建密码');
        $diandiLockSdk->addPassWord($ext_room_id,$ext_order_id,900,$member_id,1,$start_time,$end_time,$password);
    }
}
