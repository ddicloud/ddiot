<?php
/**
 * @Author: Wang chunsheng  email:2192138785@qq.com
 * @Date:   2020-07-13 01:02:19
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2020-11-13 01:12:55
 */

namespace api\modules\officialaccount\controllers;

use api\controllers\AController;
use common\helpers\FileHelper;
use common\helpers\ImageHelper;
use common\helpers\ResultHelper;
use common\services\common\QrcodeService;
use Yii;

/**
 * Default controller for the `wechat` module.
 */
class QrcodeController extends AController
{
    public $modelClass = 'api\modules\officialaccount\models\DdWechatFans';

    /**
     * Renders the index view for the module.
     *
     * @return string
     */
    public function actionGetqrcode()
    {
        global $_GPC;
        $logPath = Yii::getAlias('@runtime/officialaccount/Qrcode'.date('ymd').'.log');
        
        FileHelper::writeLog($logPath, '0002');
        
        $member_id = Yii::$app->user->identity->member_id;
        $option  = $_GPC['option'];
        $aging  = $_GPC['aging'];//1临时，2永久
        
        $app = Yii::$app->wechat->app;
        $expire_seconds = 0;
        FileHelper::writeLog($logPath, json_encode($app));
        FileHelper::writeLog($logPath, json_encode($aging));

        if($aging == 1){//临时
            $expire_seconds = 6 * 24 * 3600;
            $result = $app->qrcode->temporary($option,$expire_seconds);
        }elseif($aging == 2){//永久
            $result = $app->qrcode->forever($option);
        }

        
        FileHelper::writeLog($logPath, json_encode($result));
        

        $Qrcode = QrcodeService::createCode($aging,$result['ticket'],$option,$result['url'],$member_id,$expire_seconds);
        if($Qrcode){
            $codeUrl = $app->qrcode->url($result['ticket']);
            return ResultHelper::json(200, '获取成功', $codeUrl);
        }
    }
}
