<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-11 00:34:06
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-28 15:17:41
 */

namespace addons\diandi_tea\services\jobs;

use addons\diandi_tea\services\OrderService;
use common\helpers\loggingHelper;
use yii\base\BaseObject;

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
class Orderobs extends BaseObject implements \yii\queue\JobInterface
{
    /**
     * 定时处理.
     *
     * @var int
     */
    public int $order_id;

    /**
     * @param \yii\queue\Queue $queue
     *
     * @return void
     *
     */
    public function execute($queue): void
    {
        loggingHelper::writeLog('diandi_tea', 'Orderobs', '订单支付倒计时任务', [
            'order_id' => $this->order_id,
            'queue' => $queue,
        ]);

        OrderService::cancelOrder($this->order_id);
    }
}
