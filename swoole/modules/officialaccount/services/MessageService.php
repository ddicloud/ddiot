<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-04-27 15:31:25
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-28 14:14:19
 */

namespace ddswoole\modules\officialaccount\services;

use common\services\BaseService;
use EasyWeChat\Kernel\Messages\Text;
use Yii;

/**
 * Class MessageService.
 *
 * @author jianyan74 <751393839@qq.com>
 */
class MessageService extends BaseService
{
    protected $message;

    /**
     * 群发消息.
     *
     * @var array
     */
    protected $sendMethod = [
        'text' => 'sendText',
        'news' => 'sendNews',
        'voice' => 'sendVoice',
        'image' => 'sendImage',
        'video' => 'sendVideo',
        'card' => 'sendCard',
    ];

    /**
     * 写入消息.
     *
     * @param $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * 获取微信消息.
     *
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * 文字匹配回复.
     *
     * @return bool|mixed
     *
     * @throws \yii\web\NotFoundHttpException
     */
    public function text()
    {
        $message = Yii::$app->wechatService->message->getMessage();
        // 查询用户关键字匹配
        if (!($reply = Yii::$app->wechatService->ruleKeyword->match($message['Content']))) {
            $replyDefault = Yii::$app->wechatService->replyDefault->findOne();
            if ($replyDefault->default_content) {
                $reply = Yii::$app->wechatService->ruleKeyword->match($replyDefault->default_content);
            } else {
                return false;
            }
        }

        return $reply;
    }

    /**
     * 关注匹配回复.
     *
     * @return bool|mixed
     *
     * @throws \yii\web\NotFoundHttpException
     */
    public function follow()
    {
        $replyDefault = Yii::$app->wechatService->replyDefault->findOne();
        if ($replyDefault->follow_content) {
            return Yii::$app->wechatService->ruleKeyword->match($replyDefault->follow_content);
        }

        return false;
    }

    /**
     * 其他匹配回复.
     *
     * @return bool|mixed
     *
     * @throws \yii\web\NotFoundHttpException
     */
    public function other()
    {
        $message = $this->getMessage();
        $msgType = $message['MsgType'];

        return false;
    }
}
