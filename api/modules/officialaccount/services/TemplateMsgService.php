<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2022-04-27 15:31:25
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-27 15:35:08
 */


namespace api\modules\officialaccount\services;

use Yii;
use yii\web\UnprocessableEntityHttpException;
use common\services\BaseService;
use addons\Wechat\common\models\FormId;
use addons\Wechat\common\queues\WechatTemplateMsgJob;

/**
 * Class TemplateMsgService
 * @package addons\Wechat\services
 * @author kbdxbt
 */
class TemplateMsgService  extends BaseService
{
    /**
     * formid保留次数
     * @var int
     */
    public $form_count = 10;

    /**
     * 消息队列
     *
     * @var bool
     */
    public $queueSwitch = false;

    /**
     * 发送模板消息
     *
     * ```php
     *       Yii::$app->wechatService->TemplateMsg->send($data)
     * ```
     *
     * @param array $data 模板数据
     * @return bool|string|null
     * @throws UnprocessableEntityHttpException
     */
    public function send($data)
    {
        if ($this->queueSwitch == true) {
            $messageId = Yii::$app->queue->push(new WechatTemplateMsgJob([
                'data' => $data,
            ]));

            return $messageId;
        }

        return $this->realSend($data);
    }

    /**
     * 发送 (发送不成功请先检查系统微信参数是否配置)
     * 微信小程序统一服务消息接口（格式参考文档：https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/uniform-message/uniformMessage.send.html）
     * 微信公众号模板消息（格式参考文档：https://developers.weixin.qq.com/doc/offiaccount/Message_Management/Template_Message_Interface.html）
     *
     * @param $data
     * @return bool
     * @throws UnprocessableEntityHttpException
     */
    public function realSend($data)
    {
        try {
            if (isset($data['weapp_template_msg']) || isset($data['mp_template_msg'])) {
                // 微信小程序统一服务消息接口
                $result = Yii::$app->wechat->miniProgram->uniform_message->send($data);
            } else {
                // 微信公众号模板消息
                $result = Yii::$app->wechat->app->template_message->send($data);
            }

            Yii::info($result);
            if ($result['errcode'] != 0) {
                throw new UnprocessableEntityHttpException('模板消息发送失败:' . $result['errcode']);
            }

            return true;
        } catch (\Exception $e) {
            Yii::error($e->getMessage());
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }

    /**
     * 获取formid
     *
     * @param $member_id
     * @return mixed
     * @throws UnprocessableEntityHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function getFormId($member_id)
    {
        $model = FormId::find()
            ->filterWhere(['merchant_id' => $this->getMerchantId()])
            ->andWhere(['member_id' => $member_id])
            ->andWhere(['>', 'stoped_at', time()])
            ->orderBy('created_at asc')
            ->one();

        if (!$model) {
            throw new \yii\web\UnprocessableEntityHttpException('未找到formid');
        }

        $form_id = $model->form_id;
        $model->delete();

        return $form_id;
    }

    /**
     * 存储formid
     *
     * @param FormId $model
     * @return bool
     */
    public function addFormId(FormId $model)
    {
        $count = FormId::find()
            ->filterWhere(['merchant_id' => $this->getMerchantId()])
            ->andWhere(['member_id' => $model->member_id])
            ->andWhere(['>', 'stoped_at', time()])
            ->count();

        if ($count < $this->form_count) {
            return $model->save();
        }

        return false;
    }
}