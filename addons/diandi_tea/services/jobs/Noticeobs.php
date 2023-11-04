<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-11 00:34:06
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-02 18:22:54
 */

namespace addons\diandi_tea\services\jobs;

use common\components\Job;
use common\helpers\loggingHelper;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use yii\queue\Queue;

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
class Noticeobs extends Job
{
    /**
     * 定时处理.
     *
     * @var array
     */
    public array $data;

    public string $url;

    /**
     * @param Queue $queue
     *
     * @return void
     * @throws GuzzleException
     */
    public function execute($queue): void
    {
        loggingHelper::writeLog('diandi_tea', 'Noticeobs', '小程序通知计时任务', [
            'data' => $this->data,
        ]);

        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => $this->url,
            // You can set any number of default request options.
            'timeout' => 5.0,
        ]);
        $datas = $this->data;
        $res = $client->request('POST', '', [
            'json' => [
                'data' => $datas,
            ],
            // 'headers' => $headers,
        ]);

        $body = $res->getBody();
        $remainingBytes = $body->getContents();
    }
}
