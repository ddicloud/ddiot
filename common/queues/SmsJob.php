<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2021-12-11 00:34:06
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-12-27 22:59:47
 */


namespace common\queues;

use Yii;
use yii\base\BaseObject;

/**
 * Class SmsJob
 * @package common\queues
 * @author wangchunsheng <2192138785@qq.com>
 */
class SmsJob extends BaseObject implements \yii\queue\JobInterface
{
    /**
     * @var
     */
    public $mobile;

    /**
     * @var
     */
    public $code;

    /**
     * @var
     */
    public $usage;

    /**
     * @var
     */
    public $member_id;

    /**
     * @var
     */
    public $ip;

    /**
     * @param \yii\queue\Queue $queue
     * @return mixed|void
     * @throws \yii\web\UnprocessableEntityHttpException
     */
    public function execute($queue)
    {
        Yii::$app->services->sms->realSend($this->mobile, $this->code, $this->usage, $this->member_id, $this->ip);
    }
}
