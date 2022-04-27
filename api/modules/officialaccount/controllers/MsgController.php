<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-14 22:17:14
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-04-27 16:19:44
 */

namespace api\modules\officialaccount\controllers;

use api\controllers\AController;
use api\modules\officialaccount\services\FansService;
use api\modules\officialaccount\services\MessageService;
use app\modules\officialaccount\components\Fans;
use common\helpers\FileHelper;
use common\helpers\loggingHelper;
use Yii;
use yii\web\NotFoundHttpException;

class MsgController extends AController
{
    protected $authOptional = ['*'];

    public $modelClass = 'api\modules\officialaccount\models\DdWechatFans';

    public $defaultAction = 'event';

    /**
     * 微信请求关闭CSRF验证
     *
     * @var bool
     */
    // public $enableCsrfValidation = false;

    /**
     * 只做微信公众号激活，不做其他消息处理.
     */
    public function actionEvent()
    {
        global $_GPC;
     
        $request = Yii::$app->request;
        $app = Yii::$app->wechat->getApp();
        loggingHelper::writeLog('officialaccount','actionIndex','事件监听处理',[
            'msg'=>$_GPC,
            'getMethod'=>$request->getMethod()
        ]);
        switch ($request->getMethod()) {
            // 激活公众号
            case 'GET':
                if (Fans::verifyToken($request->get('signature'), $request->get('timestamp'), $request->get('nonce'))) {
                    $response = $app->server->serve();
                    $response->send();
                }

                throw new NotFoundHttpException('签名验证失败.');
                break;
            // 接收数据
            case 'POST':
                $app->server->push(function ($message) {
                    try {
                        $MessageService = new MessageService();
                        // 微信消息
                        $MessageService->setMessage($message); // 消息记录

                        loggingHelper::writeLog('officialaccount','services','消息事件开始',[
                            'msg'=>$message,
                            'MsgType'=>$message['MsgType']
                        ]);
                        
                        switch ($message['MsgType']) {
                            case 'event': // '收到事件消息';
                                $reply = $this->event($message);
                                break;
                            case 'text': //  '收到文字消息';
                                $reply = $MessageService->text();
                                break;
                            default: // ... 其它消息(image、voice、video、location、link、file ...)
                                $reply = $MessageService->other();
                                break;
                        }

                        loggingHelper::writeLog('officialaccount','services','历史消息内容记录',[
                            'msg'=>$MessageService->getMessage()
                        ]);


                        return $reply;
                    } catch (\Exception $e) {
                        // 记录行为日志
                        loggingHelper::writeLog('officialaccount','services','记录行为日志',[
                            'msg'=>$e->getMessage()
                        ]);

                        if (YII_DEBUG) {
                            return $e->getMessage();
                        }

                        return '系统出错，请联系管理员';
                    }
                });

                // 将响应输出
                $response = $app->server->serve();
                $response->send();
                break;
            default:
                throw new NotFoundHttpException('所请求的页面不存在.');
        }

        exit();
    }

    /**
     * 事件处理.
     *
     * @param $message
     *
     * @return bool|mixed
     *
     * @throws NotFoundHttpException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    protected function event($message)
    {
        Yii::$app->params['msgHistory']['event'] = $message['Event'];
        $FansService = new FansService();
        $MessageService = new MessageService();

        switch ($message['Event']) {
            // 关注事件
            case 'subscribe':
                loggingHelper::writeLog('officialaccount','subscribe','关注事件',[
                    'msg'=>$message
                ]);
                $FansService->follow($message['FromUserName']);

                // 判断是否是二维码关注
                if ($qrResult = Yii::$app->wechatService->qrcodeStat->scan($message)) {
                    $message['Content'] = $qrResult;
                    $MessageService->setMessage($message);

                    return $MessageService->text();
                }

                return $MessageService->follow();
                break;
            // 取消关注事件
            case 'unsubscribe':
                $FansService->unFollow($message['FromUserName']);

                return false;
                break;
            // 二维码扫描事件
            case 'SCAN':
                if ($qrResult = Yii::$app->wechatService->qrcodeStat->scan($message)) {
                    $message['Content'] = $qrResult;
                    $MessageService->setMessage($message);

                    return $MessageService->text();
                }
                break;
            // 上报地理位置事件
            case 'LOCATION':

                //TODO 暂时不处理

                break;
            // 自定义菜单(点击)事件
            case 'CLICK':
                $message['Content'] = $message['EventKey'];
                $MessageService->setMessage($message);

                return $MessageService->text();
                break;
        }

        return false;
    }
}
