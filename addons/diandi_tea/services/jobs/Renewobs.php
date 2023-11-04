<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-11 00:34:06
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-07-01 18:30:57
 */

namespace addons\diandi_tea\services\jobs;

use addons\diandi_tea\services\NoticeService;
use common\components\Job;
use common\helpers\loggingHelper;

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
class Renewobs extends Job
{
    /**
     * 定时处理.
     *
     * @var array
     */
    public array $data;

    public string $url;

    /**
     * @param \yii\queue\Queue $queue
     *
     * @return void
     *
     */
    public function execute($queue): void
    {
        parent::init();
        loggingHelper::writeLog('diandi_tea', 'Renewobs', '小程序到期续费通知计时任务', [
            'data' => $this->data,
        ]);

        NoticeService::Renew($this->data, $this->store_id);
    }
}
