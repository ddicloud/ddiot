<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-11-14 22:17:14
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-11-20 00:25:03
 */
 

namespace api\modules\officialaccount\controllers;

use api\controllers\AController;
use Yii;
use app\modules\officialaccount\components\Fans;
use common\helpers\FileHelper;
use yii\web\NotFoundHttpException;



class MsgController extends AController
{
    
    protected $authOptional = ['index'];

    public $modelClass = 'api\modules\officialaccount\models\DdWechatFans';

    /**
     * 微信请求关闭CSRF验证
     *
     * @var bool
     */
    public $enableCsrfValidation = false;

    /**
     * 只做微信公众号激活，不做其他消息处理
     *
     */
    public function actionIndex()
    {
        global $_GPC;
        $request = Yii::$app->request;
        $logPath = Yii::getAlias('@runtime/wechat/msg/'.date('ymd').'.log');
        
        FileHelper::writeLog($logPath, '公众号激活验证');
        $app = Yii::$app->wechat->getApp();
        if($request->getMethod() ==  'GET'){
            FileHelper::writeLog($logPath, '开始验证');
            FileHelper::writeLog($logPath, '验证参数：'.json_encode([
                $request->get()
            ]));

            if (Fans::verifyToken($request->get('signature'), $request->get('timestamp'), $request->get('nonce'))) {
                FileHelper::writeLog($logPath, '验证通过');
                $response = $app->server->serve();
                $response->send();
            }
            throw new NotFoundHttpException('签名验证失败.');    
        }

        exit();
    }
}