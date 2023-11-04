<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-11 00:34:06
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-06-30 18:45:53
 */

namespace addons\diandi_tea\services\jobs;

use addons\diandi_tea\models\config\TeaGlobalConfig;
use common\components\Job;
use common\helpers\loggingHelper;
use Yii;

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
class TeaSmsJob extends Job
{
    /**
     * 定时处理.
     *
     * @var string
     */
    public string $product;

    /**
     * @param \yii\queue\Queue $queue
     *
     * @return void
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function execute($queue): void
    {
        parent::init();
        loggingHelper::writeLog('diandi_tea', 'SmsJob', '短信通知', [
            'product' => $this->product,
            'conf' => Yii::$app->service->commonGlobalsService->getConf($this->bloc_id),
        ]);
        $store_id = $this->store_id;
        $conf = TeaGlobalConfig::find()->where(['store_id' => $store_id])->asArray()->one();
        // 短信通知
        $mobiles = explode(',', $conf['sms_mobiles']);
        $template = trim($conf['sms_order_template']);
        foreach ($mobiles as $key => $mobile) {
            $data = [
                'product' => $this->product, // '房间'.$orderInfo['hourse']['name'].',时间段：'.$orderInfo['start_time'].'至'.$orderInfo['end_time']
            ];
            $res = Yii::$app->service->apiSmsService->sendContent(trim($mobile), $data, $template);
            loggingHelper::writeLog('diandi_tea', 'SmsJob', '短信通知', [
                'res' => $res,
            ]);
        }
    }
}
