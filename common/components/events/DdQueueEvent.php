<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-11 00:34:06
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-05-22 17:45:53
 */


namespace addons\diandi_doorlock\services\jobs;

use common\helpers\loggingHelper;
use Yii;
use yii\base\BaseObject;

/**
 * https://www.shiqidu.com/d/969
 * Class LogJob
 * @package common\queues
 * @author wangchunsheng <2192138785@qq.com>
 */
class DdQueueEvent extends BaseObject implements \yii\queue\JobInterface
{
    /**
     * 日志记录数据
     *
     * @var
     */
    public array $data;

    /**
     * @param \yii\queue\Queue $queue
     * @return void
     * @throws \yii\base\InvalidConfigException
     */
    public function execute($queue): void
    {
        

        loggingHelper::writeLog('diandi_doorlock','services','\jobs',[
            'data'=>$this->data,
            'queue'=>$queue
        ]);
        Yii::$app->services->log->realCreate($this->data);
    }
}