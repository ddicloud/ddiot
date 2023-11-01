<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-09 01:32:28
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2021-09-14 15:22:37
 */

namespace api\modules\officialaccount\controllers;

use Yii;
use api\controllers\AController;
use common\helpers\ResultHelper;

/**
 * Default controller for the `officialaccount` module.
 */
class JssdkController extends AController
{
    protected array $authOptional = ['config'];
    public $modelClass = 'api\modules\wechat\models\DdWxappFans';


    public function actionConfig(): array
    {
        global $_GPC;
        $app = Yii::$app->wechat->app;
        $APIs = [
            'checkJsApi',
            'onMenuShareTimeline',
            'onMenuShareAppMessage',
            'onMenuShareQQ',
            'onMenuShareWeibo',
            'hideMenuItems',
            'showMenuItems',
            'hideAllNonBaseMenuItem',
            'showAllNonBaseMenuItem',
            'translateVoice',
            'startRecord',
            'stopRecord',
            'onRecordEnd',
            'playVoice',
            'pauseVoice',
            'stopVoice',
            'uploadVoice',
            'downloadVoice',
            'chooseImage',
            'previewImage',
            'uploadImage',
            'downloadImage',
            'getNetworkType',
            'openLocation',
            'getLocation',
            'hideOptionMenu',
            'showOptionMenu',
            'closeWindow',
            'scanQRCode',
            'chooseWXPay',
            'openProductSpecificView',
            'addCard',
            'chooseCard',
            'openCard',
            'openAddress'
        ];




        if (!empty(Yii::$app->request->input('url'))) {
            $app->jssdk->setUrl(Yii::$app->request->input('url'));
        }

        $openTagList = [
            'wx-open-launch-App'
        ];
        // $App->jssdk->buildConfig(array $APIs, $debug = false, $beta = false, $json = true, array $openTagList = []);
        $configs = $app->jssdk->buildConfig($APIs, false, false, false, $openTagList);

        return ResultHelper::json(200, '获取成功', $configs);
    }
}
