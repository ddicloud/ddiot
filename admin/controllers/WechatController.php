<?php

/**
 * @Author: Wang Chunsheng 2192138785@qq.com
 * @Date:   2020-03-13 04:06:57
 * @Last Modified by:   Wang chunsheng  email:2192138785@qq.com
 * @Last Modified time: 2022-07-11 18:04:39
 */

namespace admin\controllers;

use api\controllers\AController;
use common\helpers\loggingHelper;
use common\helpers\ResultHelper;
use common\helpers\UrlHelper;
use EasyWeChat\Factory;
use Yii;

class WechatController extends AController
{
    public $modelClass = '';
    protected $authOptional = ['*'];

    public function actionAuthUrl()
    {
        global $_GPC;
        $configPath = Yii::getAlias('@admin\config\wechat.php');
        $config = [];
        if (file_exists($configPath)) {
            $config = require_once $configPath;
        }
        $data = [
            'app_id' => $config['app_id'],
            'secret' => $config['secret'],
            'token' => $config['token'],
            'aes_key' => $config['aes_key'],
          ];

        $openPlatform = Factory::openPlatform($data);

        $callback = UrlHelper::adminUrl('wechat', 'signup', [
            'bloc_id' => $_GPC['bloc_id'],
            'store_id' => $_GPC['store_id'],
        ]);

        $url = $openPlatform->getPreAuthorizationUrl($callback); // 传入回调URI即可

        return ResultHelper::json(200, '获取成功', ['url' => $url]);
    }

    public function actionSignup()
    {
        global $_GPC;

        loggingHelper::writeLog('WechatController', 'signup', '授权登录信息', $_GPC);
    }

    public function actionTick()
    {
        global $_GPC;

        loggingHelper::writeLog('WechatController', 'tick', '服务器消息处理', $_GPC);
    }
}
